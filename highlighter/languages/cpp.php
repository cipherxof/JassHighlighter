<?php
	require_once ("Class.KeywordGroup.php");
	// example of non-jass
	$commentStyle  = '"color: #009933;"';
	$operatorStyle = '"color: #010049; font-weight: bold;"';
	$compilerStyle = '"color: #666;"'; // ignore
	$valueStyle    = '"color: orange;"'; // floats & ints
	$stringStyle   = '"color: #666; font-style: italic;"';
	
	$types        = "alignas asm auto bool char char16_t char32_t class const constexpr decltype double enum explicit export extern final float friend inline int long mutable noexcept override private protected public register short signed static struct template thread_local typename union unsigned virtual void volatile wchar_t";
	$instructions = "alignof and and_eq bitand bitor break case catch compl const_cast continue default delete do dynamic_cast else false for goto if namespace new not not_eq nullptr operator or or_eq reinterpret_cast return sizeof static_assert static_cast switch this throw true try typedef typeid using while xor xor_eq NULL";
	
	$keyword_group[0] = new KeywordGroup(explode(" ", $types), '"color: #8000ff; font-weight: bold;"');
	$keyword_group[1] = new KeywordGroup(explode(" ", $instructions),'"color: blue; font-weight: bold;"');
	
	if (!is_callable('HandleCppComments', false, $callable_name)){
		function HandleCppComments($text){
			$commentStyle		= '"color: #009933;"';
			// includes
			if (substr($text, 0, 1) == "#")
				return "<span style=\"color:#804000;\">" . $text . '</span>';
			// single or multi-line comment
			else
				return "<span style=$commentStyle>" . $text . '</span>';
		}
	}
	$overide_comments = 'HandleCppComments';
?>
