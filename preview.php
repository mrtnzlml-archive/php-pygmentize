<link rel="stylesheet" href="src/Style/default.css" />

<?php

function show(string $filename, string $title) {
	$content = file_get_contents($filename);
	echo "<h2 id='$title'>$title</h2><pre>$content</pre><hr>";
}

show(__DIR__ . '/tests/src/Css/expected.html', 'CSS');
show(__DIR__ . '/tests/src/Diff/expected.html', 'Diff');
show(__DIR__ . '/tests/src/GraphQL/expected.html', 'GraphQL');
show(__DIR__ . '/tests/src/Html/expected.html', 'HTML');
show(__DIR__ . '/tests/src/Ini/expected.html', 'INI');
show(__DIR__ . '/tests/src/JavaScript/expected.html', 'JavaScript');
show(__DIR__ . '/tests/src/Php/expected.html', 'PHP');
