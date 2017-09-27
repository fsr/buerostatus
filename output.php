<?php
$sampleSize = 5;
$threshold = 500;
$frequencies = [2.0,3.0,5.0,15.0,24.0,26.0,41.0,47.0,48.0,49.0,52.0,53.0,63.0,326.0];
$amplitudes = [55.0,41.0,22.0,35.0,28.0,21.0,21.0,54.0,39.0,26.0,27.0,26.0,26.0,28.0];

date_default_timezone_set("Europe/Berlin");

function linspace($st,$en,$n){
    $step = ($en-$st)/($n-1);
    return range ($st,$en,$step);
}

/*
Aufruf -> Ausgabe
output.php -> 0/1 auf Basis des letzten Messwerts
output.php?median -> 0/1 auf Basis des Medians der letzten 5 Werte
output.php?raw -> letzter Messwert
output.php?raw&median -> Median der letzten 5 Messwerte
*/

$raw = isset($_GET["raw"]);
$median = isset($_GET["median"]);
$image = isset($_GET["image"]);
$predict = isset($_GET["predict"]);

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

$val = $median?$vals[$medianElement]:$vals[0];
$status = ($val > $threshold)?1:0;

if ($predict) {
    $perDay = 24;
    $hour = date("G");
    $day = date("z");
    $month = date("n");
    $x = linspace($day*1440, ($day+1)*1440, $perDay);
    $tp = $x[$hour];
    $prob = 0.0;
    $in_hour = 0;

    while ($prob < 50) {
        $in_hour = $in_hour + 1;
        $tp = $tp + ($x[1]-$x[0]);

        foreach ($frequencies as $index => $freq) {
            $prob = $prob + $amplitudes[$index] * sin(2.0 * pi() * $freq * $tp);
        }

        $prob = ($prob + 500)/10;

        if (($hour + $in_hour) % 24 < 7 || ($hour + $in_hour) % 24 > 18) {
            $prob = 0.33 * $prob;
        }

        if (in_array($month, [2,3,8,9])) {
            $prob = 0.5 * $prob;
        }

        if ($status) {
            $prob = min(2.0 * $prob, 100);
        }

        if ($in_hour == 1) { // probability for next hour
            $cur_prob = round($prob);
        }

        if ($in_hour > 47) { // avoid long looping until next month
            $in_hour = ">48";
            break;
        }
    }
}

if($image) {
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: Fri, 17 Jul 1992 11:00:00 GMT");
    header("Content-Type: image/png");
    readfile("$status.png");
} elseif ($raw) {
    echo $val;
} elseif ($predict) {
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: Fri, 17 Jul 1992 11:00:00 GMT");
    header("Content-Type: image/png");

    $img = ImageCreate(110, 20);
    $background_color = ImageColorAllocateAlpha($img, 0, 0, 0, 127);
    $text_color = ImageColorAllocate($img, 0, 0, 0);

    ImageFill($img, 0, 0, $background_colour);

    if (strlen($in_hour) < 2) {
        $in_hour = "0".$in_hour;
    }

    ImageString($img, 5, 2, 2, $in_hour."h | ".$cur_prob."%", $text_color);
    ImagePNG($img);
} else {
    echo $status;
}

?>
