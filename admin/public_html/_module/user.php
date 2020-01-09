<?php
define('is_admin', true);

include_once($_SERVER['DOCUMENT_ROOT'] . "/_include/init.php");

$type = $_REQUEST['type'];

if( $type == "new" ){
	$name = $_POST['name'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$specification_idx = $_POST['spec_idx'];

	if( empty($name) || empty($username) || empty($password) || empty($specification_idx) ){
		$_common->move("모든 항목을 채워주십시오.", "back", true);
	}

	$temp = $_db->prepare("INSERT INTO `user` SET name=?, username=?, password=?, specification_idx=?");
	$temp->bind_param('ssss', $name, $username, $_common->sha256($password), $specification_idx);
	$temp->execute();

	$_common->move("특수 사용자가 추가되었습니다.", "/user/list", true);
	
} else if( $type == "delete" ){

	$idx = $_GET['idx'];

	if( empty($idx) ){
		$_common->move("잘못된 접근입니다.", "back", true);
	}

	$temp = $_db->prepare("UPDATE `user` SET delete_datetime=? WHERE idx=?");
	$temp->bind_param('ss', $_common->get_datetime(), $idx);
	$temp->execute();

	$_common->move("특수 사용자가 삭제되었습니다.", "/user/list", true);

} else {
	$_common->move("잘못된 접근입니다.", "back", true);
}

