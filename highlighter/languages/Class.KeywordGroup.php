<?php

	class KeywordGroup{
		
		public $keywords, $style, $link;
		
		function __construct($keywords, $style, $link=""){
			if (is_array($keywords))
				$this->keywords = $keywords;
			elseif (is_string($array))
				$this->keywords = array($keywords);
			else
				$this->keywords = array('');
			if (isset($link))
				$this->link = $link;
			$this->style = $style;
		}
	}

?>