<?php
/*
    JassHighlighter - Syntax Highlighter for JASS2
        
        Created by TriggerHappy
*/

class JassCode
{
    public $code, $language, $tokens;
    
    function __construct($code, $lang='vjass')
    {
        $this->code     = $code;
        $this->language = $lang;
    }

    function parse($incPath=null)
    {
        // Try to load the language data file.
        if ($incPath == null)
            $incPath = dirname(__FILE__) . '/include';

        $fname = "$incPath/languages/" . $this->language . ".php";

        if (!file_exists($fname))
            return $this->code;

        require($fname);
        
        if (isset($language_data['KEYWORDS']))
        {
            $keyword_group = $language_data['KEYWORDS'];
            $keyword_group_size = count($keyword_group);

            // We split the keywords into an array with the string as the key
            // for fast lookup.
            for ($i = 0; $i < $keyword_group_size; $i++)
            {
                $size = count($keyword_group[$i]->keywords);
                
                for($j = 0; $j < $size; $j++)
                    $keyword_style[$keyword_group[$i]->keywords[$j]] = $keyword_group[$i]->style;
            }
        }
        
        // Prepare the input (JASS code).
        $contents = html_entity_decode($this->code);
        $contents = str_replace("?>", htmlentities("?>"), $contents);
        $contents = str_replace("<?php", htmlentities("<?php"), $contents);

        // The tokenizer will throw warnings for PHP syntax errors,
        // but the code is JASS so it's irrelevant.
        $error_report = error_reporting(); // store current error report level
        error_reporting(E_ERROR | E_PARSE);

        // Splitting the code up into chunks significantly reduces memory usage
        // on large inputs. This will however limit the how much can be parsed at 
        // one time, but shouldn't be an issue.
        $chunks = explode("\n", $contents);
        $chunks = array_chunk($chunks, 1024);

        $len    = count($chunks);
        $output = '';
        $inStr  = false;

        for ($chunk=0; $chunk < $len; $chunk++)
        {
            $chunkdata = $chunks[$chunk];
            $contents  = '';

            foreach($chunkdata as $data)
                $contents .= "$data\n";

            // Run the current chunk through the tokenizer.
            $this->tokens = token_get_all("<?php\n$contents");
            $token_count  = count($this->tokens);

            // Loop through each token and highlight it according to the language data.
            for ($i = 1; $i < $token_count; $i++)
            {
                $token = $this->tokens[$i];
                $text  = $token;
                $old   = $text;

                $continue = false;

                // If the token is an array, it will contain an ID
                // which tells us what type of token we are dealing with.
                if (is_array($token))
                {
                    list($id, $text) = $token;
                    $old  = $text;
                    $text = htmlspecialchars($text);

                    if ($inStr)
                        $id = T_WHITESPACE; // go to default

                    switch ($id)
                    {
                        case T_DOC_COMMENT: // doc style comments
                            $text = "<span class=" . $language_data['STYLE']['COMPILER'] . ">" . $text . '</span>';

                            break;
                        case T_COMMENT: // comment or preprocessor directives
                            $cmntype = ($text[2] == "!" ? $language_data['STYLE']['COMPILER'] : $language_data['STYLE']['COMMENT']);
                            $text    = "<span class=$cmntype>$text</span>";

                            break;
                        case T_CONSTANT_ENCAPSED_STRING:
                        case T_ENCAPSED_AND_WHITESPACE: // raw codes & strings

                            // raw codes
                            if ($text[0] == "'" && (strlen($text) == 3 || strlen($text) == 6))
                                $text = "'<span class=" . $language_data['STYLE']['RAWCODE'] . ">"  . substr($text, 1, strlen($text)-2) . "</span>'";
                             // strings
                            elseif($text[0] != "'")
                                $text = "<span class=" . $language_data['STYLE']['STRING']  . ">"   . $text . '</span>';

                            break;
                        case T_LNUMBER: // integer
                            $text = "<span class="     . $language_data['STYLE']['VALUE']   . ">"   . $text . '</span>';

                            break;
                        case T_DNUMBER: // real
                            $text = "<span class="     . $language_data['STYLE']['VALUE']   . ">"   . $text . '</span>';

                            break;
                        case T_VARIABLE: // textmacro paramaters
                            $text = "<span class="     . $language_data['STYLE']['VALUE']   . ">"   . $text;

                            if ($this->getToken($i+1) == '$')
                            {
                                $text .= '$</span>';
                                $i++;
                            }

                            $text .= '</span>';

                            break;
                        case T_WHITESPACE:  
                            $output  .= $text;
                            $continue = true; // fixes double whitespace
                            break;
                        default:
                            $continue = false;

                            break;
                    }
                }
                else
                {
                    $text = htmlspecialchars($text);

                    // Fixes bugs that can occur with php variables in strings
                    if (!$inStr && $old[0] == '"')
                    {
                        $inStr = !$inStr;
                        $text  = "<span class=" . $language_data['STYLE']['STRING']  . ">" . $text;
                    }
                    elseif ($inStr && $old[strlen($old)-1] == '"')
                    {
                        $inStr = !$inStr;
                        $text  = "$text</span>";
                    }   
                }
                
                if ($continue) continue;

                // Check for highlighting 
                if ($text == $language_data['ERROR-KEY'])
                {
                    $text = ($in_error ? "</span>" : "<span class=" . $language_data['STYLE']['ERROR'] . ">");

                    $in_error = !$in_error;
                }
                elseif ($text == $language_data['HIGHLIGHT-KEY'])
                {
                    $text = ($in_highlight ? "</span>" : "<span class=" . $language_data['STYLE']['HIGHLIGHT'] . ">");

                    $in_highlight = !$in_highlight;
                }
                // highlight struct members
                elseif (isset($language_data['IDENTIFIERS']) && $this->tokens[$i-1] == $language_data['IDENTIFIERS']['MEMBER'])
                {
                    $text = "<span class=" . $language_data['STYLE']['MEMBER'] . ">"  . $text . '</span>';
                }
                // parse keywords
                elseif (!$in_error && isset($keyword_style[$old]))
                {
                    $text = '<span class=' . $keyword_style[$old] . '>' . $text . '</span>';
                }

                $output .= $text;
            }
        }
        
        // Reset error reporting
        error_reporting($error_report);

        // Take care of any un-closed <span> tags
        if ($in_error) $output .= "</span>";
        if ($in_highlight) $output .= "</span>";

        return $output;
    }

    public function getToken($index)
    {
        $value = '';

        if (is_array($this->tokens[$index]))
        {
            $value = (list($v1, $v2) = $this->tokens[$i+$index]);
            return $value;
        }
        else
        {
            $value = $this->tokens[$index];
        }

        return $value;
    }

    private function getTokenName($index)
    {
        $token = $this->getToken($index);

        return (is_array($token) ? $token[1] : $token);
    }

    private function getTokenType($index)
    {
        $token = $this->getToken($index);
        
        return (is_array($token) ? $token[0] : false);
    }

}

class JassKeywordGroup
{
    public $keywords, $style, $link;
    
    function __construct($keywords, $style, $link="")
    {
        if (is_array($keywords))
            $this->keywords = $keywords;
        elseif (is_string($keywords))
            $this->keywords = array($keywords);
        else
            $this->keywords = array('');
        if (isset($link))
            $this->link = $link;
        
        $this->style = $style;
    }
}

?>