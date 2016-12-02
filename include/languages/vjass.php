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
                        new JassKeywordGroup(explode("|", $values),     'JASSvalue'),
                        new JassKeywordGroup(explode("|", $operators),  'JASSoperator'),
                        new JassKeywordGroup(explode("|", $keywords),   'JASSkeyword'),
                        new JassKeywordGroup(explode("|", $blocks),     'JASSblock'),
                        new JassKeywordGroup(explode("|", $natives),    'JASSnative'),
                        new JassKeywordGroup(explode("|", $bjs),        'JASSbj'),
                        new JassKeywordGroup(explode("|", $constants),  'JASSconstant'),
                        new JassKeywordGroup(explode("|", $types),      'JASStype'),
                        new JassKeywordGroup(explode("|", $bjglobals),  'JASSbjglobal')
                    )
);

?>
