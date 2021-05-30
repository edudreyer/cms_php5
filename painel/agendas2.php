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
  $uploadObj->setResize("true", 500, 0);
  $uploadObj->setMaxSize(1500);
  $uploadObj->setAllowedExtensions("gif, jpg, jpe, jpeg, png");
  $uploadObj->setRename("auto");
  return $uploadObj->Execute();
}
//end Trigger_ImageUpload trigger

// Make an insert transaction instance
$ins_agenda = new tNG_multipleInsert($conn_banco1);
$tNGs->addTransaction($ins_agenda);
// Register triggers
$ins_agenda->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_agenda->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_agenda->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$ins_agenda->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
// Add columns
$ins_agenda->setTable("agenda");
$ins_agenda->addColumn("evento", "STRING_TYPE", "POST", "evento");
$ins_agenda->addColumn("data", "DATE_TYPE", "POST", "data");
$ins_agenda->addColumn("hora", "DATE_TYPE", "POST", "hora");
$ins_agenda->addColumn("local", "STRING_TYPE", "POST", "local");
$ins_agenda->addColumn("descricao", "STRING_TYPE", "POST", "descricao");
$ins_agenda->addColumn("imagem", "FILE_TYPE", "FILES", "imagem");
$ins_agenda->addColumn("autor", "STRING_TYPE", "POST", "autor");
$ins_agenda->addColumn("usuario", "STRING_TYPE", "POST", "usuario");
$ins_agenda->setPrimaryKey("codigo", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_agenda = new tNG_multipleUpdate($conn_banco1);
$tNGs->addTransaction($upd_agenda);
// Register triggers
$upd_agenda->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_agenda->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_agenda->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$upd_agenda->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
// Add columns
$upd_agenda->setTable("agenda");
$upd_agenda->addColumn("evento", "STRING_TYPE", "POST", "evento");
$upd_agenda->addColumn("data", "DATE_TYPE", "POST", "data");
$upd_agenda->addColumn("hora", "DATE_TYPE", "POST", "hora");
$upd_agenda->addColumn("local", "STRING_TYPE", "POST", "local");
$upd_agenda->addColumn("descricao", "STRING_TYPE", "POST", "descricao");
$upd_agenda->addColumn("imagem", "FILE_TYPE", "FILES", "imagem");
$upd_agenda->addColumn("autor", "STRING_TYPE", "POST", "autor");
$upd_agenda->addColumn("usuario", "STRING_TYPE", "POST", "usuario");
$upd_agenda->setPrimaryKey("codigo", "NUMERIC_TYPE", "GET", "codigo");

// Make an instance of the transaction object
$del_agenda = new tNG_multipleDelete($conn_banco1);
$tNGs->addTransaction($del_agenda);
// Register triggers
$del_agenda->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_agenda->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$del_agenda->registerTrigger("AFTER", "Trigger_FileDelete", 98);
// Add columns
$del_agenda->setTable("agenda");
$del_agenda->setPrimaryKey("codigo", "NUMERIC_TYPE", "GET", "codigo");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsagenda = $tNGs->getRecordset("agenda");
$row_rsagenda = mysql_fetch_assoc($rsagenda);
$totalRows_rsagenda = mysql_num_rows($rsagenda);

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
        
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?>
<script src="../includes/nxt/scripts/form.js" type="text/javascript"></script>
<script src="../includes/nxt/scripts/form.js.php" type="text/javascript"></script>
<script type="text/javascript">
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
            <?php echo NXT_getResource("Insert_FH"); ?>
            <?php 
// else Conditional region1
} else { ?>
            <?php echo NXT_getResource("Update_FH"); ?>
            <?php } 
// endif Conditional region1
?>
          Agenda </h1>
        <div class="KT_tngform">
          <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
            <?php $cnt1 = 0; ?>
            <?php do { ?>
              <?php $cnt1++; ?>
              <?php 
// Show IF Conditional region1 
if (@$totalRows_rsagenda > 1) {
?>
                <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
                <?php } 
// endif Conditional region1
?>
              <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                <tr>
                  <td class="KT_th"><label for="evento_<?php echo $cnt1; ?>">Evento:</label></td>
                  <td><input type="text" name="evento_<?php echo $cnt1; ?>" id="evento_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsagenda['evento']); ?>" size="32" maxlength="255" />
                      <?php echo $tNGs->displayFieldHint("evento");?> <?php echo $tNGs->displayFieldError("agenda", "evento", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="data_<?php echo $cnt1; ?>">Data:</label></td>
                  <td><input name="data_<?php echo $cnt1; ?>" id="data_<?php echo $cnt1; ?>" value="<?php echo KT_formatDate($row_rsagenda['data']); ?>" size="10" maxlength="22" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="false" wdg:restricttomask="no" wdg:readonly="true" />
                      <?php echo $tNGs->displayFieldHint("data");?> <?php echo $tNGs->displayFieldError("agenda", "data", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="hora_<?php echo $cnt1; ?>">Hora:</label></td>
                  <td><input type="text" name="hora_<?php echo $cnt1; ?>" id="hora_<?php echo $cnt1; ?>" value="<?php echo KT_formatDate($row_rsagenda['hora']); ?>" size="10" maxlength="22" />
                      <?php echo $tNGs->displayFieldHint("hora");?> <?php echo $tNGs->displayFieldError("agenda", "hora", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="local_<?php echo $cnt1; ?>">Local:</label></td>
                  <td><input type="text" name="local_<?php echo $cnt1; ?>" id="local_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsagenda['local']); ?>" size="32" maxlength="255" />
                      <?php echo $tNGs->displayFieldHint("local");?> <?php echo $tNGs->displayFieldError("agenda", "local", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="descricao_<?php echo $cnt1; ?>">Descrição:</label></td>
                  <td><textarea name="descricao_<?php echo $cnt1; ?>" id="descricao_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rsagenda['descricao']); ?></textarea>
                      <?php echo $tNGs->displayFieldHint("descricao");?> <?php echo $tNGs->displayFieldError("agenda", "descricao", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="imagem_<?php echo $cnt1; ?>">Imagem:</label></td>
                  <td><input type="file" name="imagem_<?php echo $cnt1; ?>" id="imagem_<?php echo $cnt1; ?>" size="32" />
                      <?php echo $tNGs->displayFieldError("agenda", "imagem", $cnt1); ?> </td>
                </tr>
                <tr>
                  <td class="KT_th"><label for="autor_<?php echo $cnt1; ?>">Autor:</label></td>
                  <td><input type="text" name="autor_<?php echo $cnt1; ?>" id="autor_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsagenda['autor']); ?>" size="32" maxlength="255" />
                      <?php echo $tNGs->displayFieldHint("autor");?> <?php echo $tNGs->displayFieldError("agenda", "autor", $cnt1); ?> </td>
                </tr>
              </table>
              <input type="hidden" name="kt_pk_agenda_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsagenda['kt_pk_agenda']); ?>" />
              <input type="hidden" name="usuario_<?php echo $cnt1; ?>" id="usuario_<?php echo $cnt1; ?>" value="<?php echo $row_rsLogin['nome']; ?>" />
              <?php } while ($row_rsagenda = mysql_fetch_assoc($rsagenda)); ?>
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
