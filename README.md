JassHighlighter
==========

Syntax Highlighter for Warcraft III's scripting language, JASS2. 

By default it includes the extensions for vJass, cJASS, and WurstScript, however you can easily define more. 

This utilizes PHP's built in tokenizer to parse code quickly.

Syntax
==========

```php
require('jass.php');

$code = new JassCode('local real r = 0.5');
echo $code->parse();
```

Example
==========

You can view a live example at the link below.

http://185.92.220.118/jass/example/
