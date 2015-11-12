<?php
$sampleSize = 5;
$threshold = 250;

/*
Aufruf -> Ausgabe
output.php -> 0/1 auf Basis des letzten Messwerts
output.php?median -> 0/1 auf Basis des Medians der letzten 5 Werte
output.php?raw -> letzter Messwert
output.php?raw&median -> Median der letzten 5 Messwerte
*/

$raw = isset($_GET["raw"]);
$median = isset($_GET["median"]);

$db = new SQLite3("buerostatus.db");
$result = $db->query("SELECT val FROM buerostatus ORDER BY id DESC LIMIT $sampleSize;");
$row = $result->fetchArray();
$vals = [];
while ($row != FALSE && count($row)>0) {
        $vals[] = $row['val'];
        $row = $result->fetchArray();
}
$sampleSize = count($vals);
$medianElement = floor($sampleSize/2);
sort($vals, SORT_NUMERIC);

$val = $median?$vals[$medianElement]:$vals[$sampleSize-1];
if($raw) {
        echo $val;
} else {
        if ($val > $threshold) {
                echo 1;
        } else {
                echo 0;
        }
}
?>
