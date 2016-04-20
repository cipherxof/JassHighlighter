<?php
require ('vjass.php');

$operators .= "|{|}|++|--|;";
$blocks    .= "|include|do|whilenot|#define|define|#error|enum|endenum|setdef";
$types     .= "|int|bool|void";

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