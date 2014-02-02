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
You can take a look at the examples below.

[Example: vJass](https://github.com/ashinnblunts/jassparser/blob/master/highlighter/languages/vjass.php)

[Example: cJASS](https://github.com/ashinnblunts/jassparser/blob/master/highlighter/languages/cjass.php)

[Example: Wurst](https://github.com/ashinnblunts/jassparser/blob/master/highlighter/languages/wurst.php)
