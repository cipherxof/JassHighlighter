<?php
	require_once ("Class.KeywordGroup.php");
	$commentStyle  = '"color: #009933;"';
	$operatorStyle = '"color: #010049; font-weight: bold;"';
	$compilerStyle = '"color: #666;"'; // ignore
	$valueStyle    = '"color: orange;"'; // floats & ints
	$stringStyle   = '"color: #666; font-style: italic;"';
	$keyword_group[0] = new KeywordGroup(array("int", "bool", "for", "while", "foreach"), '"color: #8000ff; font-weight: bold;"');
?>
