<?
session_start(); //iniciamos a sessao que foi aberta
session_destroy(); //pei!!! destruimos a sessao ;)
session_unset(); //limpamos as variaveis globais das sessoes

echo "<script>alert('Voce saiu do sistema com segurança!');top.location.href='../index.php';</script>"; /*aqui voce pode por alguma coisa falando que ele saiu ou fazer como eu, coloquei redirecionar para uma certa página*/

?>
