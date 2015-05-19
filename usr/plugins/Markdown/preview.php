<?php

include_once('markdown.php');

$md = $_POST['text'];
$html = Markdown($md);

echo $html;

?>
