<?php
/* 	JASS Syntax Highlighter
        By TriggerHappy
        
    This is the JASS version of my Syntax Highlighter.
    
    Syntax:
        $code = 'call CommentString("")';
        $code = new JassCode($code);
        $code = $code->parse();

*/

class JassCode{

	public $code, $language;
	
	function __construct($code, $lang='vjass')
        {
	    $this->code	    = $code;
	    $this->language = $lang;
        }
    
	function parse()
        {
            $root = dirname(__FILE__);
            
            // get the language data
            $dir   = $root . '/languages/';
            $fname = $dir  . $this->language . ".php";
        
            // require necessary files (if possible)
            require_once($dir . "Class.KeywordGroup.php");
            require(file_exists($fname) ? $fname : $dir . "nolanguage.php");	
            
            // if language isn't configured properly then return code in plain text
            if (!isset($language_data['KEYWORDS']))
                return $this->code;
		
            $keyword_group = $language_data['KEYWORDS'];
        
            // count the keyword groups
	    $keyword_group_size = count($keyword_group);
        
            // split into array with the string as the key
            for ($i = 0; $i < $keyword_group_size; $i++)
            {
                $size = count($keyword_group[$i]->keywords);
                for($j = 0; $j < $size; $j++)
                    $keyword_style[$keyword_group[$i]->keywords[$j]] = $keyword_group[$i]->style;
            }
        
	    // prep variables
            $contents 	    = html_entity_decode($this->code);
            $contents       = str_replace("?>", htmlentities("?>"), $contents);
            $contents       = str_replace("<?php", htmlentities("<?php"), $contents);
	    $output         = '';
            $inError        = false; 
            $inMacroParam   = false; 
            $compileTime    = false;
        
            // remove warnings
            error_reporting(E_ERROR | E_PARSE);
        
	    // tokenize the code
	    $tokens   = token_get_all("<?php\n$contents");
	    $arrSize  = count($tokens);
        
            // enable them
            error_reporting(E_ALL ^ E_NOTICE);
        
	    // loop through each token and process it accordingly
	    for ($i = 1; $i < $arrSize; $i++)
            {
                start:
            
		$token    = $tokens[$i]; 
		$text     = $token;
                $old      = $text;
                $init;

                $highlight_list[$i]   = $text;
            
                // assign the next token so we can look ahead
                if (is_array($tokens[$i+1]))
                {
                    $highlight_list[$i+1] = (list($v1, $v2) = $tokens[$i+1]);
                    $highlight_list[$i+1] = $v2;
                }
                else
                {
                    $highlight_list[$i+1] = $tokens[$i+1];
                }

		if (is_array($token))
		{
                    // if $token is an array, set the id and text to the respective index
                    list($id, $text)      = $token;
                    $old                  = $text;
                    $highlight_list[$i]   = $text;
                
                    // find a matching token
                    switch ($id)
                    {
                        case T_DOC_COMMENT:
                            $text = "<span style="  . $language_data['STYLE']['COMPILER']   . ">"   . $text . '</span>';
                            break;
                        case T_COMMENT:
                            if ($text[0] == "#")
                                $text = "<span style=" . $language_data['STYLE']['COMPILER'] . ">"  . $text . '</span>';
                            elseif($text[2] == "!")
                               $text = "<span style="  . $language_data['STYLE']['COMPILER'] . ">"  . $text . '</span>';
                            else
                                $text = "<span style=" . $language_data['STYLE']['COMMENT']  . ">"  . $text . '</span>';
                            break;
                        case T_NUM_STRING:
                        case T_STRING_VARNAME:
                        case T_CONSTANT_ENCAPSED_STRING:
                        case T_ENCAPSED_AND_WHITESPACE:
                            if ($text[0] == "'" && (strlen($text) == 3 || strlen($text) == 6)) // raw codes
                            {
                                $text = substr($text, 1, strlen($text)-2);
                                $text = "'<span style=" . $language_data['STYLE']['RAWCODE'] . ">"  . $text . "</span>'";
                            }
                            else // strings
                            {
                                $text = "<span style=" . $language_data['STYLE']['STRING']  . ">"   . $text . '</span>';
                            }
                            break;
                        case T_LNUMBER: // integer
                            $text = "<span style="     . $language_data['STYLE']['VALUE']   . ">"   . $text . '</span>';
                            break;
                        case T_DNUMBER: // real
                            $text = "<span style="     . $language_data['STYLE']['VALUE']   . ">"   . $text . '</span>';
                            break;
                        case T_VARIABLE: // textmacro paramaters
                            $text = "<span style="     . $language_data['STYLE']['VALUE']   . ">"   . $text;
                            if ($highlight_list[$i + 1] == '$')
                            {
                                $text .= '$</span>';
                                $i++;
                            }
                            $text .= '</span>';
                            break;
                        case T_WHITESPACE: // ignore multiple whitespaces
                            $output .= $text;
                            $highlight_list[$i] = $highlight_list[$i-1];
                            $i++;

                            goto start; // lol
                        default:
                            break;
                    }
		}
            
               // if the text hasn't been parsed yet
                if ($text == $old)
                {
                    // check for error highlighting (compileTime for wurst)
                    if ($text == $language_data['ERROR-KEY'] || $compileTime == true)
                    {
                        if ($inError) // close error highlighting
                        {
                            if ($compileTime)
                            {
                                $compileTime = false;
                                $text        = "$text</span>";
                            }
                            else $text = "</span>";
                            $inError = false;
                        }
                        else
                        {
                            if ($this->language != 'wurst')
                            {
                                $text    = "<span style=$errorStyle>";
                                $inError = true;
                            }
                            else if ($text == $language_data['ERROR-KEY'] && $this->language == 'wurst')
                            {
                                $compileTime = true;
                                $inError     = true;
                                $text        = "<span style=" . $language_data['STYLE']['MEMBER'] . ">" . $language_data['ERROR-KEY'];
                            }
                            
                        }
                    }
                    // parse keywords
                    elseif (isset($keyword_style[$text]))
                    {
                        $text = '<span style=' . $keyword_style[$text] . '>' . $text . '</span>';
                    }
                    elseif (isset($language_data['IDENTIFIERS'])){
                        // highlight struct members
                        if ($highlight_list[$i-1] == $language_data['IDENTIFIERS']['MEMBER'])
                        {
                            $text = "<span style=" . $language_data['STYLE']['MEMBER'] . ">"  . $text . '</span>';
                        }
                        // handle custom user defined structs
                        elseif (in_array($highlight_list[$i-2], $language_data['IDENTIFIERS']['STRUCT']))
                        {
                            // add the keyword to the list
                            $keyword_style[$text] = $language_data['IDENTIFIERS']['STRUCT']['STYLE'];
                            $text = "<span style=" . $language_data['IDENTIFIERS']['STRUCT']['STYLE'] . ">$text</span>";
                        }
                        // handle custom user defined types
                        elseif (in_array($highlight_list[$i-2], $language_data['IDENTIFIERS']['TYPE']))
                        {
                            $keyword_style[$text] = $language_data['IDENTIFIERS']['TYPE']['STYLE'];
                            $text = "<span style=" . $language_data['IDENTIFIERS']['TYPE']['STYLE'] . ">$text</span>";
                        }
                        // check for initializers
                        elseif ($highlight_list[$i-2] == "initializer" && ($highlight_list[$i-6] == "library" || $highlight_list[$i-6] == "scope"))
                        {
                            // set the name of the initializer
                            $init = $text;
                            $text = "<a style=\"font-weight: bold; color: #660033;\">$text</a>";
                        }
                        // find initializer function
                        elseif ($highlight_list[$i-1] == "function" && $text == $init)
                        {
                            $init = "";
                            $text = "<a style=\"font-weight: bold; color: #660033;\">$text</a>";
                        }
                        // reset the initializer if it wasn't found but the scope is ending
                        elseif ($init != "" && ($text == "endlibrary" || $text == "endscope"))
                        {
                            $init = "";
                            $text = "<span style=$blockStyle>$text</span>";
                        }
                    }
            }
            
            // append parsed text
            $output .= $text;
	}
		
        // close any un-closed <span>'s
        if ($inError)
            $output .= "</span>";
        
	return $output;
    }
}

?>
