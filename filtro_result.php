<?php require_once('Connections/banco1.php'); ?>
<?php include("header.php"); 
session_start();
$lloginR = $_SESSION['msemail'];
$ssenhaR = $_SESSION['mssenha'];
?>

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


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META NAME="Generator" CONTENT="Site Connect - www.siteconnect.com.br">
<META NAME="revisit-after" CONTENT="1 days">
<META NAME="Googlebot" content="all">
<META NAME="robots" content="INDEX,FOLLOW">
<meta name="language" content="PT-BR">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>MARIA SOCORRO</title>
<title>MARIA SOCORRO</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"
    rel="stylesheet">
    <link href="estilo.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<META Lang="pt" NAME="description" CONTENT="">
<META Lang="pt" NAME="keywords" CONTENT="">


</head>

<body>

<?php include("topo.php"); ?>
<? 

$ccodigo = $row_rsLogin['codigo'];
$bairro = $_GET['bairro'];
$servico = $_GET['servico'];

//######### INICIO Paginação
	$numreg = 24; // Quantos registros por página vai ser mostrado
	if (!isset($pg)) {
		$pg = 0;
	}
	$inicial = $pg * $numreg;
//######### FIM dados Paginação

?>
<?php
mysql_select_db($database_banco1, $banco1);
$query_sql = "SELECT * FROM cliente WHERE categoria = 'Prestador de serviço' ORDER BY codigo DESC LIMIT $inicial, $numreg";
$sql = mysql_query($query_sql, $banco1) or die(mysql_error());
$row_sql = mysql_fetch_assoc($sql);
$totalRows_sql = mysql_num_rows($sql);

$colname_rsSubcategoria = "-1";
if (isset($_GET['categoria'])) {
  $colname_rsSubcategoria = $_GET['categoria'];
}
mysql_select_db($database_banco1, $banco1);
$query_rsSubcategoria = sprintf("SELECT * FROM categoria WHERE categoria = %s", GetSQLValueString($colname_rsSubcategoria, "text"));
$rsSubcategoria = mysql_query($query_rsSubcategoria, $banco1) or die(mysql_error());
$row_rsSubcategoria = mysql_fetch_assoc($rsSubcategoria);
$totalRows_rsSubcategoria = mysql_num_rows($rsSubcategoria);

mysql_select_db($database_banco1, $banco1);
$query_sql_conta = "SELECT * FROM cliente ORDER BY codigo DESC";
$sql_conta = mysql_query($query_sql_conta, $banco1) or die(mysql_error());
$row_sql_conta = mysql_fetch_assoc($sql_conta);
$totalRows_sql_conta = mysql_num_rows($sql_conta);

$quantreg = mysql_num_rows($sql_conta); // Quantidade de registros pra paginação

mysql_select_db($database_banco1, $banco1);
$query_rsServico = "SELECT * FROM categoria GROUP BY categoria ORDER BY Id ASC";
$rsServico = mysql_query($query_rsServico, $banco1) or die(mysql_error());
$row_rsServico = mysql_fetch_assoc($rsServico);
$totalRows_rsServico = mysql_num_rows($rsServico);

mysql_select_db($database_banco1, $banco1);
$query_rsCidade = "SELECT * FROM cidade GROUP BY cidade ASC";
$rsCidade = mysql_query($query_rsCidade, $banco1) or die(mysql_error());
$row_rsCidade = mysql_fetch_assoc($rsCidade);
$totalRows_rsCidade = mysql_num_rows($rsCidade);

$colname_rsBairro = "-1";
if (isset($_GET['cidade'])) {
  $colname_rsBairro = $_GET['cidade'];
}
mysql_select_db($database_banco1, $banco1);
$query_rsBairro = sprintf("SELECT * FROM cidade WHERE cidade = %s ORDER BY bairro ASC", GetSQLValueString($colname_rsBairro, "text"));
$rsBairro = mysql_query($query_rsBairro, $banco1) or die(mysql_error());
$row_rsBairro = mysql_fetch_assoc($rsBairro);
$totalRows_rsBairro = mysql_num_rows($rsBairro);
?>
<script type="text/javascript">
<!--
$(document).ready(function(){
		$("#telefone").mask("(99)9999-9999");
		$("#celular").mask("(99)9999-9999");
		$("#data_nasc").mask("99/99/9999");
		$("#cep").mask("99.999-999");		
		$("#cpf").mask("999.999.999-99");		
	});
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<div class="container">
 
   

 <div  class="row">
  
  <div class="col-md-12 col-sm-12 col-xs-12">
  <h3> Buscar prestador de serviço:</h3>
 

          
          
 
 <form class="form-inline" role="form" action="filtro_result.php" method="get">
  
  <div class="form-group">
  
  <select name="categoria" class="form-control" id="categoria"  onChange="MM_jumpMenu('parent',this,0)">>
  <? if($_GET['categoria'] == '') { ?>
  <option value="" selected="selected">Escolha um categoria</option>
  <? } else { ?>
  <option value="<?php echo $_GET['categoria']; ?>" selected="selected"><?php echo $_GET['categoria']; ?></option>
  <? } ?>
  <?php do { ?>
  <option value="filtro.php?categoria=<?php echo $row_rsServico['categoria']; ?>&subcategoria=<? echo $_GET['subcategoria']; ?>&cidade=<? echo $_GET['cidade']; ?>&bairro=<? echo $_GET['bairro']; ?>"><?php echo $row_rsServico['categoria']; ?></option>
  <?php } while ($row_rsServico = mysql_fetch_assoc($rsServico)); ?>
  </select>
  </div>
   
   
  <div class="form-group">
  <select name="subcategoria" class="form-control" id="subcategoria"  onChange="MM_jumpMenu('parent',this,0)">>
  
  
   <? if($_GET['subcategoria'] == '') { ?>
  <option value="" selected="selected">Escolha um subcategoria</option>
  <? } else { ?>
  <option value="<?php echo $_GET['subcategoria']; ?>" selected="selected"><?php echo $_GET['subcategoria']; ?></option>
  <? } ?>
  

  <?php do { ?>
  <option value="filtro.php?categoria=<?php echo $_GET['categoria']; ?>&subcategoria=<? echo $row_rsSubcategoria['subcategoria']; ?>&cidade=<? echo $_GET['cidade']; ?>&bairro=<? echo $_GET['bairro']; ?>"><?php echo $row_rsSubcategoria['subcategoria']; ?></option>
  <?php } while ($row_rsSubcategoria = mysql_fetch_assoc($rsSubcategoria)); ?>
  </select>
  </div>
  
 
  <div class="form-group">
    
    <select class="form-control"  name="cidade" onChange="MM_jumpMenu('parent',this,0)">
    
   <? if($_GET['cidade'] == '') { ?>
  <option value="" selected="selected">Escolha o local</option>
  <? } else { ?>
  <option value="<?php echo $_GET['cidade']; ?>" selected="selected"><?php echo $_GET['cidade']; ?></option>
  <? } ?>
  
    <?php do { ?>
    <option value="filtro.php?categoria=<?php echo $_GET['categoria']; ?>&subcategoria=<? echo $_GET['subcategoria']; ?>&cidade=<? echo $row_rsCidade['cidade']; ?>&bairro=<? echo $_GET['bairro']; ?>"><?php echo $row_rsCidade['cidade']; ?></option>
    <?php } while ($row_rsCidade = mysql_fetch_assoc($rsCidade)); ?>
  </select>
  </div>
  
  
   <div class="form-group">
    
    <select class="form-control"  name="bairro" onChange="MM_jumpMenu('parent',this,0)">
    <? if($_GET['bairro'] == '') { ?>
  <option value="" selected="selected">Escolha o bairro</option>
  <option value="">Todos os bairros</option>
  
  <? } else { ?>
   
  <option value="<?php echo $_GET['bairro']; ?>" selected="selected"><?php echo $_GET['bairro']; ?></option>
  <? } ?>
  
 
    <?php do { ?>
    <option value="filtro.php?categoria=<?php echo $_GET['categoria']; ?>&subcategoria=<? echo $_GET['subcategoria']; ?>&cidade=<? echo $_GET['cidade']; ?>&bairro=<? echo $row_rsBairro['bairro']; ?>"><?php echo $row_rsBairro['bairro']; ?></option>
    <?php } while ($row_rsBairro = mysql_fetch_assoc($rsBairro)); ?>
  </select>
  </div>
  
  <button type="submit" class="btn btn-danger">Buscar</button>
</form>


<p> 
<div class="alert alert-danger" role="alert">
Alerta				
</div>

  
  
   <h3> Últimos cadastrados:</h3>
 
 <div class="col-md-10">
 
  <?php do { ?>
  <?
  	$ccodigo = $row_sql['codigo'];
  	mysql_select_db($database_banco1, $banco1);
	$query_rsAvaliacao = "SELECT * FROM avaliacao WHERE codigo_prestador = '$ccodigo'";
	$rsAvaliacao = mysql_query($query_rsAvaliacao, $banco1) or die(mysql_error());
	$row_rsAvaliacao = mysql_fetch_assoc($rsAvaliacao);
	$totalRows_rsAvaliacao = mysql_num_rows($rsAvaliacao);

  ?>
  
  
  <div class="col-md-4 col-sm-4 col-xs-12">
    
  <div class="media" style="margin-bottom:20px">
  <a class="pull-left" href="perfil.php?codigo=<?php echo $row_sql['codigo']; ?>">
    <img src="up/<?php echo $row_sql['foto']; ?>" style="width:80px; height:80px;">  
  </a>
  <div class="media-body">
    <h5 class="media-heading"><?php echo $row_sql['nome']; ?></h5>
    <p><?php echo $row_sql['servico']; ?>
            <? 
			$cont = '0';
			$div = '0';
			  
				  do { ?>
				  <?php $cont = ( $row_rsAvaliacao['questao1'] + $row_rsAvaliacao['questao2'] + $row_rsAvaliacao['questao3'] + $row_rsAvaliacao['questao4']+ $row_rsAvaliacao['questao5'] ) / 5 ; ?>
				   <? 
				   $cont1 = $cont1 + $cont;
				   $div ++ ;
				   } while ($row_rsAvaliacao = mysql_fetch_assoc($rsAvaliacao)); 
   			   
			$final =  ($cont1/$div)*20;
			?>
            <? if($final <> '0') { ?>
            /  Avaliação: <? echo $cont1/$div ;
			?>
	</p>	
			<? } 
			$final = '0';
			$div = '0';
			$cont = '0';
			$cont1 = '0';
			?>
  </div>
  </div>

  </div>
  
  <?php } while ($row_sql = mysql_fetch_assoc($sql)); ?>
   
   </div>
    <div class="col-md-2 ">
   
   <?php include("banner_lateral.php"); ?>
   
    </div>
   
   
    
    </div>
    <? include("paginacao.php"); // Chama o arquivo que monta a paginação. ex: << anterior 1 2 3 4 5 próximo >> ?>
    
  </div>
  
  </div>
  
  
  
 
</div>
    
   
<?php include("rodape.php"); ?>
</body>
</html>
<?php
mysql_free_result($sql);

mysql_free_result($rsServico);

mysql_free_result($rsCidade);

mysql_free_result($rsBairro);

mysql_free_result($rsSubcategoria);

mysql_free_result($rsLogin);

?>

