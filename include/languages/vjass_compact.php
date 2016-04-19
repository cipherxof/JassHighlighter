<?php

require (__DIR__.'/../jass_keywords.php');

$language_data = Array(
// Enter the name of the language
'LANG'          => 'vjass',

// Decide if you want functions to be linked to the specified link
'FUNCTION-LINK' => false,

// Error highlighting
'ERROR-KEY'     =>  '@',

'IDENTIFIERS'   => Array(
                    'MEMBER'  => '.',
                    'STRUCT'  => array('STYLE' => 'r' , "struct", "module", "keyword"),
                    'TYPE'    => array('STYLE' => 'p', "type")
                ),
                                
                // Here you can define the styles of each element
'STYLE'         => Array(
                    'STRING'    => 'a'/*'"color: blue;"';*/,
                    'COMMENT'   => 'b',
                    'RAWCODE'   => 'c',
                    'VALUE'     => 'd',
                    'MEMBER'    => 'e',
                    'COMPILER'  => 'f',
                    'ERROR'     => 'g',
                    'HIGHLIGHT' => 'h', /* temporarily unused */
                    'ESCAPE'    => 'i'
                ),

'KEYWORDS'      => Array(
                    new KeywordGroup(explode("|", $values),     'd'),
                    new KeywordGroup(explode("|", $operators),  'j'),
                    new KeywordGroup(explode("|", $keywords),   'k'),
                    new KeywordGroup(explode("|", $blocks),     'l'),
                    new KeywordGroup(explode("|", $natives),    'm', 'http://ashinnblunts.yzi.me/testforum/jassdb_view.php?native='),
                    new KeywordGroup(explode("|", $bjs),        'n', 'http://ashinnblunts.yzi.me/testforum/jassdb_view.php?bj='),
                    new KeywordGroup(explode("|", $constants),  'o'),
                    new KeywordGroup(explode("|", $types),      'p'),
                    new KeywordGroup(explode("|", $bjglobals),  'q')
                )
);

?>
