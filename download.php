<?php

//increase max execution time of this script to 150 min:
ini_set('max_execution_time', 9000);
//increase Allowed Memory Size of this script:
ini_set('memory_limit','960M');

require 'vendor/autoload.php';

use LyndaDL\FileDB;
use LyndaDL\Episode;
use LyndaDL\LyndaCurl;


$curl = new LyndaCurl();
$db = new FileDB();
// $course = new Course($curl, $db);
$episode = new Episode($curl, $db);

$courseId = $_GET['course_id'];
$epId = (int)$_GET['ep_id'];

$episode->downloadVideo($courseId, $epId);
echo 'done';









