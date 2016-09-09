<?php
require ('vjass.php');

$blocks .=  "|class|while|for|in|break|package|endpackage|protected|import|nativetype|use|abstract|override" .
            "|immutable|it|construct|ondestroy|destroy|init|castTo|tuple|div|mod|let|from|to|downto|step|endpackage|skip|instanceof" .
            "|enum|switch|case|default|typeId|begin|end";

$types  .=  "|var|int|bool";
$values .=  "|new";
$operators .= "|>>|<<";

$language_data['KEYWORDS'] = Array(
                new KeywordGroup(explode("|", $values),     'JASSvalue'),
                new KeywordGroup(explode("|", $operators),  'JASSoperator'),
                new KeywordGroup(explode("|", $keywords),   'JASSkeyword'),
                new KeywordGroup(explode("|", $blocks),     'JASSblock'),
                new KeywordGroup(explode("|", $natives),    'JASSnative'),
                new KeywordGroup(explode("|", $bjs),        'JASSbj'),
                new KeywordGroup(explode("|", $constants),  'JASSconstant'),
                new KeywordGroup(explode("|", $types),      'JASStype'),
                new KeywordGroup(explode("|", $bjglobals),  'JASSbjglobal'));
?>