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
  $deleteObj->setDbFieldName("arquivo");
  return $deleteObj->Execute();
}
//end Trigger_FileDelete trigger

//start Trigger_FileUpload trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileUpload(&$tNG) {
  $uploadObj = new tNG_FileUpload($tNG);
  $uploadObj->setFormFieldName("arquivo");
  $uploadObj->setDbFieldName("arquivo");
  $uploadObj->setFolder("../up/");
  $uploadObj->setMaxSize(5500);
  $uploadObj->setAllowedExtensions("pdf, txt, doc, docx, gif, swf, png, jpg, jpeg");
  $uploadObj->setRename("auto");
  return $uploadObj->Execute();
}
//end Trigger_FileUpload trigger

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
$query_Recordset1 = "SELECT * FROM banner_local";
$Recordset1 = mysql_query($query_Recordset1, $banco1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

// Make an insert transaction instance
$ins_banner = new tNG_multipleInsert($conn_banco1);
$tNGs->addTransaction($ins_banner);
// Register triggers
$ins_banner->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_banner->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_banner->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$ins_banner->registerTrigger("AFTER", "Trigger_FileUpload", 97);
// Add columns
$ins_banner->setTable("banner");
$ins_banner->addColumn("nome", "STRING_TYPE", "POST", "nome");
$ins_banner->addColumn("descricao", "STRING_TYPE", "POST", "descricao");
$ins_banner->addColumn("local", "STRING_TYPE", "POST", "local", "{Recordset1.local}");
$ins_banner->addColumn("tipo", "STRING_TYPE", "POST", "tipo");
$ins_banner->addColumn("arquivo", "FILE_TYPE", "FILES", "arquivo");
$ins_banner->addColumn("url_destino", "STRING_TYPE", "POST", "url_destino");
$ins_banner->addColumn("data_inicial", "DATE_TYPE", "POST", "data_inicial");
$ins_banner->addColumn("data_final", "DATE_TYPE", "POST", "data_final");
$ins_banner->addColumn("usuario", "STRING_TYPE", "POST", "usuario");
$ins_banner->setPrimaryKey("codigo", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_banner = new tNG_multipleUpdate($conn_banco1);
$tNGs->addTransaction($upd_banner);
// Register triggers
$upd_banner->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_banner->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_banner->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$upd_banner->registerTrigger("AFTER", "Trigger_FileUpload", 97);
// Add columns
$upd_banner->setTable("banner");
$upd_banner->addColumn("nome", "STRING_TYPE", "POST", "nome");
$upd_banner->addColumn("descricao", "STRING_TYPE", "POST", "descricao");
$upd_banner->addColumn("local", "STRING_TYPE", "POST", "local");
$upd_banner->addColumn("tipo", "STRING_TYPE", "POST", "tipo");
$upd_banner->addColumn("arquivo", "FILE_TYPE", "FILES", "arquivo");
$upd_banner->addColumn("url_destino", "STRING_TYPE", "POST", "url_destino");
$upd_banner->addColumn("data_inicial", "DATE_TYPE", "POST", "data_inicial");
$upd_banner->addColumn("data_final", "DATE_TYPE", "POST", "data_final");
$upd_banner->addColumn("usuario", "STRING_TYPE", "POST", "usuario");
$upd_banner->setPrimaryKey("codigo", "NUMERIC_TYPE", "GET", "codigo");

// Make an instance of the transaction object
$del_banner = new tNG_multipleDelete($conn_banco1);
$tNGs->addTransaction($del_banner);
// Register triggers
$del_banner->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_banner->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$del_banner->registerTrigger("AFTER", "Trigger_FileDelete", 98);
// Add columns
$del_banner->setTable("banner");
$del_banner->setPrimaryKey("codigo", "NUMERIC_TYPE", "GET", "codigo");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsbanner = $tNGs->getRecordset("banner");
$row_rsbanner = mysql_fetch_assoc($rsbanner);
$totalRows_rsbanner = mysql_num_rows($rsbanner);

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
        <style>body{padding-top:60px;} .footer{text-align: center; border-top: solid 1px #eee; padding-top: 20px; margin-top: 20px;}</style>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" /><script src="../includes/common/js/base.js" type="text/javascript"></script><script src="../includes/common/js/utility.js" type="text/javascript"></script><script src="../includes/skins/style.js" type="text/javascript"></script><?php echo $tNGs->displayValidationRules();?><script src="../includes/nxt/scripts/form.js" type="text/javascript"></script><script src="../includes/nxt/scripts/form.js.php" type="text/javascript"></script><script type="text/javascript">
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

                    <h1>Gerenciamento de Banners</h1>
                    
                    <div style="margin-top:20px;">
                        <ul class="nav nav-tabs" role="tablist">
                            <li><a href="#">Usu&aacute;rio: <?php include("sessao.php"); ?></a></li>
                            <li class="active"></li>
                            
                        </ul>
                    </div>
                    
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    
                   
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
    <?php // echo NXT_getResource("Insert_FH"); ?>
    <?php 
// else Conditional region1
} else { ?>
    <?php //echo NXT_getResource("Update_FH"); ?>
    <?php } 
// endif Conditional region1
?>
  </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
      <?php $cnt1++; ?>
      <?php 
// Show IF Conditional region1 
if (@$totalRows_rsbanner > 1) {
?>
      <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
      <?php } 
// endif Conditional region1
?>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <tr>
          <td class="KT_th"><label for="nome_<?php echo $cnt1; ?>">Titulo:</label></td>
          <td><input type="text" name="nome_<?php echo $cnt1; ?>" id="nome_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsbanner['nome']); ?>" size="32" maxlength="255" />
              <?php echo $tNGs->displayFieldHint("nome");?> <?php echo $tNGs->displayFieldError("banner", "nome", $cnt1); ?> </td>
        </tr>
        <tr>
          <td class="KT_th"><label for="descricao_<?php echo $cnt1; ?>">Descricao:</label></td>
          <td><textarea name="descricao_<?php echo $cnt1; ?>" id="descricao_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rsbanner['descricao']); ?></textarea>
              <?php echo $tNGs->displayFieldHint("descricao");?> <?php echo $tNGs->displayFieldError("banner", "descricao", $cnt1); ?> </td>
        </tr>
        <tr>
          <td class="KT_th"><label for="local_<?php echo $cnt1; ?>">Local:</label></td>
          <td><select name="local_<?php echo $cnt1; ?>" id="local_<?php echo $cnt1; ?>">
            <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
            <?php 
do {  
?>
            <option value="<?php echo $row_Recordset1['local']?>"<?php if (!(strcmp($row_Recordset1['local'], $row_rsbanner['local']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['local']?></option>
            <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
          </select>
              <?php echo $tNGs->displayFieldError("banner", "local", $cnt1); ?> </td>
        </tr>
        <tr>
          <td class="KT_th"><label for="tipo_<?php echo $cnt1; ?>">Tipo:</label></td>
          <td><select name="tipo_<?php echo $cnt1; ?>" id="tipo_<?php echo $cnt1; ?>">
            <option value="Imagem" <?php if (!(strcmp("Imagem", KT_escapeAttribute($row_rsbanner['tipo'])))) {echo "SELECTED";} ?>>Imagem</option>
            <option value="Flash" <?php if (!(strcmp("Flash", KT_escapeAttribute($row_rsbanner['tipo'])))) {echo "SELECTED";} ?>>Flash</option>
          </select>
              <?php echo $tNGs->displayFieldError("banner", "tipo", $cnt1); ?> </td>
        </tr>
        <tr>
          <td class="KT_th"><label for="arquivo_<?php echo $cnt1; ?>">Arquivo:</label></td>
          <td><input type="file" name="arquivo_<?php echo $cnt1; ?>" id="arquivo_<?php echo $cnt1; ?>" size="32" />
              <?php echo $tNGs->displayFieldError("banner", "arquivo", $cnt1); ?> </td>
        </tr>
        <tr>
          <td class="KT_th"><label for="url_destino_<?php echo $cnt1; ?>">Url:</label></td>
          <td><input type="text" name="url_destino_<?php echo $cnt1; ?>" id="url_destino_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsbanner['url_destino']); ?>" size="32" maxlength="255" />
              <?php echo $tNGs->displayFieldHint("url_destino");?> <?php echo $tNGs->displayFieldError("banner", "url_destino", $cnt1); ?> </td>
        </tr>
        <tr>
          <td class="KT_th"><label for="data_inicial_<?php echo $cnt1; ?>">Data inicial:</label></td>
          <td><input name="data_inicial_<?php echo $cnt1; ?>" id="data_inicial_<?php echo $cnt1; ?>" value="<?php echo KT_formatDate($row_rsbanner['data_inicial']); ?>" size="10" maxlength="22" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="false" wdg:restricttomask="no" wdg:readonly="true" />
              <?php echo $tNGs->displayFieldHint("data_inicial");?> <?php echo $tNGs->displayFieldError("banner", "data_inicial", $cnt1); ?> </td>
        </tr>
        <tr>
          <td class="KT_th"><label for="data_final_<?php echo $cnt1; ?>">Data final:</label></td>
          <td><input name="data_final_<?php echo $cnt1; ?>" id="data_final_<?php echo $cnt1; ?>" value="<?php echo KT_formatDate($row_rsbanner['data_final']); ?>" size="10" maxlength="22" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="false" wdg:restricttomask="no" wdg:readonly="true" />
              <?php echo $tNGs->displayFieldHint("data_final");?> <?php echo $tNGs->displayFieldError("banner", "data_final", $cnt1); ?> </td>
        </tr>
      </table>
      <input type="hidden" name="kt_pk_banner_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsbanner['kt_pk_banner']); ?>" />
      <input type="hidden" name="usuario_<?php echo $cnt1; ?>" id="usuario_<?php echo $cnt1; ?>" value="<?php echo $row_rsLogin['nome']; ?>" />
      <?php } while ($row_rsbanner = mysql_fetch_assoc($rsbanner)); ?>
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
