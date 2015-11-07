<?php

$db = new SQLite3("buerostatus.db");

$result = $db->query("SELECT ts, val FROM buerostatus ORDER BY ts;");

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