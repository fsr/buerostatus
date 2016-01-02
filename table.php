<?php

$entries = ((isset($_GET['e'])) ? (int)$_GET['e'] : 10);

$db = new SQLite3("buerostatus.db");

$result = $db->query("SELECT ts, val FROM buerostatus ORDER BY ts DESC LIMIT $entries;");

$row = $result->fetchArray();

$table = "";

$table .= <<<EOT
<!DOCTYPE html><html>
<head>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">
<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#buerostatus').DataTable();
} );
</script>
</head>
<body>
<table id="buerostatus" class="display" cellspacing="0" width="100%">
<thead><tr><th>Timestamp</th><th>Date</th><th>Value</th></tr></thead>
EOT;
while ($row != FALSE && count($row)>0) {
        $table .= "<tr><td>$row[ts]</td><td>".date("c", $row["ts"])."</td><td>$row[val]</td></tr>";
        $row = $result->fetchArray();
}
$table .= "</table></body></html>";

echo $table;

?>
