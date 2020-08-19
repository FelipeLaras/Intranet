<?php
//chamando banco
include 'conexao.php';

//query incluindo usuário
$insert_query = "INSERT INTO blog_user (nome, email, exibicao, senha) VALUES ('".$_POST['nome']."', '".$_POST['email']."', '".$_POST['exibicao']."', '".$_POST['senha_atual']."')";
$result_insert = mysqli_query($conn, $insert_query) or die(mysqli_error($conn));

//fehando banco
mysqli_close($conn);

header('location: list_user.php?pagina=4&msn=4');
?>