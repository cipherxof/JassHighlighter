<?php

require (__DIR__.'/../jass_keywords.php');

$language_data = Array(
    'ERROR-KEY'     => '@',
    'HIGHLIGHT-KEY' => '`',

    'IDENTIFIERS'   => Array(
                        'MEMBER'  => '.',
                        'STRUCT'  => array('STYLE' => 'JASSstruct' , "struct", "module", "keyword"),
                        'TYPE'    => array('STYLE' => 'JASStypebold', "type")
                    ),
                                    
                    // Here you can define the styles of each element
    'STYLE'         => Array(
                        'STRING'    => 'JASSstring',
                        'COMMENT'   => 'JASScomment',
                        'RAWCODE'   => 'JASSrawcode',
                        'VALUE'     => 'JASSvalue',
                        'MEMBER'    => 'JASSmember',
                        'COMPILER'  => 'JASScompiler',
                        'ERROR'     => 'JASSerror',
                        'HIGHLIGHT' => 'JASShighlight',
                        'ESCAPE'    => 'JASSescape'
                    ),

    'KEYWORDS'      => Array(
                        new KeywordGroup(explode("|", $values),     'JASSvalue'),
                        new KeywordGroup(explode("|", $operators),  'JASSoperator'),
                        new KeywordGroup(explode("|", $keywords),   'JASSkeyword'),
                        new KeywordGroup(explode("|", $blocks),     'JASSblock'),
                        new KeywordGroup(explode("|", $natives),    'JASSnative'),
                        new KeywordGroup(explode("|", $bjs),        'JASSbj'),
                        new KeywordGroup(explode("|", $constants),  'JASSconstant'),
                        new KeywordGroup(explode("|", $types),      'JASStype'),
                        new KeywordGroup(explode("|", $bjglobals),  'JASSbjglobal')
                    )
);

?>
