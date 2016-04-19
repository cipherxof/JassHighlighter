JassParser
==========

Syntax Highlighter for Warcraft III's scripting language, JASS2. By default it supports vJass, cJASS, and WurstScript, however you can easily define more. This utilizes PHP's built in tokenizer to parse code quickly.

Syntax
==========

```php
require('includes/jass.php');

$code = new JassCode('local real r = 0.5');
echo $code->parse();
```

Configuration
==========

All of the configuration is stored in a single variable ($language_data).

You can take a look at the examples below.

[Example: vJass](https://github.com/ashinnblunts/jassparser/blob/master/languages/vjass.php)

[Example: cJASS](https://github.com/ashinnblunts/jassparser/blob/master/languages/cjass.php)

[Example: Wurst](https://github.com/ashinnblunts/jassparser/blob/master/languages/wurst.php)
