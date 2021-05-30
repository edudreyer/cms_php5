
<div align="center">
<?

$endereco = $_SERVER ['REQUEST_URI'];
	
?>
<?php
        $quant_pg = ceil($quantreg/$numreg);
        $quant_pg++;
        
        // Verifica se esta na primeira página, se nao estiver ele libera o link para anterior
        if ( $_GET['pg'] > 0) { 
                echo "<a href=".$endereco."&pg=".($_GET['pg']-1) ." class='btn btn-default'><b>Anterior&nbsp;&nbsp;</b></a>";
        } else { 
                echo "<a href='#' class='btn btn-default'>Anterior</a>";
        }
        
        // Faz aparecer os numeros das página entre o ANTERIOR e PROXIMO
        for($i_pg=1;$i_pg<$quant_pg;$i_pg++) { 
                // Verifica se a página que o navegante esta e retira o link do número para identificar visualmente
                if ($_GET['pg'] == ($i_pg-1)) { 
                        echo "&nbsp;<span class='btn btn-default'>$i_pg</span>&nbsp;";
                } else {
                        $i_pg2 = $i_pg-1;
                        echo "&nbsp;<a href=".$endereco."&pg=$i_pg2 class='btn btn-default'><b>$i_pg</b></a>&nbsp;";
                }
        }
        
        // Verifica se esta na ultima página, se nao estiver ele libera o link para próxima
        if (($_GET['pg']+2) < $quant_pg) { 
                echo "<a href=".$endereco."&pg=".($_GET['pg']+1)." class='btn btn-default'><b>&nbsp;&nbsp;proximo &raquo;</b></a>";
        } else { 
                echo "<a href='#' class='btn btn-default'>Proximo</a>";
        }
?>

</div>