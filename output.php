<?php
$sampleSize = 5;
$threshold = 250;
$db = new SQLite3("buerostatus.db");
$result = $db->query("SELECT val FROM buerostatus ORDER BY id DESC LIMIT $sampleSize;");
$row = $result->fetchArray();

$vals = [];
while ($row != FALSE && count($row)>0) {
        $vals[] = $row['val'];
        $row = $result->fetchArray();
}

$medianElement = floor($sampleSize/2);
sort($vals, SORT_NUMERIC);
$val = $vals[$medianElement];

if ($val > $threshold) {
        echo 1;
} else {
        echo 0;
}
?>
