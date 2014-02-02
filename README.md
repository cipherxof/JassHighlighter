JassParser
==========

Efficient Syntax Highlighter for JASS and it's derivatives, coded in PHP. By default it supports vJass, cJASS, and WurstScript, however you can easily define more. This class utilizes PHP's built in tokenizer to parse code as fast as possible, and with O(1) complexity for keyword lookups.

Syntax
==========

```php
// basic example
$code = new JassCode('local real r = 0.5');
echo $code->parse();

// language extensions
$code = 'package WurstLib';
$code = new JassCode($code, 'wurst');
echo $code->parse();
```

Configuration
==========

All user defined information is stored inside one variable ($language_data), which is pretty straight foward to configure. 

```php
$language_data = Array(

// Enter the name of the language
'LANG'          => 'newJASS',
    
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
                    new KeywordGroup(array("library", "endlibrary"), '"color: #000000; font-weight: bold;"'),
                    new KeywordGroup(array("int", "bool"), '"color: #4477aa; font-weight: bold;"')
                )
    );
```

You can take a look at the examples below.

[Example: vJass](https://github.com/ashinnblunts/jassparser/blob/master/highlighter/languages/vjass.php)

[Example: cJASS](https://github.com/ashinnblunts/jassparser/blob/master/highlighter/languages/cjass.php)

[Example: Wurst](https://github.com/ashinnblunts/jassparser/blob/master/highlighter/languages/wurst.php)
