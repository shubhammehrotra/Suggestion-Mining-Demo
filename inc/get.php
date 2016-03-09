<?php
$prefix = substr($_GET["url"], 0, 4);
if($prefix != "http") die();

if (file_get_contents($_GET["url"])) {
	echo file_get_contents($_GET["url"]);
} else {
	echo "Not Found";
}
//header("Location: ".$_GET["url"]);
?>