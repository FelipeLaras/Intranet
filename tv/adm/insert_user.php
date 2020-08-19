<?php
//sessão
session_start();

//chamando banco
include 'conexao.php';

//transformando a senha em MD5
$senha = md5($_POST['senha_atual']);

//data hoje
$data = date('d/m/Y H:i:s');

/*----------------------- VERIFICANDO SE JÁ NÃO EXISTE O USUÁRIO -----------------------*/

$queryUsuario = "SELECT id FROM tv_login WHERE tv_usuario = '".$_POST['nome']."'";
$resultUsuario = mysqli_query($conn, $queryUsuario);

if($usuario = mysqli_fetch_assoc($resultUsuario)){

    header('location: list_user.php?pagina=4&msn=5');// usuário já existe
    exit;

}else{

    //query incluindo usuário
    $insert_query = "INSERT INTO tv_login (tv_usuario, tv_perfil, tv_nome, tv_senha) VALUES ('".$_POST['nome']."', '".$_POST['perfil']."', '".$_POST['exibicao']."','".$senha."')";
    $result_insert = mysqli_query($conn, $insert_query);

    //pegando o ID usuário acima para adicionar as filiais
    $queryUsuarioAdd = "SELECT id FROM tv_login WHERE tv_usuario = '".$_POST['nome']."'";  
    $resultUsuarioAdd = mysqli_query($conn, $queryUsuarioAdd);
    $usuarioAdd = mysqli_fetch_assoc($resultUsuarioAdd);

    //Quantas Empresa possui ?

    $contagemEmpresa = "SELECT COUNT(id) AS count_filial FROM tv_filiais";
    $resultCount = mysqli_query($conn, $contagemEmpresa);
    $countFilial = mysqli_fetch_assoc($resultCount);

    $id = 1; //contador

    while($id <= $countFilial['count_filial']){//ira fazer todas as empresas verificando se existe um check-box marcado

        if($_POST['concessionaria'.$id.''] != NULL){
            
            foreach($_POST['filial'.$id.''] as $filial){
                $inserindoFilial = "INSERT INTO tv_permissoes_filial (tv_usuario, tv_filial, tv_concessionaria) VALUES 
                                        (".$usuarioAdd['id'].", ".$filial.", ".$_POST['concessionaria'.$id.''].")"; 
                $resultadoFilial = mysqli_query($conn, $inserindoFilial);
                echo $inserindoFilial."<br />";
                echo "<hr>";
            } 

        }
        $id++;
    }

    /* ----------------- SALVANDO LOG ----------------- */

    $inserLog = "INSERT INTO tv_log (tv_usuarioAcao, tv_usuarioAlterado, tv_log, tv_data) VALUES ('".$_SESSION['id']."', '".$usuarioAdd['id']."', 1, '".$data."')";
    $resultadoLog = mysqli_query($conn, $inserLog);  

    header('location: list_user.php?pagina=4&msn=4');

}//fim do ELSE


/* ----------------- FINALIZANDO ----------------- */
mysqli_close($conn);
?>