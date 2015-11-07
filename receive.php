<?php
    // match ip
    $addr = $_SERVER['REMOTE_ADDR'];
    echo $addr;

    if($addr === '192.168.1.211'){
        echo 'Succes';
    }
?>
