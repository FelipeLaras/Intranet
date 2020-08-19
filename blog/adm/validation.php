<?php
//aplicando para usar varialve em outro arquivo
session_start();
//chamando conexão com o banco
require 'conexao.php';

//criando a query de pesquisa

$query_user = "SELECT 
					id_user,
					nome, 
					exibicao,
					email,
					senha,
					deletar
				FROM 
					blog.blog_user 
				WHERE 
					nome like '%".$_POST['login']."%' AND 
					senha like '%".$_POST['senha']."%'";

//Aplicando a query
$result = mysqli_query($conn, $query_user);
//salvando em uma array
$row_user = mysqli_fetch_assoc($result);
//caso o usuário exista mais ele está desativado
if($row_user['deletar'] == 1){
	header('location: index.php?msn=2');	
}else{
	//realizando o redirect
	if ($row_user["deletar"] != NULL) {

	//montando as sessões para ser usados em outras telas
	$_SESSION["id"] = $row_user["id_user"];
	$_SESSION["nome"] = $row_user["nome"];
	$_SESSION["exibicao"] = $row_user["exibicao"];
	$_SESSION["email"] = $row_user["email"];
	$_SESSION["senha"] = $row_user["senha"];	

	header('location: dashboard.php?pagina=1');

	}else {
		header('location: index.php?msn=1');
	}
	
}


mysqli_close($conn);

?>