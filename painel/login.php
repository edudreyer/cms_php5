<?php require_once('../Connections/banco1.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['nome'])) {

$_SESSION["odologin"]=$HTTP_POST_VARS['nome']; 
$_SESSION["odosenha"]=$HTTP_POST_VARS['senha']; 


  $loginUsername=$_POST['nome'];
  $password=$_POST['senha'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "logado.php";
  $MM_redirectLoginFailed = "erro.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_banco1, $banco1);
  
  $LoginRS__query=sprintf("SELECT login, senha FROM usuario WHERE login=%s AND senha=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $banco1) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Painel Administrativo 5.01</title>
<style type="text/css">
<!--
body {
	background-color: #F0F0F0;
}
body,td,th {
	font-family: Trebuchet MS, Verdana, Arial;
	font-size: 12px;
}
.fundoLog {
	background-color: #F0F0F0;
	font-family: "Trebuchet MS", Verdana, Arial;
	font-size: 15px;
	height: 40px;
	border: 1px dashed #666666;
}
.style1 {font-size: 24px}
-->
</style>
</head>

<body>
<form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
  <table width="400" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#999999">
    <tr>
      <td background="images/fundo_login.jpg"><table width="500" border="0" align="center" cellpadding="5" cellspacing="0">
        <tr>
          <td rowspan="2">&nbsp;</td>
          <td><span class="style1">Painel Admin</span></td>
        </tr>
        <tr>
          <td>Acesso a àrea administrativa do site, caso não tenha acesso favor informar ao administrador do site.</td>
        </tr>
        <tr>
          <td width="291"><div align="right">Login: </div>
              <label></label></td>
          <td width="189"><input name="nome" type="text" class="fundoLog" id="nome" /></td>
        </tr>
        <tr>
          <td><div align="right">Senha:</div></td>
          <td><input name="senha" type="password" class="fundoLog" id="senha" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><label>
            <input name="button" type="submit" class="fundoLog" id="button" value="logar" />
          </label></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><a href="#">- Esqueci a senha.</a></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <div align="center">Desenvolvido por <a href="http://www.siteconnect.com.br/" target="_blank">siteconnect.com.br
  </a></div>
</form>
</body>
</html>
