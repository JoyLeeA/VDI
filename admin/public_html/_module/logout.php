<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/_include/init.php");

session_destroy();

$_common->move("로그아웃 되었습니다.", "/", true);
