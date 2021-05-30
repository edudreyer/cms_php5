<?php require_once('Connections/banco1.php'); ?>
<?php
	//recuperar o post vindo via javascript
	$ultimoRegistro = (int)$_POST['ultimo'];
	
	//seleciono e executo o sql de seleção primaria
	$strSQL = "SELECT * FROM blog WHERE codigo < {$ultimoRegistro} ORDER BY codigo DESC LIMIT 0,1";
	$stmt = $pdo->prepare($strSQL);
	$stmt->execute();
	//listo os registros primarios
	while($row = $stmt->fetchObject()){
		echo '<br><br>';
		echo '<p lang="'.$row->codigo.'"><h1>'.$row->titulo.'</h1></p>';
		echo '<div class="alert alert-success" role="alert">';
		echo 	'<p lang="'.$row->codigo.'">Por: '.$row->autor.' | Data: '.$row->data_publicacao.'</p>';
		echo '</div>';		
		echo '<p lang="'.$row->codigo.'"><img src="up/'.$row->imagem.'" class="img-responsive"></p>';	
		echo '<p lang="'.$row->codigo.'">'.$row->descricao.'</p>';	
	}
?>