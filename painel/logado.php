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

mysql_select_db($database_banco1, $banco1);
$query_rsPag = "SELECT * FROM institucional";
$rsPag = mysql_query($query_rsPag, $banco1) or die(mysql_error());
$row_rsPag = mysql_fetch_assoc($rsPag);
$totalRows_rsPag = mysql_num_rows($rsPag);

mysql_select_db($database_banco1, $banco1);
$query_rsBanner = "SELECT * FROM banner";
$rsBanner = mysql_query($query_rsBanner, $banco1) or die(mysql_error());
$row_rsBanner = mysql_fetch_assoc($rsBanner);
$totalRows_rsBanner = mysql_num_rows($rsBanner);

mysql_select_db($database_banco1, $banco1);
$query_rsUsu = "SELECT * FROM usuario";
$rsUsu = mysql_query($query_rsUsu, $banco1) or die(mysql_error());
$row_rsUsu = mysql_fetch_assoc($rsUsu);
$totalRows_rsUsu = mysql_num_rows($rsUsu);

if (!isset($_SESSION)) {
  session_start();
}
$oodologin = $_SESSION["odologin"]; 
$oodosenha = $_SESSION["odosenha"]; 

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="">
        <title>Siteconn - Painel 2.2</title>

        <!-- Bootstrap core CSS -->
        <link href="https://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <style>body{padding-top:90px;} .footer{text-align: center; border-top: solid 1px #eee; padding-top: 20px; margin-top: 20px;} .listaMenu {margin-bottom: 20px;}</style>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="">Siteconn - Painel 2.2</a>
                </div>
                <div class="collapse navbar-collapse">
                    <button type="button" class="btn btn-primary navbar-btn">Voltar para seu site</button>
                    <p class="navbar-text navbar-right">(65) 4104-0456 ou consulte <a href="#" class="navbar-link">atendimento</a></p>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                
                    <div class="jumbotron">
                        <h1>Seja bem-vindo ao seu painel.</h1>
                        <p><?php include("sessao.php"); ?>, aqui voc&ecirc; controla todos os recursos que est&atilde;o dispon&iacute;veis em seu site.</p>
                    </div>
                    
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    
                    <?php include("menu.php"); ?>
                
              </div>
            </div>
            
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                
                    <div class="panel panel-primary">
                        <div class="panel-heading">Resumo do conte&uacute;do em seu site</div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ferramentas</th>
                                    <th style="text-align:center">Quantidade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>01</td>
                                    <td>Banners</td>
                                  <td style="text-align:center">&nbsp;<?php echo $totalRows_rsBanner ?> </td>
                                </tr>
                                <tr>
                                    <td>02</td>
                                    <td>Cardapio</td>
                                    <td style="text-align:center">&nbsp;</td>
                              </tr>
                                <tr>
                                    <td>04</td>
                                    <td>Institucional</td>
                                    <td style="text-align:center"><?php echo $totalRows_rsPag ?> </td>
                                </tr>
                                <tr>
                                  <td>05</td>
                                  <td>Usuarios</td>
                                  <td style="text-align:center">&nbsp;<?php echo $totalRows_rsUsu ?> </td>
                                </tr>
                            </tbody>
                        </table>
                  </div>

                </div>
            </div>
            
            <?php include("rodape.php"); ?>
                    
        </div>
        
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <!-- compiled and minified Bootstrap JavaScript -->
        <script src="https://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    </body>
</html>
