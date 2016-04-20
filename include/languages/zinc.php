<?php
require ('vjass.php');
$blocks .= "|while|for";
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