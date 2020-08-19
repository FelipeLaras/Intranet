<?php
//aplicando para usar varialve em outro arquivo
session_start();
//chamando conexão com o banco
require 'conexao.php';

//transformando MD5

$senha = md5($_POST['senha']);

//criando a query de pesquisa

$query_user = "SELECT 
					id,
					tv_usuario, 
					tv_nome,
					tv_senha,
					tv_perfil,
					tv_deletado as deletar
				FROM 
					tv_login 
				WHERE 
					tv_usuario = '".$_POST['login']."' AND 
					tv_senha = '".$senha."'";
//Aplicando a query
$result = mysqli_query($conn, $query_user);
//salvando em uma array
$row_user = mysqli_fetch_assoc($result);

//query de permissões Filiais
$queryFilial = "SELECT * FROM tv_permissoes_filial WHERE tv_usuario = ".$row_user['id']." ";
$resultFilial = mysqli_query($conn, $queryFilial);

//query de permissões Postagem
$queryPostagem = "SELECT * FROM tv_permissoes_postagem WHERE tv_usuario = ".$row_user['id']." ";
$resultPostagem = mysqli_query($conn, $queryPostagem);
$rowPostagem = mysqli_fetch_assoc($resultPostagem);


//caso o usuário exista mais ele está desativado
if($row_user['deletar'] == 1){
	header('location: index.php?msn=2');	
}else{
	//realizando o redirect
	if ($row_user["deletar"] != NULL) {

	//montando as sessões para ser usados em outras telas
	$_SESSION["id"] = $row_user["id"];
	$_SESSION["usuario"] = $row_user["tv_usuario"];
	$_SESSION["nome"] = $row_user["tv_nome"];
	$_SESSION["perfil"] = $row_user["tv_perfil"];
	$_SESSION["senha"] = $row_user["tv_senha"];	

	//PREMISSÕES FILIAIS
	while ($rowFilial = mysqli_fetch_assoc($resultFilial)){
		$_SESSION["tvFilial"] = $rowFilial["tv_filial"];
	}
	
	//PERMISSÕES POSTAGEM
	$_SESSION["tvPostagem"] = $rowPostagem["tv_postagem"];
	$_SESSION["tvEditarPostagem"] = $rowPostagem["tv_editarPostagem"];
	$_SESSION["tvDesativarPostagem"] = $rowPostagem["tv_desativarPostagem"];
	$_SESSION["tvExcluirPostagem"] = $rowPostagem["tv_excluirPostagem"];


	header('location: dashboard.php?pagina=1');

	}else {
		header('location: index.php?msn=1');
	}
	
}


mysqli_close($conn);

?>