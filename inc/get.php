<?php
$prefix = substr($_POST["url"], 0, 4);
if($prefix != "http") die();

if (file_get_contents($_POST["url"])) {
	echo file_get_contents($_POST["url"]);
} else {
	echo "Not Found";
}
//header("Location: ".$_GET["url"]);
?>