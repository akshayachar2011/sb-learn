<?php
session_start();
if (empty($_SESSION['user'])) {
	header("Location: ../login.php");
}
require_once("../php/connect.php");
$usernow = mysql_query("SELECT * FROM `user` WHERE `id` = '{$_SESSION['user']}'");
$data_usernow = mysql_fetch_array($usernow);
$userid = $_SESSION['user'];

if (isset($_POST['edit_id'])) {
	$id = trim($_POST['edit_id']);
	if ($id == "") {
		header("Location: ../recallcard/manage.php");
	}
}
else {
	header("Location: ../recallcard/manage.php");
}
if (isset($_POST['edit_pri'])) {
	$pri = trim($_POST['edit_pri']);
	if ($pri == "") {
		header("Location: ../recallcard/manage.php");
	}
}
else {
	header("Location: ../recallcard/manage.php");
}
if (isset($_POST['edit_sec'])) {
	$sec = trim($_POST['edit_sec']);
	if ($sec == "") {
		header("Location: ../recallcard/manage.php");
	}
}
else {
	header("Location: ../recallcard/manage.php");
}
$checkcard = mysql_query("SELECT * FROM `card` WHERE `id` = '$id'");
if (mysql_num_rows($checkcard) == 1) {
	$data_checkcard = mysql_fetch_array($checkcard);
	$lessonid = $data_checkcard['lesson'];
	$checklesson = mysql_query("SELECT * FROM `lesson` WHERE `id` = '$lessonid'");
	$data_checklesson = mysql_fetch_array($checklesson);
	if ($userid == $data_checklesson['user_id']) {
		mysql_query("UPDATE `card` SET `primary` = '$pri', `secondary` = '$sec' WHERE `id` = $id");
		header("Location: ../recallcard/manage.php?lesson=$lessonid");
	}
}
?>