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
$query_rsBanner = "SELECT * FROM banner ORDER BY codigo ASC LIMIT 1,10";
$rsBanner = mysql_query($query_rsBanner, $banco1) or die(mysql_error());
$row_rsBanner = mysql_fetch_assoc($rsBanner);
$totalRows_rsBanner = mysql_num_rows($rsBanner);

mysql_select_db($database_banco1, $banco1);
$query_rsBanner2 = "SELECT * FROM banner ORDER BY codigo ASC LIMIT 1";
$rsBanner2 = mysql_query($query_rsBanner2, $banco1) or die(mysql_error());
$row_rsBanner2 = mysql_fetch_assoc($rsBanner2);
$totalRows_rsBanner2 = mysql_num_rows($rsBanner2);


?> 



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

            
          <!-- Carousel
    			================================================== --> 
            	<div id="myCarousel" class="carousel slide" data-ride="carousel">
                  <!-- Indicators -->
                  <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                  </ol>
                  <div class="carousel-inner">
                   
                    <div class="item active">
                      <img src="up/<?php echo $row_rsBanner2['arquivo']; ?>" alt="First slide">
                      <div class="container">
                        <div class="carousel-caption">
                          <h1><?php echo $row_rsBanner2['nome']; ?></h1>
                          <p><?php echo $row_rsBanner2['descricao']; ?></p>
                          <p><a class="btn btn-lg btn-danger" href="<?php echo $row_rsBanner2['url_destino']; ?>" role="button"><?php echo $row_rsBanner2['botao']; ?></a></p>
                        </div>
                      </div>
                    </div>
                    
                    
                    <?php do { ?>
                    <div class="item">
                      <img src="up/<?php echo $row_rsBanner['arquivo']; ?>" alt="Second slide">
                      <div class="container">
                        <div class="carousel-caption">
                          <h1><?php echo $row_rsBanner['nome']; ?></h1>
                          <p><?php echo $row_rsBanner['descricao']; ?>.</p>
                          <p><a class="btn btn-lg btn-danger" href="<?php echo $row_rsBanner['url_destino']; ?>" role="button"><?php echo $row_rsBanner['botao']; ?></a></p>
                        </div>
                      </div>
                    </div>
                      <?php } while ($row_rsBanner = mysql_fetch_assoc($rsBanner)); ?>
                      
                </div>
                  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
                  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
                </div><!-- /.carousel -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
            
                        
             <?php
mysql_free_result($rsBanner);

mysql_free_result($rsBanner2);
?>