<?php
    date_default_timezone_set('Asia/Seoul');
    $date = date("Y-m-d");
    $time = date("H:i:s");
    $startAMTime = "07:00:00";
    $endAMTime = "09:00:00";
    $startPMTime = "18:50:00";
    $endPMTime = "19:50:00";

    if ($startAMTime < $time) {
        echo "good";
    }
    echo $startAMTime;
    echo $startPMTime;
?>