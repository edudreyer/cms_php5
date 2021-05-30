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
$tfi_listagenda2 = new TFI_TableFilter($conn_banco1, "tfi_listagenda2");
$tfi_listagenda2->addColumn("agenda.evento", "STRING_TYPE", "evento", "%");
$tfi_listagenda2->addColumn("agenda.data", "DATE_TYPE", "data", "=");
$tfi_listagenda2->addColumn("agenda.hora", "DATE_TYPE", "hora", "=");
$tfi_listagenda2->addColumn("agenda.local", "STRING_TYPE", "local", "%");
$tfi_listagenda2->addColumn("agenda.descricao", "STRING_TYPE", "descricao", "%");
$tfi_listagenda2->addColumn("agenda.autor", "STRING_TYPE", "autor", "%");
$tfi_listagenda2->addColumn("agenda.usuario", "STRING_TYPE", "usuario", "%");
$tfi_listagenda2->Execute();

// Sorter
$tso_listagenda2 = new TSO_TableSorter("rsagenda1", "tso_listagenda2");
$tso_listagenda2->addColumn("agenda.evento");
$tso_listagenda2->addColumn("agenda.data");
$tso_listagenda2->addColumn("agenda.hora");
$tso_listagenda2->addColumn("agenda.local");
$tso_listagenda2->addColumn("agenda.descricao");
$tso_listagenda2->addColumn("agenda.autor");
$tso_listagenda2->addColumn("agenda.usuario");
$tso_listagenda2->setDefault("agenda.data DESC");
$tso_listagenda2->Execute();

// Navigation
$nav_listagenda2 = new NAV_Regular("nav_listagenda2", "rsagenda1", "../", $_SERVER['PHP_SELF'], 50);

//NeXTenesio3 Special List Recordset
$maxRows_rsagenda1 = $_SESSION['max_rows_nav_listagenda2'];
$pageNum_rsagenda1 = 0;
if (isset($_GET['pageNum_rsagenda1'])) {
  $pageNum_rsagenda1 = $_GET['pageNum_rsagenda1'];
}
$startRow_rsagenda1 = $pageNum_rsagenda1 * $maxRows_rsagenda1;

// Defining List Recordset variable
$NXTFilter_rsagenda1 = "1=1";
if (isset($_SESSION['filter_tfi_listagenda2'])) {
  $NXTFilter_rsagenda1 = $_SESSION['filter_tfi_listagenda2'];
}
// Defining List Recordset variable
$NXTSort_rsagenda1 = "agenda.data DESC";
if (isset($_SESSION['sorter_tso_listagenda2'])) {
  $NXTSort_rsagenda1 = $_SESSION['sorter_tso_listagenda2'];
}
mysql_select_db($database_banco1, $banco1);

$query_rsagenda1 = "SELECT agenda.evento, agenda.data, agenda.hora, agenda.local, agenda.descricao, agenda.autor, agenda.usuario, agenda.codigo FROM agenda WHERE {$NXTFilter_rsagenda1} ORDER BY {$NXTSort_rsagenda1}";
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

$nav_listagenda2->checkBoundries();

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
  .KT_col_evento {width:140px; overflow:hidden;}
  .KT_col_data {width:70px; overflow:hidden;}
  .KT_col_hora {width:70px; overflow:hidden;}
  .KT_col_local {width:140px; overflow:hidden;}
  .KT_col_descricao {width:210px; overflow:hidden;}
  .KT_col_autor {width:140px; overflow:hidden;}
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

                    <h1>Gerenciamento de Agenda</h1>
                    
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
                   
<div class="KT_tng" id="listagenda2">
        <h1> 
          <?php
  $nav_listagenda2->Prepare();
  // require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
        </h1>
        <div class="KT_tnglist">
          <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
            <div class="KT_options"> <a href="<?php echo $nav_listagenda2->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
              <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listagenda2'] == 1) {
?>
                <?php echo $_SESSION['default_max_rows_nav_listagenda2']; ?>
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
  if (@$_SESSION['has_filter_tfi_listagenda2'] == 1) {
?>
                  <a href="<?php echo $tfi_listagenda2->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                  <?php 
  // else Conditional region2
  } else { ?>
                  <a href="<?php echo $tfi_listagenda2->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                  <?php } 
  // endif Conditional region2
?>
            </div>
            <table cellpadding="2" cellspacing="0" class="KT_tngtable">
              <thead>
                <tr class="KT_row_order">
                  <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
                  </th>
                  <th id="evento" class="KT_sorter KT_col_evento <?php echo $tso_listagenda2->getSortIcon('agenda.evento'); ?>"> <a href="<?php echo $tso_listagenda2->getSortLink('agenda.evento'); ?>">Evento</a> </th>
                  <th id="data" class="KT_sorter KT_col_data <?php echo $tso_listagenda2->getSortIcon('agenda.data'); ?>"> <a href="<?php echo $tso_listagenda2->getSortLink('agenda.data'); ?>">Data</a> </th>
                  <th id="hora" class="KT_sorter KT_col_hora <?php echo $tso_listagenda2->getSortIcon('agenda.hora'); ?>"> <a href="<?php echo $tso_listagenda2->getSortLink('agenda.hora'); ?>">Hora</a> </th>
                  <th id="local" class="KT_sorter KT_col_local <?php echo $tso_listagenda2->getSortIcon('agenda.local'); ?>"> <a href="<?php echo $tso_listagenda2->getSortLink('agenda.local'); ?>">Local</a> </th>
                  <th id="descricao" class="KT_sorter KT_col_descricao <?php echo $tso_listagenda2->getSortIcon('agenda.descricao'); ?>"> <a href="<?php echo $tso_listagenda2->getSortLink('agenda.descricao'); ?>">Descrição</a> </th>
                  <th id="autor" class="KT_sorter KT_col_autor <?php echo $tso_listagenda2->getSortIcon('agenda.autor'); ?>"> <a href="<?php echo $tso_listagenda2->getSortLink('agenda.autor'); ?>">Autor</a> </th>
                  <th id="usuario" class="KT_sorter KT_col_usuario <?php echo $tso_listagenda2->getSortIcon('agenda.usuario'); ?>"> <a href="<?php echo $tso_listagenda2->getSortLink('agenda.usuario'); ?>">Usuario</a> </th>
                  <th>&nbsp;</th>
                </tr>
                <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listagenda2'] == 1) {
?>
                  <tr class="KT_row_filter">
                    <td>&nbsp;</td>
                    <td><input type="text" name="tfi_listagenda2_evento" id="tfi_listagenda2_evento" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listagenda2_evento']); ?>" size="20" maxlength="255" /></td>
                    <td><input type="text" name="tfi_listagenda2_data" id="tfi_listagenda2_data" value="<?php echo @$_SESSION['tfi_listagenda2_data']; ?>" size="10" maxlength="22" /></td>
                    <td><input type="text" name="tfi_listagenda2_hora" id="tfi_listagenda2_hora" value="<?php echo @$_SESSION['tfi_listagenda2_hora']; ?>" size="10" maxlength="22" /></td>
                    <td><input type="text" name="tfi_listagenda2_local" id="tfi_listagenda2_local" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listagenda2_local']); ?>" size="20" maxlength="255" /></td>
                    <td><input type="text" name="tfi_listagenda2_descricao" id="tfi_listagenda2_descricao" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listagenda2_descricao']); ?>" size="30" maxlength="100" /></td>
                    <td><input type="text" name="tfi_listagenda2_autor" id="tfi_listagenda2_autor" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listagenda2_autor']); ?>" size="20" maxlength="255" /></td>
                    <td><input type="text" name="tfi_listagenda2_usuario" id="tfi_listagenda2_usuario" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listagenda2_usuario']); ?>" size="10" maxlength="255" /></td>
                    <td><input type="submit" name="tfi_listagenda2" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
                  </tr>
                  <?php } 
  // endif Conditional region3
?>
              </thead>
              <tbody>
                <?php if ($totalRows_rsagenda1 == 0) { // Show if recordset empty ?>
                  <tr>
                    <td colspan="9"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
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
                      <td><div class="KT_col_usuario"><?php echo KT_FormatForList($row_rsagenda1['usuario'], 10); ?></div></td>
                      <td><a class="KT_edit_link" href="agendas2.php?codigo=<?php echo $row_rsagenda1['codigo']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a> </td>
                    </tr>
                    <?php } while ($row_rsagenda1 = mysql_fetch_assoc($rsagenda1)); ?>
                  <?php } // Show if recordset not empty ?>
              </tbody>
            </table>
            <div class="KT_bottomnav">
              <div>
                <?php
            $nav_listagenda2->Prepare();
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
    </td>
  </tr>
</table>
      
      
                   
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
