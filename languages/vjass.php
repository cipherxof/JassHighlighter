<?php
	require ('jass_keywords.php');
    
    $language_data = Array(
    // Enter the name of the language
    'LANG'          => 'vjass',
    
    // Decide if you want functions to be linked to the specified link
    'FUNCTION-LINK' => false,
    
    // Error highlighting
    'ERROR-KEY'     =>  '@',
    
    'IDENTIFIERS'   => Array(
                        'MEMBER'  => '.',
                        'STRUCT'  => array('STYLE' => '"color: #666; font-weight: bold;"' , "struct", "module", "keyword"),
                        'TYPE'    => array('STYLE' => '"color: #4477aa; font-weight: bold;"', "type")
                    ),
                                    
                    // Here you can define the styles of each element
    'STYLE'         => Array(
                        'STRING'    => '"color: #0000AA; font-style: italic;"'/*'"color: blue;"';*/,
                        'COMMENT'   => '"color: #008800;"',
                        'RAWCODE'   => '"color: #000000; font-weight: bold; text-decoration:underline;"',
                        'VALUE'     => '"color: #0000AA;"',
                        'MEMBER'    => '"color: #666666;"',
                        'COMPILER'  => '"color: #666;"',
                        'ERROR'     => '"background-color: #ffcccc;"',
                        'HIGHLIGHT' => '"color: #666;"', /* temporarily unused */
                        'ESCAPE'    => '"font-weight: bold; font-style: normal;"'
                    ),
    
    'KEYWORDS'      => Array(
                        new KeywordGroup(explode("|", $values),     '"color: #0000AA;"'),
                        new KeywordGroup(explode("|", $operators),  '"font-weight: bold; color: sienna;"'),
                        new KeywordGroup(explode("|", $keywords),   '"font-weight: bold;"'),
                        new KeywordGroup(explode("|", $blocks),     '"font-weight: bold;"'),
                        new KeywordGroup(explode("|", $natives),	'"color: purple;"', 'http://ashinnblunts.yzi.me/testforum/jassdb_view.php?native='),
                        new KeywordGroup(explode("|", $bjs),     	'"color: #dd4444;"', 'http://ashinnblunts.yzi.me/testforum/jassdb_view.php?bj='),
                        new KeywordGroup(explode("|", $constants),  '"color: #4477aa;"'),
                        new KeywordGroup(explode("|", $types),  	'"color: #4477aa; font-weight: bold;"'),
                        new KeywordGroup(explode("|", $bjglobals),  '"color: #660033;"')
                    )
    );

?>