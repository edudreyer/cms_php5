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

$_SESSION["odologin"]=$_POST['nome']; 
$_SESSION["odosenha"]=$_POST['senha']; 


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
<title>Painelstc 2.1 - Siteconn</title>
<style>
body {
	margin:0px;
	padding:0px;
	background:#999;
}
#top {
	width:100%;
	height:80px;
	background:#ccc;
	border-bottom:solid 1px #999;
}
#topcontent {
	width:800px;
	margin:auto;
	padding: 14px 0px 0px 0px;
}
p.fone {
	width:200px;
	font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
	font-size:18px;
	color:#333;
	text-align:right;
	margin:11px 0px 0px 0px;
	float:right;
}
p.itemtitle {
	width:100%;
	margin:0px;
	padding:7px 0px 0px 0px;
	font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
	font-size:22px;
	color:#333;
	text-align:center;
}
p.info {
	width:100%;
	margin:120px 0px 0px 0px;
	padding:0px;
	font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
	font-size:14px;
	text-align:justify;
	line-height:20px;
	color:#000;
}
#content {
	width:100%;
	height:300px;
	border-top:solid 1px #ccc;
	background:url(images/bg-item.jpg) top center no-repeat;
}
#itemcontent {
	width:601px;
	height:151px;
	margin:70px auto;
	background:url(images/bg-item-formulario.jpg) no-repeat top center;
}
#itemform {
	width:561px;
	padding: 37px 20px 0px 20px;
}
.formcontent {
    border:solid 1px #666;
    -moz-border-radius: 6px;
    -webkit-border-radius: 6px;
    border-radius: 6px;
	width:180px;
	padding:12px 10px 12px 10px;
	margin:0px 14px 0px 0px;
	font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
	color:#666;
	font-size:14px;
	float:left;
}
.btncontent {
	-moz-box-shadow:inset 0px 1px 0px 0px #ffffff;
	-webkit-box-shadow:inset 0px 1px 0px 0px #ffffff;
	box-shadow:inset 0px 1px 0px 0px #ffffff;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #ededed), color-stop(1, #dfdfdf) );
	background:-moz-linear-gradient( center top, #ededed 5%, #dfdfdf 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ededed', endColorstr='#dfdfdf');
	background-color:#ededed;
	-webkit-border-top-left-radius:6px;
	-moz-border-radius-topleft:6px;
	border-top-left-radius:6px;
	-webkit-border-top-right-radius:6px;
	-moz-border-radius-topright:6px;
	border-top-right-radius:6px;
	-webkit-border-bottom-right-radius:6px;
	-moz-border-radius-bottomright:6px;
	border-bottom-right-radius:6px;
	-webkit-border-bottom-left-radius:6px;
	-moz-border-radius-bottomleft:6px;
	border-bottom-left-radius:6px;
	text-indent:0;
	border:1px solid #dcdcdc;
	display:inline-block;
	color:#333;
	font-family:arial;
	font-size:15px;
	font-weight:normal;
	font-style:normal;
	height:42px;
	width:120px;
	text-decoration:none;
	text-align:center;
	text-shadow:1px 1px 0px #ffffff;
	float:left;
}
.btncontent:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #dfdfdf), color-stop(1, #ededed) );
	background:-moz-linear-gradient( center top, #dfdfdf 5%, #ededed 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#dfdfdf', endColorstr='#ededed');
	background-color:#dfdfdf;
}.btncontent:active {
	position:relative;
	top:1px;
}
.logo {
	width:284px;
	height:50px;
	margin:50px auto;
}
</style>

</head>

<body>

<div id="top">
    	<div id="topcontent">
            <img src="images/painelstc.png" width="370" height="50" alt="Painelstc" />
            <p class="fone">(65) 4104-0456</p>
        </div>
    </div>
    
<div align="center"> Usuario ou senha invalido.</div>
    
<div id="content">
    	<div id="itemcontent">
        	<p class="itemtitle">Acesse seu painel administrativo</p>
            <div id="itemform">
                
<form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
  
      <input name="nome" type="text" class="formcontent" id="nome" placeholder="Usuario"/></td>
    
      <input name="senha" type="password"  class="formcontent" id="senha2" placeholder="Senha"/></td>
    
      
        <input name="button" type="submit" class="btncontent"id="button" value="Entrar" />
      
</form>


</div>
            <p class="info">Em caso de dúvida ou se não conseguir acessar seu painel, por favor contate o administrador do site para verificar seu plano de suporte com a Siteconn. Se precisar conheça os nossos canais de atendimento.</p>
            <div class="logo">
            	<img src="images/siteconn.png" width="284" height="50" alt="siteconn" />
            </div>
        </div>
    </div>
    
    
            	
            

</body>
</html>
