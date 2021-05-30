<?php require_once('Connections/banco1.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

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
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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

//######### INICIO Paginação
	$numreg = 12; // Quantos registros por página vai ser mostrado
	if (!isset($pg)) {
		$pg = 0;
	}
	$inicial = $pg * $numreg;
//######### FIM dados Paginação

$tt = $_GET['categoria'];

mysql_select_db($database_banco1, $banco1);
$query_sql = "SELECT * FROM produto WHERE categoria = '$tt'  ORDER BY codigo DESC LIMIT $inicial, $numreg";
$sql = mysql_query($query_sql, $banco1) or die(mysql_error());
$row_sql = mysql_fetch_assoc($sql);
$totalRows_sql = mysql_num_rows($sql);

mysql_select_db($database_banco1, $banco1);
$query_sql_conta = "SELECT * FROM produto  WHERE categoria = '$tt'  ORDER BY codigo DESC";
$sql_conta = mysql_query($query_sql_conta, $banco1) or die(mysql_error());
$row_sql_conta = mysql_fetch_assoc($sql_conta);
$totalRows_sql_conta = mysql_num_rows($sql_conta);

$colname_rsCategoria = "-1";
if (isset($_GET['categoria'])) {
  $colname_rsCategoria = $_GET['categoria'];
}
mysql_select_db($database_banco1, $banco1);
$query_rsCategoria = sprintf("SELECT * FROM produto_categoria WHERE categoria = %s", GetSQLValueString($colname_rsCategoria, "text"));
$rsCategoria = mysql_query($query_rsCategoria, $banco1) or die(mysql_error());
$row_rsCategoria = mysql_fetch_assoc($rsCategoria);
$totalRows_rsCategoria = mysql_num_rows($rsCategoria);

$quantreg = mysql_num_rows($sql_conta); // Quantidade de registros pra paginação
        
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<div class="page-header"><h1><?php echo $_GET['categoria']; ?></h1></div>
<div class="col-md-12 col-sm-12 col-xs-12">
<p><?php echo $row_rsCategoria['chamada']; ?></p>
</div>
    
<div class="row">	
  	<? do { ?>
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="up/<?php echo $row_sql['imagem']; ?>" class="img-thumbnail">
      <div class="caption">
        <h3><?php echo $row_sql['produto']; ?></h3>
        <p><?php echo substr($row_sql['chamada'],0,70); ?>...</p>
        <p><a href="produto.php?codigo=<?php echo $row_sql['codigo']; ?>&produto=<?php echo $row_sql['produto']; ?>" class="btn btn-primary" role="button">Mais informações</a></p>
      </div>
    </div>
  </div>
    <? } while ($row_sql = mysql_fetch_assoc($sql)); ?>
</div>



<? include("paginacao.php"); // Chama o arquivo que monta a paginação. ex: << anterior 1 2 3 4 5 próximo >> ?>


<?
mysql_free_result($sql);
mysql_free_result($sql_conta);
?>
<?php
mysql_free_result($rsCategoria);
?>
