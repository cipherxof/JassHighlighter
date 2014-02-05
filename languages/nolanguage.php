<?php
    $language_data = Array(
    // Enter the name of the language
    'LANG'          => 'default',
    
    // Decide if you want functions to be linked to the specified link
    'FUNCTION-LINK' => false,
    
    // Error highlighting
    'ERROR-KEY'     =>  '@',
                                    
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
                    )
    );

?>