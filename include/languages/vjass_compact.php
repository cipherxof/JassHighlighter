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
                        new JassKeywordGroup(explode("|", $values),     'd'),
                        new JassKeywordGroup(explode("|", $operators),  'j'),
                        new JassKeywordGroup(explode("|", $keywords),   'k'),
                        new JassKeywordGroup(explode("|", $blocks),     'l'),
                        new JassKeywordGroup(explode("|", $natives),    'm'),
                        new JassKeywordGroup(explode("|", $bjs),        'n'),
                        new JassKeywordGroup(explode("|", $constants),  'o'),
                        new JassKeywordGroup(explode("|", $types),      'p'),
                        new JassKeywordGroup(explode("|", $bjglobals),  'q')
                    )
);

?>
