<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_banco1 = "localhost";
$database_banco1 = "banco";
$username_banco1 = "root";
$password_banco1 = "";
$banco1 = mysql_pconnect($hostname_banco1, $username_banco1, $password_banco1) or trigger_error(mysql_error(),E_USER_ERROR); 

define('HOST','localhost');
define('USERNAME','root');
define('PASSWORD','');
define('DBNAME','banco');
define('DSN', 'mysql:host='.HOST.';dbname='.DBNAME.'');
	
	try{
		$pdo = new PDO(DSN, USERNAME, PASSWORD);
		
	}catch(PDOException $erro){
		echo $erro->getMessage();
		exit("Erro ao conectar ao banco!");
	}
?>
