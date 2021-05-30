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

//######### INICIO Paginação
	$numreg = 12; // Quantos registros por página vai ser mostrado
	if (!isset($pg)) {
		$pg = 0;
	}
	$inicial = $pg * $numreg;
//######### FIM dados Paginação

$tt = $_GET['categoria'];

mysql_select_db($database_banco1, $banco1);
$query_sql = "SELECT * FROM download WHERE categoria = '$tt'  ORDER BY codigo DESC LIMIT $inicial, $numreg";
$sql = mysql_query($query_sql, $banco1) or die(mysql_error());
$row_sql = mysql_fetch_assoc($sql);
$totalRows_sql = mysql_num_rows($sql);

mysql_select_db($database_banco1, $banco1);
$query_sql_conta = "SELECT * FROM download  WHERE categoria = '$tt'  ORDER BY codigo DESC";
$sql_conta = mysql_query($query_sql_conta, $banco1) or die(mysql_error());
$row_sql_conta = mysql_fetch_assoc($sql_conta);
$totalRows_sql_conta = mysql_num_rows($sql_conta);

$quantreg = mysql_num_rows($sql_conta); // Quantidade de registros pra paginação
        
?>

    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


   <div class="page-header"><h1><?php echo $_GET['categoria']; ?></h1></div>
    
   <div class="row">
  	
	
	
	
	
    <div class="col-md-12 col-sm-12 col-xs-12">
    <p>Confira nossos downloads:</p>
    
    <table width="100%" class="table">
  		<tr bgcolor="#EBEBEB">
		    <td>Nome</td>
		    <td>Data</td>
		    <td>Baixar</td>
       </tr>
      
      <? do { ?>
       <tr>
		    <td><h3><?php echo $row_sql['titulo']; ?></h3><p><?php echo $row_sql['descricao']; ?></p></td>
		    <td><h3><?php echo date('d/m/Y', strtotime($row_sql['data'])); ?></h3></td>
		    <td>
            <h3>
            <button type="button" class="btn btn-default btn-lg">
  				<span class="glyphicon glyphicon-download-alt"></span> Baixar
			</button>
            </h3>
            </td>
	  </tr>
      
      <? } while ($row_sql = mysql_fetch_assoc($sql)); ?>
   
    </table>
    
    
     </div>
	
	
    
    
    </div>
	
<? include("paginacao.php"); // Chama o arquivo que monta a paginação. ex: << anterior 1 2 3 4 5 próximo >> ?>

<?


mysql_free_result($sql);

mysql_free_result($sql_conta);

?>

      
