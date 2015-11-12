<?php

$entries = ((isset($_GET['e'])) ? (int)$_GET['e'] : 10);

$db = new SQLite3("buerostatus.db");

$result = $db->query("SELECT ts, val FROM buerostatus ORDER BY ts DESC LIMIT $entries;");

$row = $result->fetchArray();

$table = "";

$table .= "<hr /><table border=1>";
while ($row != FALSE && count($row)>0) {
        $table .= "<tr><td>$row[ts]</td><td>$row[val]</td></tr>";
        $row = $result->fetchArray();
}
$table .= "</table><hr />";

echo $table;

?>