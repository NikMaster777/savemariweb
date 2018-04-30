<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

//Define Root
define('IN_ROOT', true);
define('ROOT', dirname('../../'));
define('ADMINROOT', dirname(__FILE__));
$timer_start = microtime(true);

//Require Checkpoint
require(ROOT.'/classes/checkpoint.class.php');
$checkpoint = new checkpoint(1);

//Dump
if(lib::get('debug') == 'duck') {
	$timer_end = microtime(true);
	$timer = $timer_end - $timer_start;
	echo '<pre>Loading Time: '.number_format($timer,2).' seconds. Querys:'.db::querysCount().'</pre>';
	echo '<pre>'.db::querysList().'</pre>';
}

