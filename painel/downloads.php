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
$tfi_listdownload1 = new TFI_TableFilter($conn_banco1, "tfi_listdownload1");
$tfi_listdownload1->addColumn("download_categoria.categoria", "STRING_TYPE", "categoria", "%");
$tfi_listdownload1->addColumn("download.titulo", "STRING_TYPE", "titulo", "%");
$tfi_listdownload1->addColumn("download.data", "DATE_TYPE", "data", "=");
$tfi_listdownload1->addColumn("download.descricao", "STRING_TYPE", "descricao", "%");
$tfi_listdownload1->addColumn("download.usuario", "STRING_TYPE", "usuario", "%");
$tfi_listdownload1->Execute();

// Sorter
$tso_listdownload1 = new TSO_TableSorter("rsdownload1", "tso_listdownload1");
$tso_listdownload1->addColumn("download_categoria.categoria");
$tso_listdownload1->addColumn("download.titulo");
$tso_listdownload1->addColumn("download.data");
$tso_listdownload1->addColumn("download.descricao");
$tso_listdownload1->addColumn("download.usuario");
$tso_listdownload1->setDefault("download.data DESC");
$tso_listdownload1->Execute();

// Navigation
$nav_listdownload1 = new NAV_Regular("nav_listdownload1", "rsdownload1", "../", $_SERVER['PHP_SELF'], 50);

mysql_select_db($database_banco1, $banco1);
$query_Recordset1 = "SELECT categoria, categoria FROM download_categoria ORDER BY categoria";
$Recordset1 = mysql_query($query_Recordset1, $banco1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

//NeXTenesio3 Special List Recordset
$maxRows_rsdownload1 = $_SESSION['max_rows_nav_listdownload1'];
$pageNum_rsdownload1 = 0;
if (isset($_GET['pageNum_rsdownload1'])) {
  $pageNum_rsdownload1 = $_GET['pageNum_rsdownload1'];
}
$startRow_rsdownload1 = $pageNum_rsdownload1 * $maxRows_rsdownload1;

// Defining List Recordset variable
$NXTFilter_rsdownload1 = "1=1";
if (isset($_SESSION['filter_tfi_listdownload1'])) {
  $NXTFilter_rsdownload1 = $_SESSION['filter_tfi_listdownload1'];
}
// Defining List Recordset variable
$NXTSort_rsdownload1 = "download.data DESC";
if (isset($_SESSION['sorter_tso_listdownload1'])) {
  $NXTSort_rsdownload1 = $_SESSION['sorter_tso_listdownload1'];
}
mysql_select_db($database_banco1, $banco1);

$query_rsdownload1 = "SELECT download_categoria.categoria AS categoria, download.titulo, download.data, download.descricao, download.usuario, download.codigo FROM download LEFT JOIN download_categoria ON download.categoria = download_categoria.categoria WHERE {$NXTFilter_rsdownload1} ORDER BY {$NXTSort_rsdownload1}";
$query_limit_rsdownload1 = sprintf("%s LIMIT %d, %d", $query_rsdownload1, $startRow_rsdownload1, $maxRows_rsdownload1);
$rsdownload1 = mysql_query($query_limit_rsdownload1, $banco1) or die(mysql_error());
$row_rsdownload1 = mysql_fetch_assoc($rsdownload1);

if (isset($_GET['totalRows_rsdownload1'])) {
  $totalRows_rsdownload1 = $_GET['totalRows_rsdownload1'];
} else {
  $all_rsdownload1 = mysql_query($query_rsdownload1);
  $totalRows_rsdownload1 = mysql_num_rows($all_rsdownload1);
}
$totalPages_rsdownload1 = ceil($totalRows_rsdownload1/$maxRows_rsdownload1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listdownload1->checkBoundries();

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
        
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" /><script src="../includes/common/js/base.js" type="text/javascript"></script><script src="../includes/common/js/utility.js" type="text/javascript"></script><script src="../includes/skins/style.js" type="text/javascript"></script><script src="../includes/nxt/scripts/list.js" type="text/javascript"></script><script src="../includes/nxt/scripts/list.js.php" type="text/javascript"></script><script type="text/javascript">
$NXT_LIST_SETTINGS = {
  duplicate_buttons: true,
  duplicate_navigation: true,
  row_effects: true,
  show_as_buttons: true,
  record_counter: true
}
</script><style type="text/css">
  /* Dynamic List row settings */
  .KT_col_categoria {width:140px; overflow:hidden;}
  .KT_col_titulo {width:140px; overflow:hidden;}
  .KT_col_data {width:140px; overflow:hidden;}
  .KT_col_descricao {width:280px; overflow:hidden;}
  .KT_col_usuario {width:140px; overflow:hidden;}
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

                    <h1>Gerenciamento de Download</h1>
                    
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
                   
<div class="KT_tng" id="listdownload1">
  <h1>
    <?php
  $nav_listdownload1->Prepare();
  // require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listdownload1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
            <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listdownload1'] == 1) {
?>
            <?php echo $_SESSION['default_max_rows_nav_listdownload1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listdownload1'] == 1) {
?>
                            <a href="<?php echo $tfi_listdownload1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                            <?php 
  // else Conditional region2
  } else { ?>
                            <a href="<?php echo $tfi_listdownload1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                            <?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
            </th>
            <th id="categoria" class="KT_sorter KT_col_categoria <?php echo $tso_listdownload1->getSortIcon('download_categoria.categoria'); ?>"> <a href="<?php echo $tso_listdownload1->getSortLink('download_categoria.categoria'); ?>">Categoria</a> </th>
            <th id="titulo" class="KT_sorter KT_col_titulo <?php echo $tso_listdownload1->getSortIcon('download.titulo'); ?>"> <a href="<?php echo $tso_listdownload1->getSortLink('download.titulo'); ?>">Titulo</a> </th>
            <th id="data" class="KT_sorter KT_col_data <?php echo $tso_listdownload1->getSortIcon('download.data'); ?>"> <a href="<?php echo $tso_listdownload1->getSortLink('download.data'); ?>">Data</a> </th>
            <th id="descricao" class="KT_sorter KT_col_descricao <?php echo $tso_listdownload1->getSortIcon('download.descricao'); ?>"> <a href="<?php echo $tso_listdownload1->getSortLink('download.descricao'); ?>">Descrição</a> </th>
            <th id="usuario" class="KT_sorter KT_col_usuario <?php echo $tso_listdownload1->getSortIcon('download.usuario'); ?>"> <a href="<?php echo $tso_listdownload1->getSortLink('download.usuario'); ?>">Usuario</a> </th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listdownload1'] == 1) {
?>
          <tr class="KT_row_filter">
            <td>&nbsp;</td>
            <td><select name="tfi_listdownload1_categoria" id="tfi_listdownload1_categoria">
              <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listdownload1_categoria']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
              <?php
do {  
?>
              <option value="<?php echo $row_Recordset1['categoria']?>"<?php if (!(strcmp($row_Recordset1['categoria'], @$_SESSION['tfi_listdownload1_categoria']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['categoria']?></option>
              <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
            </select>
            </td>
            <td><input type="text" name="tfi_listdownload1_titulo" id="tfi_listdownload1_titulo" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listdownload1_titulo']); ?>" size="20" maxlength="255" /></td>
            <td><input type="text" name="tfi_listdownload1_data" id="tfi_listdownload1_data" value="<?php echo @$_SESSION['tfi_listdownload1_data']; ?>" size="10" maxlength="22" /></td>
            <td><input type="text" name="tfi_listdownload1_descricao" id="tfi_listdownload1_descricao" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listdownload1_descricao']); ?>" size="40" maxlength="100" /></td>
            <td><input type="text" name="tfi_listdownload1_usuario" id="tfi_listdownload1_usuario" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listdownload1_usuario']); ?>" size="20" maxlength="255" /></td>
            <td><input type="submit" name="tfi_listdownload1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
          </tr>
          <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rsdownload1 == 0) { // Show if recordset empty ?>
          <tr>
            <td colspan="7"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
          </tr>
          <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rsdownload1 > 0) { // Show if recordset not empty ?>
          <?php do { ?>
          <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
            <td><input type="checkbox" name="kt_pk_download" class="id_checkbox" value="<?php echo $row_rsdownload1['codigo']; ?>" />
                <input type="hidden" name="codigo" class="id_field" value="<?php echo $row_rsdownload1['codigo']; ?>" />
            </td>
            <td><div class="KT_col_categoria"><?php echo KT_FormatForList($row_rsdownload1['categoria'], 20); ?></div></td>
            <td><div class="KT_col_titulo"><?php echo KT_FormatForList($row_rsdownload1['titulo'], 20); ?></div></td>
            <td><div class="KT_col_data"><?php echo KT_formatDate($row_rsdownload1['data']); ?></div></td>
            <td><div class="KT_col_descricao"><?php echo KT_FormatForList($row_rsdownload1['descricao'], 40); ?></div></td>
            <td><div class="KT_col_usuario"><?php echo KT_FormatForList($row_rsdownload1['usuario'], 20); ?></div></td>
            <td><a class="KT_edit_link" href="downloads2.php?codigo=<?php echo $row_rsdownload1['codigo']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a> </td>
          </tr>
          <?php } while ($row_rsdownload1 = mysql_fetch_assoc($rsdownload1)); ?>
          <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listdownload1->Prepare();
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
        <a class="KT_additem_op_link" href="downloads2.php?KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a> </div>
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
