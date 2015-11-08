<?php

$timeframe = 60 * ((isset($_GET['h'])) ? (int)$_GET['h'] : 48);

$db = new SQLite3("buerostatus.db");

$result = $db->query("SELECT ts, val FROM buerostatus ORDER BY ts DESC LIMIT $timeframe;");

$row = $result->fetchArray();
$tss = [];
$vals = [];

while ($row != FALSE && count($row)>0) {
        $tss[] = $row['ts'];
        $vals[] = $row['val'];
        $row = $result->fetchArray();
}

require_once("jpgraph/src/jpgraph.php");
require_once("jpgraph/src/jpgraph_line.php");
require_once("jpgraph/src/jpgraph_date.php");

$graph = new Graph(1280,600);
$graph->SetScale('datlin');

$plot = new LinePlot($vals, $tss);
$graph->Add($plot);
$plot->SetColor("#6495ED");

$graph->xaxis->SetLabelAngle(90);

$graph->Stroke();

?>
