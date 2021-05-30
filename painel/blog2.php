<?php require_once('../Connections/banco1.php'); ?>
<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Load the KT_back class
require_once('../includes/nxt/KT_back.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make unified connection variable
$conn_banco1 = new KT_connection($banco1, $database_banco1);

// Start trigger
$formValidation = new tNG_FormValidation();
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_FileDelete trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileDelete(&$tNG) {
  $deleteObj = new tNG_FileDelete($tNG);
  $deleteObj->setFolder("../up/");
  $deleteObj->setDbFieldName("imagem");
  return $deleteObj->Execute();
}
//end Trigger_FileDelete trigger

//start Trigger_ImageUpload trigger
//remove this line if you want to edit the code by hand 
function Trigger_ImageUpload(&$tNG) {
  $uploadObj = new tNG_ImageUpload($tNG);
  $uploadObj->setFormFieldName("imagem");
  $uploadObj->setDbFieldName("imagem");
  $uploadObj->setFolder("../up/");
  $uploadObj->setResize("true", 900, 0);
  $uploadObj->setMaxSize(1500);
  $uploadObj->setAllowedExtensions("gif, jpg, jpe, jpeg, png");
  $uploadObj->setRename("auto");
  return $uploadObj->Execute();
}
//end Trigger_ImageUpload trigger

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
$query_Recordset1 = "SELECT categoria, categoria FROM blog_categoria ORDER BY categoria";
$Recordset1 = mysql_query($query_Recordset1, $banco1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

// Make an insert transaction instance
$ins_blog = new tNG_multipleInsert($conn_banco1);
$tNGs->addTransaction($ins_blog);
// Register triggers
$ins_blog->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_blog->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_blog->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$ins_blog->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
// Add columns
$ins_blog->setTable("blog");
$ins_blog->addColumn("categoria", "STRING_TYPE", "POST", "categoria");
$ins_blog->addColumn("titulo", "STRING_TYPE", "POST", "titulo");
$ins_blog->addColumn("descricao", "STRING_TYPE", "POST", "descricao");
$ins_blog->addColumn("data_cadastro", "DATE_TYPE", "POST", "data_cadastro");
$ins_blog->addColumn("data_publicacao", "DATE_TYPE", "POST", "data_publicacao");
$ins_blog->addColumn("imagem", "FILE_TYPE", "FILES", "imagem");
$ins_blog->addColumn("video", "STRING_TYPE", "POST", "video");
$ins_blog->addColumn("autor", "STRING_TYPE", "POST", "autor");
$ins_blog->addColumn("usuario", "STRING_TYPE", "POST", "usuario");
$ins_blog->setPrimaryKey("codigo", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_blog = new tNG_multipleUpdate($conn_banco1);
$tNGs->addTransaction($upd_blog);
// Register triggers
$upd_blog->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_blog->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_blog->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$upd_blog->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
// Add columns
$upd_blog->setTable("blog");
$upd_blog->addColumn("categoria", "STRING_TYPE", "POST", "categoria");
$upd_blog->addColumn("titulo", "STRING_TYPE", "POST", "titulo");
$upd_blog->addColumn("descricao", "STRING_TYPE", "POST", "descricao");
$upd_blog->addColumn("data_cadastro", "DATE_TYPE", "POST", "data_cadastro");
$upd_blog->addColumn("data_publicacao", "DATE_TYPE", "POST", "data_publicacao");
$upd_blog->addColumn("imagem", "FILE_TYPE", "FILES", "imagem");
$upd_blog->addColumn("video", "STRING_TYPE", "POST", "video");
$upd_blog->addColumn("autor", "STRING_TYPE", "POST", "autor");
$upd_blog->addColumn("usuario", "STRING_TYPE", "POST", "usuario");
$upd_blog->setPrimaryKey("codigo", "NUMERIC_TYPE", "GET", "codigo");

// Make an instance of the transaction object
$del_blog = new tNG_multipleDelete($conn_banco1);
$tNGs->addTransaction($del_blog);
// Register triggers
$del_blog->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_blog->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$del_blog->registerTrigger("AFTER", "Trigger_FileDelete", 98);
// Add columns
$del_blog->setTable("blog");
$del_blog->setPrimaryKey("codigo", "NUMERIC_TYPE", "GET", "codigo");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsblog = $tNGs->getRecordset("blog");
$row_rsblog = mysql_fetch_assoc($rsblog);
$totalRows_rsblog = mysql_num_rows($rsblog);

if (!isset($_SESSION)) {
  session_start();
}
$oodologin = $_SESSION["odologin"]; 
$oodosenha = $_SESSION["odosenha"]; 

?>
<!DOCTYPE html>
<html lang="en" xmlns:wdg="http://ns.adobe.com/addt">
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
        <style>body{padding-top:60px;} .footer{text-align: center; border-top: solid 1px #eee; padding-top: 20px; margin-top: 20px;}</style>

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]--><link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" /><script src="../includes/common/js/base.js" type="text/javascript"></script><script src="../includes/common/js/utility.js" type="text/javascript"></script><script src="../includes/skins/style.js" type="text/javascript"></script><?php echo $tNGs->displayValidationRules();?><script src="../includes/nxt/scripts/form.js" type="text/javascript"></script><script src="../includes/nxt/scripts/form.js.php" type="text/javascript"></script><script type="text/javascript">
$NXT_FORM_SETTINGS = {
  duplicate_buttons: true,
  show_as_grid: true,
  merge_down_value: true
}
</script>
        <script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
        <script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
        <script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
        <script type="text/javascript" src="../includes/wdg/classes/Calendar.js"></script>
        <script type="text/javascript" src="../includes/wdg/classes/SmartDate.js"></script>
        <script type="text/javascript" src="../includes/wdg/calendar/calendar_stripped.js"></script>
        <script type="text/javascript" src="../includes/wdg/calendar/calendar-setup_stripped.js"></script>
        <script src="../includes/resources/calendar.js"></script>
        





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
                    <a class="navbar-brand" href="#">Siteconn - Painel 2.2</a>
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

                    <h1>Gerenciamento de Produtos</h1>
                    
                    <div style="margin-top:20px;">
                        <ul class="nav nav-tabs" role="tablist">
                            <li><a href="#">Usu&aacute;rio: <?php include("sessao.php"); ?></a></li>
                            <li class="active"><a href="#">Registros: <? echo $totalRows_rsbanner1 ;?></a></li>
                            
                        </ul>
                    </div>
                    
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    
                <br>
<br>
   
                   <? // INICIO DE PROGRAMAÇÃO ?>
<?php
	echo $tNGs->getErrorMsg();
?>
<div class="KT_tng">
  <h1>
    <?php 
// Show IF Conditional region1 
if (@$_GET['codigo'] == "") {
?>
<?php echo NXT_getResource("Insert_FH"); ?>
<?php 
// else Conditional region1
} else { ?>
<?php echo NXT_getResource("Update_FH"); ?>
<?php } 
// endif Conditional region1
?>
    Blog </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
      <?php $cnt1++; ?>
      <?php 
// Show IF Conditional region1 
if (@$totalRows_rsblog > 1) {
?>
      <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
      <?php } 
// endif Conditional region1
?>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <tr>
	<td class="KT_th"><label for="categoria_<?php echo $cnt1; ?>">Categoria:</label></td>
	<td>
		<select name="categoria_<?php echo $cnt1; ?>" id="categoria_<?php echo $cnt1; ?>">
      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
<?php 
do {  
?>
			<option value="<?php echo $row_Recordset1['categoria']?>"<?php if (!(strcmp($row_Recordset1['categoria'], $row_rsblog['categoria']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['categoria']?></option>
<?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
		</select>
		<?php echo $tNGs->displayFieldError("blog", "categoria", $cnt1); ?>
	</td>
</tr>
        <tr>
	<td class="KT_th"><label for="titulo_<?php echo $cnt1; ?>">Titulo:</label></td>
	<td>
		<input type="text" name="titulo_<?php echo $cnt1; ?>" id="titulo_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsblog['titulo']); ?>" size="32" maxlength="255" />
		<?php echo $tNGs->displayFieldHint("titulo");?>
		<?php echo $tNGs->displayFieldError("blog", "titulo", $cnt1); ?>
	</td>
</tr>
        <tr>
	<td class="KT_th"><label for="descricao_<?php echo $cnt1; ?>">Descricao:</label></td>
	<td>
		
        
        
        
<link rel="stylesheet" type="text/css" href="lib/css/bootstrap.min.css"></link>
<link rel="stylesheet" type="text/css" href="lib/css/prettify.css"></link>
<link rel="stylesheet" type="text/css" href="src/bootstrap-wysihtml5.css"></link>

<style type="text/css" media="screen">
	.btn.jumbo {
		font-size: 20px;
		font-weight: normal;
		margin-right: 10px;
		-webkit-border-radius: 6px;
		-moz-border-radius: 6px;
		border-radius: 6px;
	}
</style>


	<div class="hero-unit" style="margin-top:40px">
		<textarea class="textarea" name="descricao_<?php echo $cnt1; ?>" id="descricao_<?php echo $cnt1; ?>" style="width: 500px; height: 400px"><?php echo $row_rsblog['descricao']; ?></textarea>
	</div>
	


<script src="lib/js/wysihtml5-0.3.0.js"></script>
<script src="lib/js/jquery-1.7.2.min.js"></script>
<script src="lib/js/prettify.js"></script>
<script src="lib/js/bootstrap.min.js"></script>
<script src="src/bootstrap-wysihtml5.js"></script>

<script>
	$('.textarea').wysihtml5();
</script>

<script type="text/javascript" charset="utf-8">
	$(prettyPrint);
</script>
        
        
        
        
        
        
        
        
      	<?php echo $tNGs->displayFieldHint("descricao");?>
		<?php echo $tNGs->displayFieldError("blog", "descricao", $cnt1); ?>
	</td>
</tr>
        <tr>
	<td class="KT_th"><label for="data_cadastro_<?php echo $cnt1; ?>">Data de cadastro:</label></td>
	<td>
		<input name="data_cadastro_<?php echo $cnt1; ?>" id="data_cadastro_<?php echo $cnt1; ?>" value="<?php echo KT_formatDate($row_rsblog['data_cadastro']); ?>" size="10" maxlength="22" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="false" wdg:restricttomask="no" wdg:readonly="true" />
		<?php echo $tNGs->displayFieldHint("data_cadastro");?>
		<?php echo $tNGs->displayFieldError("blog", "data_cadastro", $cnt1); ?>
	</td>
</tr>
        <tr>
	<td class="KT_th"><label for="data_publicacao_<?php echo $cnt1; ?>">Publicado:</label></td>
	<td>
		<input name="data_publicacao_<?php echo $cnt1; ?>" id="data_publicacao_<?php echo $cnt1; ?>" value="<?php echo KT_formatDate($row_rsblog['data_publicacao']); ?>" size="10" maxlength="22" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="false" wdg:restricttomask="no" wdg:readonly="true" />
		<?php echo $tNGs->displayFieldHint("data_publicacao");?>
		<?php echo $tNGs->displayFieldError("blog", "data_publicacao", $cnt1); ?>
	</td>
</tr>
        <tr>
	<td class="KT_th"><label for="imagem_<?php echo $cnt1; ?>">Imagem:</label></td>
	<td>
		<input type="file" name="imagem_<?php echo $cnt1; ?>" id="imagem_<?php echo $cnt1; ?>" size="32" />
		<?php echo $tNGs->displayFieldError("blog", "imagem", $cnt1); ?>
	</td>
</tr>
        <tr>
	<td class="KT_th"><label for="video_<?php echo $cnt1; ?>">Video:</label></td>
	<td>
		<input type="text" name="video_<?php echo $cnt1; ?>" id="video_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsblog['video']); ?>" size="32" maxlength="255" />
		<?php echo $tNGs->displayFieldHint("video");?>
		<?php echo $tNGs->displayFieldError("blog", "video", $cnt1); ?>
	</td>
</tr>
        <tr>
	<td class="KT_th"><label for="autor_<?php echo $cnt1; ?>">Autor:</label></td>
	<td>
		<input type="text" name="autor_<?php echo $cnt1; ?>" id="autor_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsblog['autor']); ?>" size="32" maxlength="255" />
		<?php echo $tNGs->displayFieldHint("autor");?>
		<?php echo $tNGs->displayFieldError("blog", "autor", $cnt1); ?>
	</td>
</tr>
        
      </table>
      <input type="hidden" name="kt_pk_blog_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsblog['kt_pk_blog']); ?>" />
      
<input type="hidden" name="usuario_<?php echo $cnt1; ?>" id="usuario_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsblog['usuario']); ?>" />

      
      <?php } while ($row_rsblog = mysql_fetch_assoc($rsblog)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['codigo'] == "") {
      ?>
          <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
          <?php 
      // else Conditional region1
      } else { ?>
          
	<div class="KT_operations">
	<input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'codigo')" />
	</div>
	

          <input type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" />
          <input type="submit" name="KT_Delete1" value="<?php echo NXT_getResource("Delete_FB"); ?>" onclick="return confirm('<?php echo NXT_getResource("Are you sure?"); ?>');" />
          <?php }
      // endif Conditional region1
      ?>
          <input type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onclick="return UNI_navigateCancel(event, '../includes/nxt/back.php')" />
        </div>
      </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<p>&nbsp;</p>
<? // FIM DE PROGRAMAÇÃO ?>
                   
                   
                   
                   
                </div>
                
            </div>
            
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    
                    <?php include("menu.php"); ?>
                
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
<?php
mysql_free_result($Recordset1);
?>
