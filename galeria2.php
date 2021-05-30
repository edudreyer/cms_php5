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
$query_rsNoticia = sprintf("SELECT * FROM galeria WHERE codigo = %s", GetSQLValueString($colname_rsNoticia, "int"));
$rsNoticia = mysql_query($query_rsNoticia, $banco1) or die(mysql_error());
$row_rsNoticia = mysql_fetch_assoc($rsNoticia);
$totalRows_rsNoticia = mysql_num_rows($rsNoticia);

//######### INICIO Paginação
	$numreg = 12; // Quantos registros por página vai ser mostrado
	if (!isset($pg)) {
		$pg = 0;
	}
	$inicial = $pg * $numreg;
//######### FIM dados Paginação

$tt = $_GET['codigo'];

mysql_select_db($database_banco1, $banco1);
$query_sql = "SELECT * FROM galeria_foto WHERE codigo_galeria = '$tt' ORDER BY codigo DESC LIMIT $inicial, $numreg";
$sql = mysql_query($query_sql, $banco1) or die(mysql_error());
$row_sql = mysql_fetch_assoc($sql);
$totalRows_sql = mysql_num_rows($sql);

mysql_select_db($database_banco1, $banco1);
$query_sql_conta = "SELECT * FROM galeria_foto WHERE codigo_galeria = '$tt' ORDER BY codigo DESC";
$sql_conta = mysql_query($query_sql_conta, $banco1) or die(mysql_error());
$row_sql_conta = mysql_fetch_assoc($sql_conta);
$totalRows_sql_conta = mysql_num_rows($sql_conta);

$quantreg = mysql_num_rows($sql_conta); // Quantidade de registros pra paginação

?>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="sitepack.css" rel="stylesheet" type="text/css">

	<!-- jQuery -->
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>

	<!-- Make IE8 and below responsive by adding CSS3 MediaQuery support -->
	<!--[if lt IE 9]>
	  <script type='text/javascript' src='http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js'></script> 
	<![endif]-->


    <!-- Fresco -->
	<script type="text/javascript" src="js/fresco/fresco.js"></script>
	<link rel="stylesheet" type="text/css" href="css/fresco/fresco.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />



<div class="container">
    <div class="page-header"><h1><?php echo $row_rsNoticia['evento']; ?></h1></div>
    <p><?php echo date('d/m/Y', strtotime($row_rsNoticia['data'])); ?><br>
    Local: <?php echo $row_rsNoticia['local']; ?><br />
	Fotografo: <?php echo $row_rsNoticia['fotografo']; ?><br /><br />
    <?php echo $row_rsNoticia['descricao']; ?>
    </p>
    

    
	<div class="row">
    <?php if( $row_sql['codigo'] <> '' ) { ; ?>
    <?php do { ?>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div align="center">
      
      <a href='up/<?php echo $row_sql['imagem']; ?>' 
		     class='fresco' 
		     data-fresco-group='example' 
		     data-fresco-caption="<?php echo $row_sql['descricao']; ?>">
		    <img class="img-thumbnail" src="up/<?php echo $row_sql['imagem']; ?>">
	  </a>
      
      <br>
	  <i><?php echo $row_sql['descricao']; ?></i>
      <br>
	<br>
	</div>
    </div>
    <?php } while ($row_sql = mysql_fetch_assoc($sql)); ?>
    <? } ?>
  
  </div>
   <? include("paginacao.php"); // Chama o arquivo que monta a paginação. ex: << anterior 1 2 3 4 5 próximo >> ?>
   
  
  	
  
  	
</div>


    
    

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

