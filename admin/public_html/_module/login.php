<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/_include/init.php");

$username = $_POST['username'];
$password = $_common->sha256($_POST['password']);

$temp = $_db->prepare("SELECT idx, name, username FROM `admin` WHERE username=? AND password=? AND delete_datetime='0000-00-00 00:00:00'");
$temp->bind_param('ss', $username, $password);
$temp->execute();
$result_admin = $temp->get_result();
$result = $result_admin->fetch_object();

if( !empty($result->idx) && !empty($result->name) && !empty($result->username) ){
	$_SESSION['idx'] = $result->idx;
	$_SESSION['name'] = $result->name;
	$_SESSION['username'] = $result->username;
	$_SESSION['is_admin'] = 'Y';

	$_common->move("", "/client/", true);
}

$_common->move("아이디와 비밀번호를 확인하여 주십시오.", "back", true);
