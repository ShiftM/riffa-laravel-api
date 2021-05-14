<?php

function convertToUnix($date) {
    $carbonObj = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$date,'Asia/Manila');
    return $carbonObj->timestamp;
}
