<?php
define('is_admin', true);

include_once($_SERVER['DOCUMENT_ROOT'] . "/_include/init.php");

$type = $_REQUEST['type'];

if( $type == "new"){

	$name = $_POST['name'];
	$cpu = $_POST['cpu'];
	$ram = $_POST['ram'];
	$hdd = $_POST['hdd'];
	$os_idx = $_POST['os_idx'];

	if( empty($name) || empty($cpu) || empty($ram) || empty($hdd) || empty($os_idx) ){
		$_common->move("모든 항목을 채워주십시오.", "back", true);
	}

	$temp = $_db->prepare("INSERT INTO `specification` SET name=?, cpu=?, ram=?, hdd=?, os_idx=?, create_datetime=?");
	$temp->bind_param('ssssss', $name, $cpu, $ram, $hdd, $os_idx, $_common->get_datetime());
	$temp->execute();

	$_common->move("고정 사양이 추가되었습니다.", "/desktop/specification/list", true);

} else if( $type == "delete" ){

	$idx = $_GET['idx'];
	
	if( empty($idx) ){
		$_common->move("잘못된 접근입니다.", "back", true);
	}
	
	$temp = $_db->prepare("UPDATE `specification` SET delete_datetime=? WHERE idx=?");
	$temp->bind_param('ss', $_common->get_datetime(), $idx);
	$temp->execute();

	$_common->move("고정 사양이 삭제되었습니다.", "/desktop/specification/list", true);

} else if( $type == "default" ){

	$idx = $_POST['idx'];

	if( empty($idx) ){
		$_common->move("잘못된 접근입니다.", "back", true);
	}
	
	$temp = $_db->prepare("UPDATE `specification` SET is_default='N'");
	// $temp->bind_param('s', 'N');
	$temp->execute();

	$temp = $_db->prepare("UPDATE `specification` SET is_default='Y' WHERE idx=?");
	$temp->bind_param('s', $idx);
	$temp->execute();

	$_common->move("기본 환경 설정이 완료되었습니다.", "/desktop/specification/default", true);

} else {
	$_common->move("잘못된 접근입니다.", "back", true);
}
