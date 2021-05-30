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

mysql_select_db($database_banco1, $banco1);
$query_rsBlog = "SELECT * FROM blog";
$rsBlog = mysql_query($query_rsBlog, $banco1) or die(mysql_error());
$row_rsBlog = mysql_fetch_assoc($rsBlog);
$totalRows_rsBlog = mysql_num_rows($rsBlog);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

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
    <link href="blog.css" rel="stylesheet" type="text/css">
    
    
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript">
		 $(function($){
			//quando o link for clicado
			$("#mais").click(function(){
				//recuperar o id do ultimo registro carregado na pagina
				var ultimo = $("#registros p:last").attr("lang");
				//mensagem de carregamento
				$("#status").html('<p>Carregando...</p>');
				//fazer a requisição via post com ajax
				$.post("blog_recuperar.php", {ultimo: ultimo}, function(valor){
					//ocultar a mensagem de carregamento
					$("#status").empty();
					//coloca os registros na div
					$("#registros").append(valor);
				});
			});
		 });
		</script>


    
  </head>

  <body>

      <div class="container">

      <div class="blog-header">
        <h1 class="blog-title">Sitepack Blog</h1>
        <p class="lead blog-description">O pack blog da siteconn.</p>
      </div>

       
      
      <div class="row">

        <div class="col-sm-8 blog-main">

         
		<div id="registros">
			<?php
				//seleciono e executo o sql de seleção primaria
				$strSQL = "SELECT * FROM blog ORDER BY codigo DESC LIMIT 0,1";
				$stmt = $pdo->prepare($strSQL);
				$stmt->execute();
				//listo os registros primarios
				while($row = $stmt->fetchObject()){
					echo '<p lang="'.$row->codigo.'"><h1>'.$row->titulo.'</h1></p>';
					echo '<div class="alert alert-success" role="alert">';
					echo 	'<p lang="'.$row->codigo.'">Por: '.$row->autor.' | Data: '.$row->data_publicacao.'</p>';
				    echo '</div>';
					echo '<p lang="'.$row->codigo.'"><img src="up/'.$row->imagem.'" class="img-responsive"></p>';	
					echo '<p lang="'.$row->codigo.'">'.$row->descricao.'</p>';	
				}
			?>
</div><!--- registros --->



<br>
<span id="status"></span>


<button type="button" class="btn btn-default btn-lg" ONCLICK="javascript:func();" id="mais">
  <span class="glyphicon glyphicon-home"  ></span> Mais registros &raquo;
</button>

</div><!-- /.blog-main -->

        <div class="col-sm-4 cblog-sidebar">
          <div class="sidebar-module sidebar-module-inset">
            <h4>Sobre N&oacute;s</h4>
            <p>A&nbsp;<strong>SITE CONN&nbsp;</strong>&eacute; uma empresa de tecnologia especializada no desenvolvimento de website, logomarcas e identidade coorporativa para pequenas, m&eacute;dias e grandes empresas. Com clientes em todo o estado de Mato Grosso e at&eacute; em outros como Rond&ocirc;nia e Mato Grosso do Sul, a&nbsp;<strong>SITE CONN,</strong>&nbsp;hoje, possui uma estrutura completa para atender todos os tipos de servi&ccedil;os, desde pequenos site (hotsites) at&eacute; os mais complexos sistemas com bando de dados ou campanhas on-line, sempre adequando as necessidades de cada cliente.</p>
            <p>Hoje, a&nbsp;<strong>SITE CONN</strong>&nbsp;conta com servidores de alta capacidade de armazenamento e velocidade, conta tamb&eacute;m com profissionais treinados com anos de experi&ecirc;ncia no setor, alem de sempre estar se aperfei&ccedil;oando com o que h&aacute; de novidades no mercado do webdesign.</p>
            <p>Conhe&ccedil;a nossos servi&ccedil;os que com certeza se adequara perfeitamente as necessidades de sua empresa.Lique (65) 4104/0456 e solicite nossa visita.</p>
          </div>
          <div class="sidebar-module">
            <h4>Archives</h4>
            <ol class="list-unstyled">
              <li><a href="#">March 2014</a></li>
              <li><a href="#">February 2014</a></li>
              <li><a href="#">January 2014</a></li>
              <li><a href="#">December 2013</a></li>
              <li><a href="#">November 2013</a></li>
              <li><a href="#">October 2013</a></li>
              <li><a href="#">September 2013</a></li>
              <li><a href="#">August 2013</a></li>
              <li><a href="#">July 2013</a></li>
              <li><a href="#">June 2013</a></li>
              <li><a href="#">May 2013</a></li>
              <li><a href="#">April 2013</a></li>
            </ol>
          </div>
          <div class="sidebar-module">
            <h4>Elsewhere</h4>
            <ol class="list-unstyled">
              <li><a href="#">GitHub</a></li>
              <li><a href="#">Twitter</a></li>
              <li><a href="#">Facebook</a></li>
            </ol>
          </div>
        </div><!-- /.blog-sidebar -->

      </div><!-- /.row -->

    </div><!-- /.container -->

    <div class="blog-footer">
      <p>Blog template built for <a href="http://getbootstrap.com">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
      <p>
        <a href="#">Back to top</a>
      </p>
    </div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>

  <script src="js/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  <script src="js/ie10-viewport-bug-workaround.js"></script>

  </body>
</html>
<?php
mysql_free_result($rsBlog);
?>
