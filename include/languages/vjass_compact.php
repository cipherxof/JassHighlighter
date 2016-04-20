<?php

require (__DIR__.'/../jass_keywords.php');

$language_data = Array(
    'ERROR-KEY'     => '@',
    'HIGHLIGHT-KEY' => '`',

    'IDENTIFIERS'   => Array(
                        'MEMBER'  => '.',
                        'STRUCT'  => array('STYLE' => 'r' , "struct", "module", "keyword"),
                        'TYPE'    => array('STYLE' => 'p', "type")
                    ),
                                    
                    // Here you can define the styles of each element
    'STYLE'         => Array(
                        'STRING'    => 'a',
                        'COMMENT'   => 'b',
                        'RAWCODE'   => 'c',
                        'VALUE'     => 'd',
                        'MEMBER'    => 'e',
                        'COMPILER'  => 'f',
                        'ERROR'     => 'g',
                        'HIGHLIGHT' => 'h',
                        'ESCAPE'    => 'i'
                    ),

    'KEYWORDS'      => Array(
                        new KeywordGroup(explode("|", $values),     'd'),
                        new KeywordGroup(explode("|", $operators),  'j'),
                        new KeywordGroup(explode("|", $keywords),   'k'),
                        new KeywordGroup(explode("|", $blocks),     'l'),
                        new KeywordGroup(explode("|", $natives),    'm'),
                        new KeywordGroup(explode("|", $bjs),        'n'),
                        new KeywordGroup(explode("|", $constants),  'o'),
                        new KeywordGroup(explode("|", $types),      'p'),
                        new KeywordGroup(explode("|", $bjglobals),  'q')
                    )
);

?>
