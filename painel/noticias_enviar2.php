<?php require_once('../Connections/banco1.php'); ?>
<?php
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
  $uploadObj->setResize("true", 600, 0);
  $uploadObj->setMaxSize(1500);
  $uploadObj->setAllowedExtensions("gif, jpg, jpe, jpeg, png");
  $uploadObj->setRename("auto");
  return $uploadObj->Execute();
}
//end Trigger_ImageUpload trigger

// Make an insert transaction instance
$ins_noticia_imagem = new tNG_multipleInsert($conn_banco1);
$tNGs->addTransaction($ins_noticia_imagem);
// Register triggers
$ins_noticia_imagem->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_noticia_imagem->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_noticia_imagem->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$ins_noticia_imagem->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
// Add columns
$ins_noticia_imagem->setTable("noticia_imagem");
$ins_noticia_imagem->addColumn("codigo_noticia", "NUMERIC_TYPE", "POST", "codigo_noticia");
$ins_noticia_imagem->addColumn("imagem", "FILE_TYPE", "FILES", "imagem");
$ins_noticia_imagem->addColumn("descricao", "STRING_TYPE", "POST", "descricao");
$ins_noticia_imagem->setPrimaryKey("codigo", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_noticia_imagem = new tNG_multipleUpdate($conn_banco1);
$tNGs->addTransaction($upd_noticia_imagem);
// Register triggers
$upd_noticia_imagem->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_noticia_imagem->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_noticia_imagem->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$upd_noticia_imagem->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
// Add columns
$upd_noticia_imagem->setTable("noticia_imagem");
$upd_noticia_imagem->addColumn("codigo_noticia", "NUMERIC_TYPE", "POST", "codigo_noticia");
$upd_noticia_imagem->addColumn("imagem", "FILE_TYPE", "FILES", "imagem");
$upd_noticia_imagem->addColumn("descricao", "STRING_TYPE", "POST", "descricao");
$upd_noticia_imagem->setPrimaryKey("codigo", "NUMERIC_TYPE", "GET", "codigo");

// Make an instance of the transaction object
$del_noticia_imagem = new tNG_multipleDelete($conn_banco1);
$tNGs->addTransaction($del_noticia_imagem);
// Register triggers
$del_noticia_imagem->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_noticia_imagem->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$del_noticia_imagem->registerTrigger("AFTER", "Trigger_FileDelete", 98);
// Add columns
$del_noticia_imagem->setTable("noticia_imagem");
$del_noticia_imagem->setPrimaryKey("codigo", "NUMERIC_TYPE", "GET", "codigo");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsnoticia_imagem = $tNGs->getRecordset("noticia_imagem");
$row_rsnoticia_imagem = mysql_fetch_assoc($rsnoticia_imagem);
$totalRows_rsnoticia_imagem = mysql_num_rows($rsnoticia_imagem);

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

                    <h1>Gerenciamento de Noticia</h1>
                    
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
                         <?php // echo NXT_getResource("Insert_FH"); ?>
                         <?php 
// else Conditional region1
} else { ?>
                         <?php // echo NXT_getResource("Update_FH"); ?>
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
if (@$totalRows_rsnoticia_imagem > 1) {
?>
                             <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
                             <?php } 
// endif Conditional region1
?>
                           <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                             <tr>
                               <td class="KT_th"><label for="imagem_<?php echo $cnt1; ?>">Imagem:</label></td>
                               <td><input type="file" name="imagem_<?php echo $cnt1; ?>" id="imagem_<?php echo $cnt1; ?>" size="32" />
                                   <?php echo $tNGs->displayFieldError("noticia_imagem", "imagem", $cnt1); ?> </td>
                             </tr>
                             <tr>
                               <td class="KT_th"><label for="descricao_<?php echo $cnt1; ?>">Descrição:</label></td>
                               <td><textarea name="descricao_<?php echo $cnt1; ?>" id="descricao_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rsnoticia_imagem['descricao']); ?></textarea>
                                   <?php echo $tNGs->displayFieldHint("descricao");?> <?php echo $tNGs->displayFieldError("noticia_imagem", "descricao", $cnt1); ?> </td>
                             </tr>
                           </table>
                           <input type="hidden" name="kt_pk_noticia_imagem_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsnoticia_imagem['kt_pk_noticia_imagem']); ?>" />
                           <input type="hidden" name="codigo_noticia_<?php echo $cnt1; ?>" id="codigo_noticia_<?php echo $cnt1; ?>" value="<?php echo $_GET['noticia']; ?>" />
                           <?php } while ($row_rsnoticia_imagem = mysql_fetch_assoc($rsnoticia_imagem)); ?>
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
