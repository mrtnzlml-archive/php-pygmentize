This package is future replacement for deprecated [FSHL](https://github.com/kukulich/fshl) heavily inspired by `RegexLexer` from Python [Pygments](http://pygments.org/) but written in pure PHP.

Minimal example

```php
<?php
require __DIR__ . '/vendor/autoload.php'; // composer

$content = (new Adeira\Highlighter(
	new Adeira\Lexer\Sql,
	new Adeira\Formatter\Html
))->highlight(__DIR__ . '/tests/src/Lexer/Sql/sample.sql');
echo "<link rel=\"stylesheet\" href=\"src/Style/default.css\"/><pre>$content</pre>";
```

See: `preview.php` output

TODO:
- change package namespace
- cache

LANGUAGES:
- python
- cpp
- tex/latex
- java
