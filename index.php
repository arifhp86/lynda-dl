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

if($_POST)
	$course->save($_POST['link']);

if(!empty($_GET['delete']))
	$course->delete($_GET['delete']);


$courses = $course->getAll();
require 'views/index.view.php';


