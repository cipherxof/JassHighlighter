JassParser
==========

Efficient Syntax Highlighter for JASS and it's derivatives, written in PHP. By default it supports vJass, cJASS, and WurstScript, however you can easily define more. It utilizes PHP built in 

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
