<link rel="stylesheet" href="src/Style/default.css" />

<?php

function show(string $filename, string $title) {
	$content = file_get_contents($filename);
	echo "<h2 id='$title'>$title</h2><pre>$content</pre><hr>";
}

show(__DIR__ . '/tests/src/Lexer/Css/expected.html', 'CSS');
show(__DIR__ . '/tests/src/Lexer/Diff/expected.html', 'Diff');
show(__DIR__ . '/tests/src/Lexer/GraphQL/expected.html', 'GraphQL');
show(__DIR__ . '/tests/src/Lexer/Html/expected.html', 'HTML');
show(__DIR__ . '/tests/src/Lexer/Ini/expected.html', 'INI');
show(__DIR__ . '/tests/src/Lexer/JavaScript/expected.js.html', 'JavaScript');
show(__DIR__ . '/tests/src/Lexer/JavaScript/expected.json.html', 'JSON');
show(__DIR__ . '/tests/src/Lexer/Latte/expected.html', 'Latte');
show(__DIR__ . '/tests/src/Lexer/Php/expected.html', 'PHP');
