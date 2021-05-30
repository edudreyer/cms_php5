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
$query_sql = "SELECT * FROM galeria WHERE categoria = '$tt'  ORDER BY data DESC LIMIT $inicial, $numreg";
$sql = mysql_query($query_sql, $banco1) or die(mysql_error());
$row_sql = mysql_fetch_assoc($sql);
$totalRows_sql = mysql_num_rows($sql);

mysql_select_db($database_banco1, $banco1);
$query_sql_conta = "SELECT * FROM galeria  WHERE categoria = '$tt'  ORDER BY data DESC";
$sql_conta = mysql_query($query_sql_conta, $banco1) or die(mysql_error());
$row_sql_conta = mysql_fetch_assoc($sql_conta);
$totalRows_sql_conta = mysql_num_rows($sql_conta);

$quantreg = mysql_num_rows($sql_conta); // Quantidade de registros pra paginação
        
?>

    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="sitepack.css" rel="stylesheet" type="text/css">



<div class="container">
    <div class="page-header"><h1><?php echo $_GET['categoria']; ?></h1></div>
    
	<div class="row">
    
    <div class="col-md-12 col-sm-12 col-xs-12">
    <p>Acesso nossas fotos:</p>
    </div>
  	<? do { ?>
    
     <div class="col-sm-6 col-md-4">
	    <div class="thumbnail">
        <h3><?php echo $row_sql['evento']; ?></h3>
        <p><?php echo date('d/m/Y', strtotime($row_sql['data'])); ?></p>
	      <a href="galeria.php?codigo=<?php echo $row_sql['codigo']; ?>"><img src="up/<?php echo $row_sql['imagem']; ?>" class="img-thumbnail"></a>
	      <div class="caption">
	         <p>Local: <?php echo $row_sql['local']; ?><br>
    Fotografo: <?php echo $row_sql['fotografo']; ?></p>
	      </div>
	    </div>	
	  </div>
      
      
   
	<? } while ($row_sql = mysql_fetch_assoc($sql)); ?>
	</div>
	<br>
	
	<? include("paginacao.php"); // Chama o arquivo que monta a paginação. ex: << anterior 1 2 3 4 5 próximo >> ?>
</div>

<?


mysql_free_result($sql);

mysql_free_result($sql_conta);

?>

      
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
