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
$tfi_listbanner1 = new TFI_TableFilter($conn_banco1, "tfi_listbanner1");
$tfi_listbanner1->addColumn("banner.nome", "STRING_TYPE", "nome", "%");
$tfi_listbanner1->addColumn("banner.local", "STRING_TYPE", "local", "%");
$tfi_listbanner1->addColumn("banner.tipo", "STRING_TYPE", "tipo", "%");
$tfi_listbanner1->addColumn("banner.arquivo", "STRING_TYPE", "arquivo", "%");
$tfi_listbanner1->addColumn("banner.url_destino", "STRING_TYPE", "url_destino", "%");
$tfi_listbanner1->addColumn("banner.data_inicial", "DATE_TYPE", "data_inicial", "=");
$tfi_listbanner1->addColumn("banner.data_final", "DATE_TYPE", "data_final", "=");
$tfi_listbanner1->addColumn("banner.usuario", "STRING_TYPE", "usuario", "%");
$tfi_listbanner1->Execute();

// Sorter
$tso_listbanner1 = new TSO_TableSorter("rsbanner1", "tso_listbanner1");
$tso_listbanner1->addColumn("banner.nome");
$tso_listbanner1->addColumn("banner.local");
$tso_listbanner1->addColumn("banner.tipo");
$tso_listbanner1->addColumn("banner.arquivo");
$tso_listbanner1->addColumn("banner.url_destino");
$tso_listbanner1->addColumn("banner.data_inicial");
$tso_listbanner1->addColumn("banner.data_final");
$tso_listbanner1->addColumn("banner.usuario");
$tso_listbanner1->setDefault("banner.data_final DESC");
$tso_listbanner1->Execute();

// Navigation
$nav_listbanner1 = new NAV_Regular("nav_listbanner1", "rsbanner1", "../", $_SERVER['PHP_SELF'], 50);

//NeXTenesio3 Special List Recordset
$maxRows_rsbanner1 = $_SESSION['max_rows_nav_listbanner1'];
$pageNum_rsbanner1 = 0;
if (isset($_GET['pageNum_rsbanner1'])) {
  $pageNum_rsbanner1 = $_GET['pageNum_rsbanner1'];
}
$startRow_rsbanner1 = $pageNum_rsbanner1 * $maxRows_rsbanner1;

// Defining List Recordset variable
$NXTFilter_rsbanner1 = "1=1";
if (isset($_SESSION['filter_tfi_listbanner1'])) {
  $NXTFilter_rsbanner1 = $_SESSION['filter_tfi_listbanner1'];
}
// Defining List Recordset variable
$NXTSort_rsbanner1 = "banner.data_final DESC";
if (isset($_SESSION['sorter_tso_listbanner1'])) {
  $NXTSort_rsbanner1 = $_SESSION['sorter_tso_listbanner1'];
}
mysql_select_db($database_banco1, $banco1);

$query_rsbanner1 = "SELECT banner.nome, banner.local, banner.tipo, banner.arquivo, banner.url_destino, banner.data_inicial, banner.data_final, banner.usuario, banner.codigo FROM banner WHERE {$NXTFilter_rsbanner1} ORDER BY {$NXTSort_rsbanner1}";
$query_limit_rsbanner1 = sprintf("%s LIMIT %d, %d", $query_rsbanner1, $startRow_rsbanner1, $maxRows_rsbanner1);
$rsbanner1 = mysql_query($query_limit_rsbanner1, $banco1) or die(mysql_error());
$totalRows_rsbanner1 = mysql_num_rows($rsbanner1);
$row_rsbanner1 = mysql_fetch_assoc($rsbanner1);

if (isset($_GET['totalRows_rsbanner1'])) {
  $totalRows_rsbanner1 = $_GET['totalRows_rsbanner1'];
} else {
  $all_rsbanner1 = mysql_query($query_rsbanner1);
  $totalRows_rsbanner1 = mysql_num_rows($all_rsbanner1);
}
$totalPages_rsbanner1 = ceil($totalRows_rsbanner1/$maxRows_rsbanner1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listbanner1->checkBoundries();

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
  .KT_col_nome {width:140px; overflow:hidden;}
  .KT_col_local {width:140px; overflow:hidden;}
  .KT_col_tipo {width:70px; overflow:hidden;}
  .KT_col_arquivo {width:140px; overflow:hidden;}
  .KT_col_url_destino {width:140px; overflow:hidden;}
  .KT_col_data_inicial {width:70px; overflow:hidden;}
  .KT_col_data_final {width:70px; overflow:hidden;}
  .KT_col_usuario {width:70px; overflow:hidden;}
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

                    <h1>Gerenciamento de Banners</h1>
                    
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
                    
                   
                   <? // INICIO DE PROGRAMAÇÃO ?>
                   
<br>
<br>
        
 <div class="KT_tng" id="listbanner1">
        <h1> 
          <?php
//  $nav_listbanner1->Prepare();
//  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
        </h1>
        <div class="KT_tnglist">
          <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
            <div class="KT_options"> <a href="<?php echo $nav_listbanner1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
                  <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listbanner1'] == 1) {
?>
                    <?php echo $_SESSION['default_max_rows_nav_listbanner1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listbanner1'] == 1) {
?>
                  <a href="<?php echo $tfi_listbanner1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                  <?php 
  // else Conditional region2
  } else { ?>
                  <a href="<?php echo $tfi_listbanner1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                  <?php } 
  // endif Conditional region2
?>
            </div>
            <table cellpadding="2" cellspacing="0" class="table">
              <thead>
                <tr>
                  <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>                  </th>
                  <th id="nome" class="KT_sorter KT_col_nome <?php echo $tso_listbanner1->getSortIcon('banner.nome'); ?>"> <a href="<?php echo $tso_listbanner1->getSortLink('banner.nome'); ?>">Banner</a> </th>
                  <th id="local" class="KT_sorter KT_col_local <?php echo $tso_listbanner1->getSortIcon('banner.local'); ?>"> <a href="<?php echo $tso_listbanner1->getSortLink('banner.local'); ?>">Local</a> </th>
                  <th id="tipo" class="KT_sorter KT_col_tipo <?php echo $tso_listbanner1->getSortIcon('banner.tipo'); ?>"> <a href="<?php echo $tso_listbanner1->getSortLink('banner.tipo'); ?>">Tipo</a> </th>
                  <th id="arquivo" class="KT_sorter KT_col_arquivo <?php echo $tso_listbanner1->getSortIcon('banner.arquivo'); ?>"> <a href="<?php echo $tso_listbanner1->getSortLink('banner.arquivo'); ?>">Arquivo</a> </th>
                  <th id="url_destino" class="KT_sorter KT_col_url_destino <?php echo $tso_listbanner1->getSortIcon('banner.url_destino'); ?>"> <a href="<?php echo $tso_listbanner1->getSortLink('banner.url_destino'); ?>">Url</a> </th>
                  <th id="data_inicial" class="KT_sorter KT_col_data_inicial <?php echo $tso_listbanner1->getSortIcon('banner.data_inicial'); ?>"> <a href="<?php echo $tso_listbanner1->getSortLink('banner.data_inicial'); ?>">Data inicial</a> </th>
                  <th id="data_final" class="KT_sorter KT_col_data_final <?php echo $tso_listbanner1->getSortIcon('banner.data_final'); ?>"> <a href="<?php echo $tso_listbanner1->getSortLink('banner.data_final'); ?>">Data final</a> </th>
                  <th id="usuario" class="KT_sorter KT_col_usuario <?php echo $tso_listbanner1->getSortIcon('banner.usuario'); ?>"> <a href="<?php echo $tso_listbanner1->getSortLink('banner.usuario'); ?>">Usuario</a> </th>
                  <th>&nbsp;</th>
                </tr>
                <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listbanner1'] == 1) {
?>
                  <tr>
                    <td>&nbsp;</td>
                    <td><input type="text" name="tfi_listbanner1_nome" id="tfi_listbanner1_nome" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listbanner1_nome']); ?>" size="20" maxlength="255" /></td>
                    <td><input type="text" name="tfi_listbanner1_local" id="tfi_listbanner1_local" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listbanner1_local']); ?>" size="20" maxlength="255" /></td>
                    <td><input type="text" name="tfi_listbanner1_tipo" id="tfi_listbanner1_tipo" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listbanner1_tipo']); ?>" size="10" maxlength="255" /></td>
                    <td><input type="text" name="tfi_listbanner1_arquivo" id="tfi_listbanner1_arquivo" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listbanner1_arquivo']); ?>" size="20" maxlength="255" /></td>
                    <td><input type="text" name="tfi_listbanner1_url_destino" id="tfi_listbanner1_url_destino" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listbanner1_url_destino']); ?>" size="20" maxlength="255" /></td>
                    <td><input type="text" name="tfi_listbanner1_data_inicial" id="tfi_listbanner1_data_inicial" value="<?php echo @$_SESSION['tfi_listbanner1_data_inicial']; ?>" size="10" maxlength="22" /></td>
                    <td><input type="text" name="tfi_listbanner1_data_final" id="tfi_listbanner1_data_final" value="<?php echo @$_SESSION['tfi_listbanner1_data_final']; ?>" size="10" maxlength="22" /></td>
                    <td><input type="text" name="tfi_listbanner1_usuario" id="tfi_listbanner1_usuario" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listbanner1_usuario']); ?>" size="10" maxlength="255" /></td>
                    <td><input type="submit" name="tfi_listbanner1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
                  </tr>
                  <?php } 
  // endif Conditional region3
?>
              </thead>
              <tbody>
                <?php if ($totalRows_rsbanner1 == 0) { // Show if recordset empty ?>
                  <tr>
                    <td colspan="10"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
                  </tr>
                  <?php } // Show if recordset empty ?>
                <?php if ($totalRows_rsbanner1 > 0) { // Show if recordset not empty ?>
                  <?php do { ?>
                    <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                      <td><input type="checkbox" name="kt_pk_banner" class="id_checkbox" value="<?php echo $row_rsbanner1['codigo']; ?>" />
                          <input type="hidden" name="codigo" class="id_field" value="<?php echo $row_rsbanner1['codigo']; ?>" />                      </td>
                      <td><div class="KT_col_nome"><?php echo KT_FormatForList($row_rsbanner1['nome'], 20); ?></div></td>
                      <td><div class="KT_col_local"><?php echo KT_FormatForList($row_rsbanner1['local'], 20); ?></div></td>
                      <td><div class="KT_col_tipo"><?php echo KT_FormatForList($row_rsbanner1['tipo'], 10); ?></div></td>
                      <td>
                      
                      <img src="../up/<?php echo $row_rsbanner1['arquivo']; ?>" class="img-responsive">
                      
                      
                      </td>
                      <td><div class="KT_col_url_destino"><?php echo KT_FormatForList($row_rsbanner1['url_destino'], 20); ?></div></td>
                      <td><div class="KT_col_data_inicial"><?php echo KT_formatDate($row_rsbanner1['data_inicial']); ?></div></td>
                      <td><div class="KT_col_data_final"><?php echo KT_formatDate($row_rsbanner1['data_final']); ?></div></td>
                      <td><div class="KT_col_usuario"><?php echo KT_FormatForList($row_rsbanner1['usuario'], 10); ?></div></td>
                      <td><a class="KT_edit_link" href="banners2.php?codigo=<?php echo $row_rsbanner1['codigo']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a> </td>
                    </tr>
                    <?php } while ($row_rsbanner1 = mysql_fetch_assoc($rsbanner1)); ?>
                  <?php } // Show if recordset not empty ?>
              </tbody>
            </table>
            <div class="KT_bottomnav">
              <div>
                <?php
            $nav_listbanner1->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
              </div>
            </div>
            <div class="KT_bottombuttons">
              <div class="KT_operations"> <a class="KT_edit_op_link" href="#" onClick="nxt_list_edit_link_form(this); return false;"><?php echo NXT_getResource("edit_all"); ?></a> <a class="KT_delete_op_link" href="#" onClick="nxt_list_delete_link_form(this); return false;"><?php echo NXT_getResource("delete_all"); ?></a> </div>
              <span>&nbsp;</span>
              <select name="no_new" id="no_new">
                <option value="1">1</option>
                <option value="3">3</option>
                <option value="6">6</option>
              </select>
              <a class="KT_additem_op_link" href="banners2.php?KT_back=1" onClick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a> </div>
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
