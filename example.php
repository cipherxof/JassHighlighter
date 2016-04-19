<!DOCTYPE html>
<html>

<head>
    <title>JASS Highlighter</title>

    <link rel="stylesheet" type="text/css" href="include/jass_compact.css">
</head>

<body>

<?php
// include the class
require('jass.php');


$code = file_get_contents("scripts/Blizzard.j");

$wrap = '<div style="text-align:left; margin:0px; color:#000; padding:6px; width: 90%; max-width:90%; height:512px; overflow:auto; background-color:#fff; border:1px solid black; white-space: nowrap"><span><div style="font-family:monospace;">';

$time_start = microtime(true);

$code = new JassCode($code, 'vjass_compact');
$code = $wrap . '<pre>' . $code->parse() . '</pre></div></span></div>';

$time_end = microtime(true);
$time = $time_end - $time_start;


echo "<strong>Execution Time:</strong> $time seconds.<br/>";
echo "<strong>Length:</strong> " . strlen($code);
echo "<br/><br/>";
echo $code;

?>

</body>
</html>