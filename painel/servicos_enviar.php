<?php require_once('../Connections/banco1.php'); ?>
<?php
// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the required classes
require_once('../includes/tfi/TFI.php');
require_once('../includes/tso/TSO.php');
require_once('../includes/nav/NAV.php');

// Make unified connection variable
$conn_banco1 = new KT_connection($banco1, $database_banco1);

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

// Filter
$tfi_listRecordset5 = new TFI_TableFilter($conn_banco1, "tfi_listRecordset5");
$tfi_listRecordset5->addColumn("imagem", "STRING_TYPE", "imagem", "%");
$tfi_listRecordset5->addColumn("descricao", "STRING_TYPE", "descricao", "%");
$tfi_listRecordset5->Execute();

// Sorter
$tso_listRecordset5 = new TSO_TableSorter("Recordset1", "tso_listRecordset5");
$tso_listRecordset5->addColumn("imagem");
$tso_listRecordset5->addColumn("descricao");
$tso_listRecordset5->setDefault("imagem DESC");
$tso_listRecordset5->Execute();

// Navigation
$nav_listRecordset5 = new NAV_Regular("nav_listRecordset5", "Recordset1", "../", $_SERVER['PHP_SELF'], 10);

//NeXTenesio3 Special List Recordset
$maxRows_Recordset1 = $_SESSION['max_rows_nav_listRecordset5'];
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

$colname_Recordset1 = "-1";
if (isset($_GET['servico'])) {
  $colname_Recordset1 = $_GET['servico'];
}
// Defining List Recordset variable
$NXTFilter_Recordset1 = "1=1";
if (isset($_SESSION['filter_tfi_listRecordset5'])) {
  $NXTFilter_Recordset1 = $_SESSION['filter_tfi_listRecordset5'];
}
// Defining List Recordset variable
$NXTSort_Recordset1 = "imagem DESC";
if (isset($_SESSION['sorter_tso_listRecordset5'])) {
  $NXTSort_Recordset1 = $_SESSION['sorter_tso_listRecordset5'];
}
mysql_select_db($database_banco1, $banco1);

$query_Recordset1 = sprintf("SELECT * FROM servico_imagem WHERE codigo_servico = %s AND  {$NXTFilter_Recordset1}  ORDER BY  {$NXTSort_Recordset1} ", GetSQLValueString($colname_Recordset1, "int"));
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $banco1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;
//End NeXTenesio3 Special List Recordset

$colname_Recordset2 = "-1";
if (isset($_GET['servico'])) {
  $colname_Recordset2 = $_GET['servico'];
}
mysql_select_db($database_banco1, $banco1);
$query_Recordset2 = sprintf("SELECT * FROM servico WHERE codigo = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $banco1) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$nav_listRecordset5->checkBoundries();

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
        <script src="../includes/nxt/scripts/list.js" type="text/javascript"></script>
        <script src="../includes/nxt/scripts/list.js.php" type="text/javascript"></script>
        <script type="text/javascript">
$NXT_LIST_SETTINGS = {
  duplicate_buttons: true,
  duplicate_navigation: true,
  row_effects: true,
  show_as_buttons: true,
  record_counter: true
}
        </script>
        <style type="text/css">
  /* Dynamic List row settings */
  .KT_col_imagem {width:140px; overflow:hidden;}
  .KT_col_descricao {width:420px; overflow:hidden;}
        </style>
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

                    <h1>Gerenciamento de Servi&ccedil;o: <?php echo $row_Recordset2['servico']; ?></h1>
                    
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
                   <div class="KT_tng" id="listRecordset5">
                     <h1>
                       <?php
  $nav_listRecordset5->Prepare();
//  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
                     </h1>
                     <div class="KT_tnglist">
                       <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
                         <div class="KT_options"> <a href="<?php echo $nav_listRecordset5->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
                           <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listRecordset5'] == 1) {
?>
                             <?php echo $_SESSION['default_max_rows_nav_listRecordset5']; ?>
                             <?php 
  // else Conditional region1
  } else { ?>
                             <?php echo NXT_getResource("all"); ?>
                             <?php } 
  // endif Conditional region1
?>
                               <?php echo NXT_getResource("records"); ?></a> &nbsp;
                           &nbsp;
                            <?php 
  // Show IF Conditional region2
  if (@$_SESSION['has_filter_tfi_listRecordset5'] == 1) {
?>
                              <a href="<?php echo $tfi_listRecordset5->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                              <?php 
  // else Conditional region2
  } else { ?>
                              <a href="<?php echo $tfi_listRecordset5->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                              <?php } 
  // endif Conditional region2
?>
                         </div>
                         <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                           <thead>
                             <tr class="KT_row_order">
                               <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
                               </th>
                               <th id="imagem" class="KT_sorter KT_col_imagem <?php echo $tso_listRecordset5->getSortIcon('imagem'); ?>"> <a href="<?php echo $tso_listRecordset5->getSortLink('imagem'); ?>">Imagem</a> </th>
                               <th id="descricao" class="KT_sorter KT_col_descricao <?php echo $tso_listRecordset5->getSortIcon('descricao'); ?>"> <a href="<?php echo $tso_listRecordset5->getSortLink('descricao'); ?>">Descrição</a> </th>
                               <th>&nbsp;</th>
                             </tr>
                             <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listRecordset5'] == 1) {
?>
                               <tr class="KT_row_filter">
                                 <td>&nbsp;</td>
                                 <td><input type="text" name="tfi_listRecordset5_imagem" id="tfi_listRecordset5_imagem" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listRecordset5_imagem']); ?>" size="20" maxlength="20" /></td>
                                 <td><input type="text" name="tfi_listRecordset5_descricao" id="tfi_listRecordset5_descricao" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listRecordset5_descricao']); ?>" size="60" maxlength="20" /></td>
                                 <td><input type="submit" name="tfi_listRecordset5" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
                               </tr>
                               <?php } 
  // endif Conditional region3
?>
                           </thead>
                           <tbody>
                             <?php if ($totalRows_Recordset1 == 0) { // Show if recordset empty ?>
                               <tr>
                                 <td colspan="4"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
                               </tr>
                               <?php } // Show if recordset empty ?>
                             <?php if ($totalRows_Recordset1 > 0) { // Show if recordset not empty ?>
                               <?php do { ?>
                                 <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                                   <td><input type="checkbox" name="kt_pk_servico_imagem" class="id_checkbox" value="<?php echo $row_Recordset1['codigo']; ?>" />
                                       <input type="hidden" name="codigo" class="id_field" value="<?php echo $row_Recordset1['codigo']; ?>" />
                                   </td>
                                   <td><div class="KT_col_imagem"><?php echo KT_FormatForList($row_Recordset1['imagem'], 20); ?></div></td>
                                   <td><div class="KT_col_descricao"><?php echo KT_FormatForList($row_Recordset1['descricao'], 60); ?></div></td>
                                   <td><a class="KT_edit_link" href="servicos_enviar2.php?codigo=<?php echo $row_Recordset1['codigo']; ?>&amp;KT_back=1&servico=<? echo $_GET['servico']; ?>"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a> </td>
                                 </tr>
                                 <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
                               <?php } // Show if recordset not empty ?>
                           </tbody>
                         </table>
                         <div class="KT_bottomnav">
                           <div>
                             <?php
            $nav_listRecordset5->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
                           </div>
                         </div>
                         <div class="KT_bottombuttons">
                           <div class="KT_operations"> <a class="KT_edit_op_link" href="#" onclick="nxt_list_edit_link_form(this); return false;"><?php echo NXT_getResource("edit_all"); ?></a> <a class="KT_delete_op_link" href="#" onclick="nxt_list_delete_link_form(this); return false;"><?php echo NXT_getResource("delete_all"); ?></a> </div>
<span>&nbsp;</span>
                           <select name="no_new" id="no_new">
                             <option value="1">1</option>
                             <option value="3">3</option>
                             <option value="6">6</option>
                           </select>
                           <a class="KT_additem_op_link" href="servicos_enviar2.php?KT_back=1&servico=<? echo $_GET['servico']; ?>" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a> </div>
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

mysql_free_result($Recordset2);
?>
