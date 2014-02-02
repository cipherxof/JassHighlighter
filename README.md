JassParser
==========

Efficient Syntax Highlighter for JASS and it's derivatives.

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
