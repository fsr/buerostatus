<?php

$ip_addr = $_SERVER['REMOTE_ADDR'];
if($ip_addr === '192.168.1.211'){
	$timestamp = $_POST["ts"];
	$value = $_POST["val"];

	$db = new SQLite3("buerostatus.db");
	$db->exec("INSERT INTO buerostatus (ts, val) VALUES ($timestamp, $value);");
} else {
	http_response_code(403);
}

?>
