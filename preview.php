<link rel="stylesheet" href="src/Style/default.css" />

<?php

function show(string $filename, string $title) {
	$content = file_get_contents($filename);
	echo "<h2 id='$title'>$title</h2><pre>$content</pre>";
}

show(__DIR__ . '/tests/src/Diff/expected.html', 'DIFF');
show(__DIR__ . '/tests/src/Html/expected.html', 'HTML');
show(__DIR__ . '/tests/src/Ini/expected.html', 'INI');
