<?php require_once('Connections/banco1.php'); ?>
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

$colname_rsNoticia = "-1";
if (isset($_GET['codigo'])) {
  $colname_rsNoticia = $_GET['codigo'];
}
mysql_select_db($database_banco1, $banco1);
$query_rsNoticia = sprintf("SELECT * FROM institucional WHERE codigo = %s", GetSQLValueString($colname_rsNoticia, "int"));
$rsNoticia = mysql_query($query_rsNoticia, $banco1) or die(mysql_error());
$row_rsNoticia = mysql_fetch_assoc($rsNoticia);
$totalRows_rsNoticia = mysql_num_rows($rsNoticia);

$colname_rsImgNot = "-1";
if (isset($_GET['codigo'])) {
  $colname_rsImgNot = $_GET['codigo'];
}
mysql_select_db($database_banco1, $banco1);
$query_rsImgNot = sprintf("SELECT * FROM institucional_imagem WHERE codigo_institucional = %s", GetSQLValueString($colname_rsImgNot, "int"));
$rsImgNot = mysql_query($query_rsImgNot, $banco1) or die(mysql_error());
$row_rsImgNot = mysql_fetch_assoc($rsImgNot);
$totalRows_rsImgNot = mysql_num_rows($rsImgNot);
?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  
 
    
    <div class="page-header"><h1><?php echo $row_rsNoticia['titulo']; ?></h1></div>
    
    <i><?php echo $row_rsNoticia['chamada']; ?></i>
    <br>

<div class="row">
    	
	<div class="col-md-12 col-sm-12 col-xs-12" align="justify">
    <?php if( $row_rsNoticia['imagem'] <> '')  { ; ?>
      <img src="up/<?php echo $row_rsNoticia['imagem']; ?>" align="left" class="margem img-responsive">    
    <? } ?>  
    <?php echo nl2br($row_rsNoticia['descricao']); ?>
   	</div>
        
    </div>
    
    <br>
   <?php if( $row_rsImgNot['codigo'] <> '' ) { ; ?>
   <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="well">
    Imagem da p&aacute;gina:    </div>
    </div>
   </div>
  <? } ?>
  
    
	<div class="row">
    <?php if( $row_rsImgNot['codigo'] <> '' ) { ; ?>
    <?php do { ?>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div align="center"><img class="img-thumbnail" src="up/<?php echo $row_rsImgNot['imagem']; ?>"><br>
	  <i><?php echo $row_rsImgNot['descricao']; ?></i>
      <br>
	<br>
	</div>
    </div>
    <?php } while ($row_rsImgNot = mysql_fetch_assoc($rsImgNot)); ?>
    <? } ?>
   
   <?php include("direcao.php"); ?>
   
	</div>


<?php
mysql_free_result($rsNoticia);

mysql_free_result($rsImgNot);
?>