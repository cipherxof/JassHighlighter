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
                    'STRUCT'  => array('STYLE' => 'JASSstruct' , "struct", "module", "keyword"),
                    'TYPE'    => array('STYLE' => 'JASStypebold', "type")
                ),
                                
                // Here you can define the styles of each element
'STYLE'         => Array(
                    'STRING'    => 'JASSstring'/*'"color: blue;"';*/,
                    'COMMENT'   => 'JASScomment',
                    'RAWCODE'   => 'JASSrawcode',
                    'VALUE'     => 'JASSvalue',
                    'MEMBER'    => 'JASSmember',
                    'COMPILER'  => 'JASScompiler',
                    'ERROR'     => 'JASSerror',
                    'HIGHLIGHT' => 'JASShighlight', /* temporarily unused */
                    'ESCAPE'    => 'JASSescape'
                ),

'KEYWORDS'      => Array(
                    new KeywordGroup(explode("|", $values),     'JASSvalue'),
                    new KeywordGroup(explode("|", $operators),  'JASSoperator'),
                    new KeywordGroup(explode("|", $keywords),   'JASSkeyword'),
                    new KeywordGroup(explode("|", $blocks),     'JASSblock'),
                    new KeywordGroup(explode("|", $natives),    'JASSnative', 'http://ashinnblunts.yzi.me/testforum/jassdb_view.php?native='),
                    new KeywordGroup(explode("|", $bjs),        'JASSbj', 'http://ashinnblunts.yzi.me/testforum/jassdb_view.php?bj='),
                    new KeywordGroup(explode("|", $constants),  'JASSconstant'),
                    new KeywordGroup(explode("|", $types),      'JASStype'),
                    new KeywordGroup(explode("|", $bjglobals),  'JASSbjglobal')
                )
);

?>
