<?php


define("CONN_DBMS", 1001);
define("CONN_DB_NAME", 1101);
define("CONN_OK", 0);


Class Connection {

	var $host,
	$user,
	$pass,
	$db,
	$active = false,
	$errno = 0;

	function Connection($host, $user, $pass, $db) {
			
		$this->host = $host;
		$this->user = $user;
		$this->pass = $pass;
		$this->db = $db;
	}

	function connect() {
			
		if (!$this->active) {
				
			$conn = mysql_pconnect($this->host, $this->user, $this->pass);

			if ($conn) {
				$sel = mysql_select_db($this->db);
				
				if ($sel) {

					return true;

				} else {

					$this->errno = CONN_DB_NAME;
					return false;
				}
			} else {
					
				$this->errno = CONN_DBMS;
				return false;
					
			}
		}
	}

	function error() {
		switch ($this->errno) {
			case CONN_DB_NAME:
				echo "name errato!";
				break;
			case CONN_DBMS:
				echo "connessione errata!";
				break;
			case CONN_OK:
				echo "alive and kicking!";
				break;
					
			default:
				echo "unknown error!";
				break;
		}
	}
}

$mydb = new Connection("localhost", "root", "", "filmbuster1");
$mydb->connect();

function getResult($query) {
	
	$oid = mysql_query($query);
	
	do {
		$data = mysql_fetch_assoc($oid);
		if ($data) {
			$content[] = $data;
		}
	} while ($data);
	
	return $content;
}


echo $mydb->error();

?>