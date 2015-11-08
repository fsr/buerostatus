<?php

$db = new SQLite3("buerostatus.db");
$result = $db->query("SELECT val FROM buerostatus ORDER BY id DESC LIMIT 1;");
$val = $result->fetchArray()["val"];
if ($val > 250) {
	echo 1;
} else {
	echo 0;
}

?>
