<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/_include/config.php");

class DB {

        public static function connect(){

                $MariaDB_Host = CONFIG_MARIADB_HOST;
                $MariaDB_User = CONFIG_MARIADB_USER;
                $MariaDB_Password = CONFIG_MARIADB_PASSWORD;
                $MariaDB_Name = CONFIG_MARIADB_NAME;

                $link = new mysqli($MariaDB_Host, $MariaDB_User, $MariaDB_Password, $MariaDB_Name);

                if( $link->connect_errno ){
                        echo("# Connect failed : " . $mysqli->connect_error);
                        exit;
                }

                return $link;
        }

        public static function disconnect($link){

                mysqli_close($link);
        }
}


class COMMON {

	public function move($message=NULL, $location=NULL, $is_exit=false) {

		echo("<script>");

		if( $message != NULL && $message != "" )
				echo("alert('$message'); ");
		if( $location == "back" )
				echo("history.back(-1); ");

		echo("</script>");

		if( $location != "" && $location != "back" )
				echo("<meta http-equiv='refresh' content='0;url=$location'>");
		if( $is_exit == true )
				exit;
	}

	public function get_ip() {

        $ip_addr = "";

        if(!empty($_SERVER['HTTP_X_REAL_IP'])){
            $ip_addr = $_SERVER['HTTP_X_REAL_IP'];
        }
        else{
            $ip_addr = $_SERVER['REMOTE_ADDR'];
        }
		return $ip_addr;
	}	

	public function get_date($add_seconds=0) {
		return date("Y-m-d", time() + $add_seconds);
	}

	public function get_datetime($add_seconds=0) {
		return date("Y-m-d H:i:s", time() + $add_seconds);
	}

	public function get_unixtime($add_seconds=0) {
		return mktime(date('H'), date('i'), date('s'), date('m'), date('d'), date('Y'));
	}

	public function unixtime_to_date($unixtime) {
		return date("Y-m-d H:i:s", $unixtime);
	}

	public function date_to_unixtime($year, $month, $day, $hour, $minute, $second) {
		return mktime($hour, $minute, $second, $month, $day, $year);
	}

	public function sha256($password){
		return hash("sha256", $password);
	}

}


/////////////////////////////////////////////////////////////////////////////////////////////

session_start();

$_db = DB::connect();
$_common = new COMMON();

/////////////////////////////////////////////////////////////////////////////////////////////


if( defined("is_admin") ){
	if( $_SESSION['is_admin'] != "Y" ){
		COMMON::move("로그인이 필요합니다.", "/", true);
	}
}


require 'vendor/autoload.php';

$openstack = new OpenStack\OpenStack([
    'authUrl' => 'https://vdi-admin.nerd.kim:5000/v3',
    'region'  => 'Default',
    'user'    => [
        'id'       => 'admin',
        'password' => '50dc3ae316b1ca9ce0c48'
    ],
    'scope'   => ['project' => ['id' => '98e8af94ea964b9eb209d92dc538fb42']]
]);