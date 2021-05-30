<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_banco1 = "localhost";
$database_banco1 = "sitepack";
$username_banco1 = "sitepack";
$password_banco1 = "stc542b";
$banco1 = mysql_pconnect($hostname_banco1, $username_banco1, $password_banco1) or trigger_error(mysql_error(),E_USER_ERROR); 

define('HOST','localhost');
define('USERNAME','sitepack');
define('PASSWORD','stc542b');
define('DBNAME','sitepack');
define('DSN', 'mysql:host='.HOST.';dbname='.DBNAME.'');
	
	try{
		$pdo = new PDO(DSN, USERNAME, PASSWORD);
		
	}catch(PDOException $erro){
		echo $erro->getMessage();
		exit("Erro ao conectar ao banco!");
	}
?>