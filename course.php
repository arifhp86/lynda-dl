<?php

//increase max execution time of this script to 150 min:
ini_set('max_execution_time', 9000);
//increase Allowed Memory Size of this script:
ini_set('memory_limit','960M');

require 'vendor/autoload.php';

use LyndaDL\Course;
use LyndaDL\FileDB;
use LyndaDL\LyndaCurl;


$curl = new LyndaCurl();
$db = new FileDB();
$course = new Course($curl, $db);
// $episode = new Episode($curl);

if(!empty($_GET['id']) && $episodes = $course->getEpisodes($_GET['id'])) {
	require 'views/course.view.php';
} else {
	echo 'course not found!';
}




