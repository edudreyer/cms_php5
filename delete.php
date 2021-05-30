<?php require_once('Connections/banco1.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<?php

// DADOS DO BANCO
echo 'DADOS DO BANCO<BR>';
echo 'Endereço do servidor: ';
echo $hostname_banco1;
echo '<br>';
echo 'Nome do banco dedados: ';
echo $database_banco1;
echo '<br>';
echo 'Usuario: ';
echo $username_banco1;
echo '<br>';
echo 'Senha: ';
echo $password_banco1;
echo '<br><br>';


echo "PHP_SELF : " . $_SERVER['PHP_SELF'] . "<br />"; 
echo "GATEWAY_INTERFACE : " . $_SERVER['GATEWAY_INTERFACE'] . "<br />"; 
echo "SERVER_ADDR : " . $_SERVER['SERVER_ADDR'] . "<br />"; 
echo "SERVER_NAME : " . $_SERVER['SERVER_NAME'] . "<br />"; 
echo "SERVER_SOFTWARE : " . $_SERVER['SERVER_SOFTWARE'] . "<br />"; 
echo "SERVER_PROTOCOL : " . $_SERVER['SERVER_PROTOCOL'] . "<br />"; 
echo "REQUEST_METHOD : " . $_SERVER['REQUEST_METHOD'] . "<br />"; 
echo "REQUEST_TIME : " . $_SERVER['REQUEST_TIME'] . "<br />"; 
echo "REQUEST_TIME_FLOAT : " . $_SERVER['REQUEST_TIME_FLOAT'] . "<br />"; 
echo "QUERY_STRING : " . $_SERVER['QUERY_STRING'] . "<br />"; 
echo "DOCUMENT_ROOT : " . $_SERVER['DOCUMENT_ROOT'] . "<br />"; 
echo "HTTP_ACCEPT : " . $_SERVER['HTTP_ACCEPT'] . "<br />"; 
echo "HTTP_ACCEPT_CHARSET : " . $_SERVER['HTTP_ACCEPT_CHARSET'] . "<br />"; 
echo "HTTP_ACCEPT_ENCODING : " . $_SERVER['HTTP_ACCEPT_ENCODING'] . "<br />"; 
echo "HTTP_ACCEPT_LANGUAGE : " . $_SERVER['HTTP_ACCEPT_LANGUAGE'] . "<br />"; 
echo "HTTP_CONNECTION : " . $_SERVER['HTTP_CONNECTION'] . "<br />"; 
echo "HTTP_HOST : " . $_SERVER['HTTP_HOST'] . "<br />"; 
echo "HTTP_REFERER : " . $_SERVER['HTTP_REFERER'] . "<br />"; 
echo "HTTP_USER_AGENT : " . $_SERVER['HTTP_USER_AGENT'] . "<br />"; 
echo "HTTPS : " . $_SERVER['HTTPS'] . "<br />"; 
echo "REMOTE_ADDR : " . $_SERVER['REMOTE_ADDR'] . "<br />"; 
echo "REMOTE_HOST : " . $_SERVER['REMOTE_HOST'] . "<br />"; 
echo "REMOTE_PORT : " . $_SERVER['REMOTE_PORT'] . "<br />"; 
echo "REMOTE_USER : " . $_SERVER['REMOTE_USER'] . "<br />"; 
echo "REDIRECT_REMOTE_USER : " . $_SERVER['REDIRECT_REMOTE_USER'] . "<br />"; 
echo "SCRIPT_FILENAME : " . $_SERVER['SCRIPT_FILENAME'] . "<br />"; 
echo "SERVER_ADMIN : " . $_SERVER['SERVER_ADMIN'] . "<br />"; 
echo "SERVER_PORT : " . $_SERVER['SERVER_PORT'] . "<br />"; 
echo "SERVER_SIGNATURE : " . $_SERVER['SERVER_SIGNATURE'] . "<br />"; 
echo "PATH_TRANSLATED : " . $_SERVER['PATH_TRANSLATED'] . "<br />"; 
echo "SCRIPT_NAME : " . $_SERVER['SCRIPT_NAME'] . "<br />"; 
echo "REQUEST_URI : " . $_SERVER['REQUEST_URI'] . "<br />"; 
echo "PHP_AUTH_DIGEST : " . $_SERVER['PHP_AUTH_DIGEST'] . "<br />"; 
echo "PHP_AUTH_USER : " . $_SERVER['PHP_AUTH_USER'] . "<br />"; 
echo "PHP_AUTH_PW : " . $_SERVER['PHP_AUTH_PW'] . "<br />"; 
echo "AUTH_TYPE : " . $_SERVER['AUTH_TYPE'] . "<br />"; 
echo "PATH_INFO : " . $_SERVER['PATH_INFO'] . "<br />"; 
echo "ORIG_PATH_INFO : " . $_SERVER['ORIG_PATH_INFO'] . "<br />"; 

// FUNÇÃO PARA APAGAR ARQUIVO
// echo unlink("menu.php"); 

// Função para apagar diretório
    function apagarDir($dir) 
    {
        //Abrindo o diretorio
        $abreDir = opendir($dir);
        //Lendo todos os arquivos e pastas dentro do diretorio
        while (false !== ($file = readdir($abreDir))) 
        {
            if ($file==".." || $file ==".") 
                continue;
            /*
                Verificando se o item é uma pasta
                Se for ele chama a função novamente para 
                apagar os arquivos e pastas
                Se não for pasta a função apaga o arquivo
            */
            if (is_dir($cFile=($dir."/".$file)))
                apagarDir($cFile);
            else if (is_file($cFile))
                @unlink($cFile); //Apagando arquivo
        }
        //Fechando o diretorio
        closedir($abreDir);
        //Deletando a pasta
        rmdir($dir);
    }
	

//CHAMAR FUNÇÃO PARA APAGAR PASTA.	
//  apagarDir('css');	

?>


<body>
</body>
</html>
