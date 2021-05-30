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
$tfi_listagenda1 = new TFI_TableFilter($conn_banco1, "tfi_listagenda1");
$tfi_listagenda1->addColumn("agenda.evento", "STRING_TYPE", "evento", "%");
$tfi_listagenda1->addColumn("agenda.data", "DATE_TYPE", "data", "=");
$tfi_listagenda1->addColumn("agenda.hora", "DATE_TYPE", "hora", "=");
$tfi_listagenda1->addColumn("agenda.local", "STRING_TYPE", "local", "%");
$tfi_listagenda1->addColumn("agenda.descricao", "STRING_TYPE", "descricao", "%");
$tfi_listagenda1->addColumn("agenda.autor", "STRING_TYPE", "autor", "%");
$tfi_listagenda1->Execute();

// Sorter
$tso_listagenda1 = new TSO_TableSorter("rsagenda1", "tso_listagenda1");
$tso_listagenda1->addColumn("agenda.evento");
$tso_listagenda1->addColumn("agenda.data");
$tso_listagenda1->addColumn("agenda.hora");
$tso_listagenda1->addColumn("agenda.local");
$tso_listagenda1->addColumn("agenda.descricao");
$tso_listagenda1->addColumn("agenda.autor");
$tso_listagenda1->setDefault("agenda.data DESC");
$tso_listagenda1->Execute();

// Navigation
$nav_listagenda1 = new NAV_Regular("nav_listagenda1", "rsagenda1", "../", $_SERVER['PHP_SELF'], 30);

//NeXTenesio3 Special List Recordset
$maxRows_rsagenda1 = $_SESSION['max_rows_nav_listagenda1'];
$pageNum_rsagenda1 = 0;
if (isset($_GET['pageNum_rsagenda1'])) {
  $pageNum_rsagenda1 = $_GET['pageNum_rsagenda1'];
}
$startRow_rsagenda1 = $pageNum_rsagenda1 * $maxRows_rsagenda1;

// Defining List Recordset variable
$NXTFilter_rsagenda1 = "1=1";
if (isset($_SESSION['filter_tfi_listagenda1'])) {
  $NXTFilter_rsagenda1 = $_SESSION['filter_tfi_listagenda1'];
}
// Defining List Recordset variable
$NXTSort_rsagenda1 = "agenda.data DESC";
if (isset($_SESSION['sorter_tso_listagenda1'])) {
  $NXTSort_rsagenda1 = $_SESSION['sorter_tso_listagenda1'];
}
mysql_select_db($database_banco1, $banco1);

$query_rsagenda1 = "SELECT agenda.evento, agenda.data, agenda.hora, agenda.local, agenda.descricao, agenda.autor, agenda.codigo FROM agenda WHERE {$NXTFilter_rsagenda1} ORDER BY {$NXTSort_rsagenda1}";
$query_limit_rsagenda1 = sprintf("%s LIMIT %d, %d", $query_rsagenda1, $startRow_rsagenda1, $maxRows_rsagenda1);
$rsagenda1 = mysql_query($query_limit_rsagenda1, $banco1) or die(mysql_error());
$row_rsagenda1 = mysql_fetch_assoc($rsagenda1);

if (isset($_GET['totalRows_rsagenda1'])) {
  $totalRows_rsagenda1 = $_GET['totalRows_rsagenda1'];
} else {
  $all_rsagenda1 = mysql_query($query_rsagenda1);
  $totalRows_rsagenda1 = mysql_num_rows($all_rsagenda1);
}
$totalPages_rsagenda1 = ceil($totalRows_rsagenda1/$maxRows_rsagenda1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listagenda1->checkBoundries();

if (!isset($_SESSION)) {
  session_start();
}
$oodologin = $_SESSION["odologin"]; 
$oodosenha = $_SESSION["odosenha"]; 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Painel Administrativo 2.1</title>
<style type="text/css">
<!--
body {
	background-color: #F0F0F0;
}
body,td,th {
	font-family: Trebuchet MS, Verdana, Arial;
	font-size: 12px;
}
.fundoLog {
	background-color: #F0F0F0;
	font-family: "Trebuchet MS", Verdana, Arial;
	font-size: 15px;
	height: 40px;
	border: 1px dashed #666666;
}
.style1 {font-size: 24px}
-->
</style>
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
  .KT_col_evento {width:140px; overflow:hidden;}
  .KT_col_data {width:70px; overflow:hidden;}
  .KT_col_hora {width:70px; overflow:hidden;}
  .KT_col_local {width:140px; overflow:hidden;}
  .KT_col_descricao {width:210px; overflow:hidden;}
  .KT_col_autor {width:140px; overflow:hidden;}
</style>
</head>

<body>
  <?php include("sessao.php"); ?>
<?php include("menu.php"); ?>
<br />
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;
        <div class="KT_tng" id="listagenda1">
          <h1> Agenda
            <?php
  $nav_listagenda1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
          </h1>
          <div class="KT_tnglist">
            <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
              <div class="KT_options"> <a href="<?php echo $nav_listagenda1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
                    <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listagenda1'] == 1) {
?>
                      <?php echo $_SESSION['default_max_rows_nav_listagenda1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listagenda1'] == 1) {
?>
                        <a href="<?php echo $tfi_listagenda1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                        <?php 
  // else Conditional region2
  } else { ?>
                        <a href="<?php echo $tfi_listagenda1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                        <?php } 
  // endif Conditional region2
?>
              </div>
              <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                <thead>
                  <tr class="KT_row_order">
                    <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
                    </th>
                    <th id="evento" class="KT_sorter KT_col_evento <?php echo $tso_listagenda1->getSortIcon('agenda.evento'); ?>"> <a href="<?php echo $tso_listagenda1->getSortLink('agenda.evento'); ?>">Evento</a> </th>
                    <th id="data" class="KT_sorter KT_col_data <?php echo $tso_listagenda1->getSortIcon('agenda.data'); ?>"> <a href="<?php echo $tso_listagenda1->getSortLink('agenda.data'); ?>">Data</a> </th>
                    <th id="hora" class="KT_sorter KT_col_hora <?php echo $tso_listagenda1->getSortIcon('agenda.hora'); ?>"> <a href="<?php echo $tso_listagenda1->getSortLink('agenda.hora'); ?>">Hora</a> </th>
                    <th id="local" class="KT_sorter KT_col_local <?php echo $tso_listagenda1->getSortIcon('agenda.local'); ?>"> <a href="<?php echo $tso_listagenda1->getSortLink('agenda.local'); ?>">Local</a> </th>
                    <th id="descricao" class="KT_sorter KT_col_descricao <?php echo $tso_listagenda1->getSortIcon('agenda.descricao'); ?>"> <a href="<?php echo $tso_listagenda1->getSortLink('agenda.descricao'); ?>">Descrição</a> </th>
                    <th id="autor" class="KT_sorter KT_col_autor <?php echo $tso_listagenda1->getSortIcon('agenda.autor'); ?>"> <a href="<?php echo $tso_listagenda1->getSortLink('agenda.autor'); ?>">Autor</a> </th>
                    <th>&nbsp;</th>
                  </tr>
                  <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listagenda1'] == 1) {
?>
                    <tr class="KT_row_filter">
                      <td>&nbsp;</td>
                      <td><input type="text" name="tfi_listagenda1_evento" id="tfi_listagenda1_evento" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listagenda1_evento']); ?>" size="20" maxlength="255" /></td>
                      <td><input type="text" name="tfi_listagenda1_data" id="tfi_listagenda1_data" value="<?php echo @$_SESSION['tfi_listagenda1_data']; ?>" size="10" maxlength="22" /></td>
                      <td><input type="text" name="tfi_listagenda1_hora" id="tfi_listagenda1_hora" value="<?php echo @$_SESSION['tfi_listagenda1_hora']; ?>" size="10" maxlength="22" /></td>
                      <td><input type="text" name="tfi_listagenda1_local" id="tfi_listagenda1_local" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listagenda1_local']); ?>" size="20" maxlength="255" /></td>
                      <td><input type="text" name="tfi_listagenda1_descricao" id="tfi_listagenda1_descricao" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listagenda1_descricao']); ?>" size="30" maxlength="100" /></td>
                      <td><input type="text" name="tfi_listagenda1_autor" id="tfi_listagenda1_autor" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listagenda1_autor']); ?>" size="20" maxlength="255" /></td>
                      <td><input type="submit" name="tfi_listagenda1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
                    </tr>
                    <?php } 
  // endif Conditional region3
?>
                </thead>
                <tbody>
                  <?php if ($totalRows_rsagenda1 == 0) { // Show if recordset empty ?>
                    <tr>
                      <td colspan="8"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
                    </tr>
                    <?php } // Show if recordset empty ?>
                  <?php if ($totalRows_rsagenda1 > 0) { // Show if recordset not empty ?>
                    <?php do { ?>
                      <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                        <td><input type="checkbox" name="kt_pk_agenda" class="id_checkbox" value="<?php echo $row_rsagenda1['codigo']; ?>" />
                            <input type="hidden" name="codigo" class="id_field" value="<?php echo $row_rsagenda1['codigo']; ?>" />
                        </td>
                        <td><div class="KT_col_evento"><?php echo KT_FormatForList($row_rsagenda1['evento'], 20); ?></div></td>
                        <td><div class="KT_col_data"><?php echo KT_formatDate($row_rsagenda1['data']); ?></div></td>
                        <td><div class="KT_col_hora"><?php echo KT_formatDate($row_rsagenda1['hora']); ?></div></td>
                        <td><div class="KT_col_local"><?php echo KT_FormatForList($row_rsagenda1['local'], 20); ?></div></td>
                        <td><div class="KT_col_descricao"><?php echo KT_FormatForList($row_rsagenda1['descricao'], 30); ?></div></td>
                        <td><div class="KT_col_autor"><?php echo KT_FormatForList($row_rsagenda1['autor'], 20); ?></div></td>
                        <td><a class="KT_edit_link" href="agendas2.php?codigo=<?php echo $row_rsagenda1['codigo']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a> </td>
                      </tr>
                      <?php } while ($row_rsagenda1 = mysql_fetch_assoc($rsagenda1)); ?>
                    <?php } // Show if recordset not empty ?>
                </tbody>
              </table>
              <div class="KT_bottomnav">
                <div>
                  <?php
            $nav_listagenda1->Prepare();
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
                <a class="KT_additem_op_link" href="agendas2.php?KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a> </div>
            </form>
          </div>
          <br class="clearfixplain" />
        </div>
      <p>&nbsp;</p></td>
  </tr>
</table>
<br />
<?php include("rodape.php"); ?></body>
</html>
<?php
mysql_free_result($rsagenda1);
?>
