<?php
/*
    JassHighlighter - Syntax Highlighter for JASS2
        
        Created by TriggerHappy
*/

class JassCode
{
    public $code, $language;
    
    function __construct($code, $lang='vjass')
    {
        $this->code     = $code;
        $this->language = $lang;
    }

    function parse()
    {
        // Try to load the language data file.
        $fname = dirname(__FILE__) . '/include/languages/'  . $this->language . ".php";
        
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
        // in some cases. This will however limit the how much can be parsed at 
        // one time, but shouldn't be an issue.
        $chunks = explode("\n", $contents);
        $chunks = array_chunk($chunks, 1024);

        $len    = count($chunks);
        $output = '';

        for ($chunk=0; $chunk < $len; $chunk++)
        {
            $chunkdata = $chunks[$chunk];
            $contents  = '';

            foreach($chunkdata as $data)
                $contents .= "$data\n";

            // Run the current chunk through the tokenizer.
            $tokens      = token_get_all("<?php\n$contents");
            $token_count = count($tokens);

            // Loop through each token and highlight it according to the language data.
            for ($i = 1; $i < $token_count; $i++)
            {
                $token = $tokens[$i]; 
                $text  = $token;
                $old   = $text;

                $continue = false;

                // If the token is an array, it will contain an ID
                // which tells us what type of token we are dealing with.
                if (is_array($token))
                {
                    list($id, $text) = $token;
                    $old = $text;
                
                    switch ($id)
                    {
                        case T_DOC_COMMENT:
                            $text = "<span class=" . $language_data['STYLE']['COMPILER'] . ">" . $text . '</span>';

                            break;
                        case T_COMMENT:
                            if ($text[2] == "!")
                               $text = "<span class=" . $language_data['STYLE']['COMPILER'] . ">"  . $text . '</span>';
                            else
                                $text = "<span class=" . $language_data['STYLE']['COMMENT'] . ">"  . $text . '</span>';

                            break;
                        case T_NUM_STRING:
                        case T_STRING_VARNAME:
                        case T_CONSTANT_ENCAPSED_STRING:
                        case T_ENCAPSED_AND_WHITESPACE:
                            if ($text[0] == "'" && (strlen($text) == 3 || strlen($text) == 6)) // raw codes
                            {
                                $text = substr($text, 1, strlen($text)-2);
                                $text = "'<span class=" . $language_data['STYLE']['RAWCODE'] . ">"  . $text . "</span>'";
                            }
                            elseif($text[0] == '"')
                            {
                                $text = "<span class=" . $language_data['STYLE']['STRING']  . ">"   . $text . '</span>';
                            }

                            break;
                        case T_LNUMBER: // integer
                            $text = "<span class="     . $language_data['STYLE']['VALUE']   . ">"   . $text . '</span>';

                            break;
                        case T_DNUMBER: // real
                            $text = "<span class="     . $language_data['STYLE']['VALUE']   . ">"   . $text . '</span>';

                            break;
                        case T_VARIABLE: // textmacro paramaters
                            $text = "<span class="     . $language_data['STYLE']['VALUE']   . ">"   . $text;

                            if (JassCode::get_token($tokens, $i+1) == '$')
                            {
                                $text .= '$</span>';
                                $i++;
                            }

                            $text .= '</span>';

                            break;
                        case T_WHITESPACE: // ignore multiple whitespaces
                            $output .= $text;
                            $tokens[$i] = $tokens[$i-1];

                            $continue=true;

                            break;
                        default:
                            break;
                    }
                }
                
                if ($continue) continue;
                if ($text != $old) {  $output .= $text; continue; };

                // Check for error highlighting (compileTime for wurst)
                if ($text == $language_data['ERROR-KEY'] || $compileTime == true)
                {
                    if ($in_error) // close error highlighting
                    {
                        if ($compileTime)
                        {
                            $compileTime = false;
                            $text        = "$text</span>";
                        }
                        else $text = "</span>";

                        $in_error = false;
                    }
                    else
                    {
                        if ($this->language != 'wurst')
                        {
                            $in_error = true;
                            $text     = "<span class=" . $language_data['STYLE']['ERROR'] . ">";
                        }
                        else if ($text == $language_data['ERROR-KEY'] && $this->language == 'wurst')
                        {
                            $compileTime = true;
                            $in_error    = true;
                            $text        = "<span class=" . $language_data['STYLE']['MEMBER'] . ">" . $language_data['ERROR-KEY'];
                        }
                        
                    }
                }
                elseif ($text == $language_data['HIGHLIGHT-KEY'])
                {
                    $text = ($in_highlight ? "</span>" : "<span class=" . $language_data['STYLE']['HIGHLIGHT'] . ">");

                    $in_highlight = !$in_highlight;
                }
                elseif (!$in_error && isset($keyword_style[$text])) // parse keywords
                {
                    $text = '<span class=' . $keyword_style[$text] . '>' . $text . '</span>';
                }
                elseif (isset($language_data['IDENTIFIERS']))
                {
                    if (JassCode::get_token($tokens, $i-1) == $language_data['IDENTIFIERS']['MEMBER']) // highlight struct members
                    {
                        $text = "<span class=" . $language_data['STYLE']['MEMBER'] . ">"  . $text . '</span>';
                    }
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

    private static function get_token($tokens, $index)
    {
        $value = '';

        if (is_array($tokens[$index]))
        {
            $value = (list($v1, $v2) = $tokens[$i+$index]);
            $value = $v2;
        }
        else
        {
            $value = $tokens[$index];
        }

        return $value;
    }

}

class KeywordGroup
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
