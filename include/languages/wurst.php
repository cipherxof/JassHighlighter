<?php
require (__DIR__.'/../languages/vjass.php');

$blocks     .=  "|class|while|for|in|break|package|endpackage|protected|import|nativetype|use|abstract|override|immutable|it|construct|ondestroy|destroy|init|castTo|tuple|div|mod|let|from|to|downto|step|endpackage|skip|instanceof|enum|switch|case|default|typeId|begin|end|let|new|to";
$types      .=  "|var|int|bool";
$operators  .= "|>>|<<|>|<";

$language_data['KEYWORDS'] = Array(
                new JassKeywordGroup(explode("|", $values),     'JASSvalue'),
                new JassKeywordGroup(explode("|", $operators),  'JASSoperator'),
                new JassKeywordGroup(explode("|", $keywords),   'JASSkeyword'),
                new JassKeywordGroup(explode("|", $blocks),     'JASSblock'),
                new JassKeywordGroup(explode("|", $natives),    'JASSnative'),
                new JassKeywordGroup(explode("|", $bjs),        'JASSbj'),
                new JassKeywordGroup(explode("|", $constants),  'JASSconstant'),
                new JassKeywordGroup(explode("|", $types),      'JASStype'),
                new JassKeywordGroup(explode("|", $bjglobals),  'JASSbjglobal'));
?>