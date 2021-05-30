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

$time = date('Y-m');
$dia = date('Y-m-d');

if( $_GET['dia'] <> '' ) { 
$selecinado = $_GET['dia'];
} else { 
$selecinado = $dia;
}

mysql_select_db($database_banco1, $banco1);
$query_rsAgenda = "SELECT * FROM agenda WHERE data >= '$dia'";
$rsAgenda = mysql_query($query_rsAgenda, $banco1) or die(mysql_error());
$row_rsAgenda = mysql_fetch_assoc($rsAgenda);
$totalRows_rsAgenda = mysql_num_rows($rsAgenda);

mysql_select_db($database_banco1, $banco1);
$query_rsSelecionado = "SELECT * FROM agenda WHERE agenda.`data` = '$selecinado'";
$rsSelecionado = mysql_query($query_rsSelecionado, $banco1) or die(mysql_error());
$row_rsSelecionado = mysql_fetch_assoc($rsSelecionado);
$totalRows_rsSelecionado = mysql_num_rows($rsSelecionado);


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
    
    <link href='http://fonts.googleapis.com/css?family=Economica' rel='stylesheet' type='text/css'>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
    <!-- Respomsive slider -->
    <link href="css/responsive-calendar.css" rel="stylesheet">


    
<div class="container">
    <div class="page-header"><h1>Agenda</h1></div>
    
    
	

<div class="row">
    	
        
     <div class="col-md-6 col-sm-12 col-xs-12">
   
   	
    <h3>Lista de Eventos</h3>
   	
	
    <? if($row_rsSelecionado['codigo'] <> '') { ?>
	<?php do { ?>
	Evento: <?php echo $row_rsSelecionado['evento']; ?><br>
	Data: <?php echo $row_rsSelecionado['data']; ?> Hora: <?php echo $row_rsSelecionado['hora']; ?><br>
	Local: <?php echo $row_rsSelecionado['local']; ?> <br>
	Descri&ccedil;&atilde;o:<br>
	<?php echo $row_rsSelecionado['descricao']; ?><br>
	Por: <?php echo $row_rsSelecionado['autor']; ?><br>
    <br><br>
	<?php } while ($row_rsSelecionado = mysql_fetch_assoc($rsSelecionado)); ?>
    <? } else { ?>
    Sem agenda cadastrar nessa data.
	<? } ?>
	
   	</div>   
        
        
        
	<div class="col-md-6 col-sm-12 col-xs-12">
       
       <div class="responsive-calendar">
        <div class="controls">
            <a class="pull-left" data-go="prev"><div class="btn btn-primary">Anterior</div></a>
            <h4><span data-head-year></span> <span data-head-month></span></h4>
            <a class="pull-right" data-go="next"><div class="btn btn-primary">Proximo</div></a>
        </div><hr/>
        <div class="day-headers">
          <div class="day header">Seg</div>
          <div class="day header">Ter</div>
          <div class="day header">Qua</div>
          <div class="day header">Qui</div>
          <div class="day header">Sex</div>
          <div class="day header">Sab</div>
          <div class="day header">Dom</div>
        </div>
        <div class="days" data-group="days">
          
        </div>
      </div>
      <!-- Responsive calendar - END -->
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/responsive-calendar.js"></script>
    <script type="text/javascript">
      $(document).ready(function () {
        $(".responsive-calendar").responsiveCalendar({
          time: '<? echo $time; ?>',
          events: {
            <? do { ?>
			<?
			$ddia = $row_rsAgenda['data'];
			mysql_select_db($database_banco1, $banco1);
			$query_rsDia = "SELECT * FROM agenda WHERE agenda.`data` = '$ddia'";
			$rsDia = mysql_query($query_rsDia, $banco1) or die(mysql_error());
			$row_rsDia = mysql_fetch_assoc($rsDia);
			$totalRows_rsDia = mysql_num_rows($rsDia);
			?>
			
			"<?php echo $row_rsAgenda['data']; ?>": {"number": <?php echo $totalRows_rsDia ?>, "url": "?dia=<?php echo $row_rsAgenda['data']; ?>"},
            <? } while ($row_rsAgenda = mysql_fetch_assoc($rsAgenda)); ?>
		    }
        });
      });
    </script>
	</div>
    
    
    
        
  </div>
    
<br>
   
	
  	
   
    
  	
</div>

<script src="js/bootstrap.min.js"></script>
