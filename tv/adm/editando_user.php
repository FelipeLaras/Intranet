<?php
//chamando banco de dados
require 'conexao.php';
//sessão
session_start();

//data hoje

$data = date('d/m/Y H:i:s');

/* ----------------- EDITANDO FUNCIONÁRIO ----------------- */

if(empty($_POST['senha'])){
    $senha = $_POST['senha_atual'];
}else{
    $senha = md5($_POST['senha']);
}

empty($_POST['id_user']) ? $id_usuario = $_SESSION['id'] : $id_usuario = $_POST['id_user'];

$insert_usuario = "UPDATE tv_login SET tv_usuario = '".$_POST['nome']."', tv_perfil = '".$_POST['perfil']."', tv_nome = '".$_POST['exibicao']."', tv_senha = '".$senha."' WHERE id = ".$id_usuario."";

$result = mysqli_query($conn, $insert_usuario) or die(mysqli_error($conn));


/* ----------------- EDITANDO FUNCIONÁRIO - FILIAIS ----------------- */
    /* 1º iremos validar as novas empresas a serem salva no usuário */

    $contagemEmpresaC = "SELECT COUNT(id) minhasFiliais FROM tv_permissoes_filial WHERE tv_usuario = ".$id_usuario."";
    $resultCountC = mysqli_query($conn, $contagemEmpresaC);
    $countFilialC = mysqli_fetch_assoc($resultCountC);

    $fil = 1; //contador

    $queryUpdateFilial = "SELECT id FROM tv_permissoes_filial WHERE tv_usuario = ".$id_usuario." AND tv_filial NOT IN (";

    while($fil <= $countFilialC['minhasFiliais']){//ira fazer todas as empresas verificando se existe um check-box marcado        

        foreach($_POST['filialC'.$fil.''] as $filial){ 
            $queryUpdateFilial .= $filial.",";
        } 
        $fil++;
    }

    $queryUpdateFilial .= "'') AND tv_concessionaria NOT IN (";

    $com = 1; //contador

    while($com <= $countFilialC['minhasFiliais']){//ira fazer todas as empresas verificando se existe um check-box marcado        
        empty($_POST['concessionariaC'.$com.'']) ? $queryUpdateFilial .= "''," : $queryUpdateFilial .= $_POST['concessionariaC'.$com.''].",";
        $com++;
    }

    $queryUpdateFilial .= "'')";

    echo $queryUpdateFilial;
    echo "<br />";

    $resultUpdateFilial = mysqli_query($conn, $queryUpdateFilial);

    while($linhaFilial = mysqli_fetch_assoc($resultUpdateFilial)){

        $deletarFilial = "DELETE FROM tv_permissoes_filial WHERE id = ".$linhaFilial['id']."";

        echo $deletarFilial;
        echo "<br />";

        $resultDeletar = mysqli_query($conn, $deletarFilial);

    }

    /* 2º iremos validar as novas empresas a serem salva no usuário */
    
    //Quantas Empresa possui no banco de dados?

    $contagemEmpresa = "SELECT COUNT(id) AS count_filial FROM tv_filiais";
    $resultCount = mysqli_query($conn, $contagemEmpresa);
    $countFilial = mysqli_fetch_assoc($resultCount);

    $id = 1; //contador

    while($id <= $countFilial['count_filial']){//ira fazer todas as empresas verificando se existe um check-box marcado        

        if($_POST['concessionaria'.$id.''] != NULL){
            
            foreach($_POST['filial'.$id.''] as $filial){
                $inserindoFilial = "INSERT INTO tv_permissoes_filial (tv_usuario, tv_filial, tv_concessionaria) VALUES 
                                        (".$id_usuario.", ".$filial.", ".$_POST['concessionaria'.$id.''].")"; 
                $resultadoFilial = mysqli_query($conn, $inserindoFilial);
                echo $inserindoFilial."<br />";
                echo "<hr>";
            } 

        }
        $id++;
    }

    
    
/* ----------------- SALVANDO LOG ----------------- */

$inserLog = "INSERT INTO tv_log (tv_usuarioAcao, tv_usuarioAlterado, tv_log, tv_data) VALUES ('".$_SESSION['id']."', '".$id_usuario."', 2, '".$data."')";
$resultadoLog = mysqli_query($conn, $inserLog) or die(mysqli_error($conn));

/* ----------------- FILNALIZANDO ----------------- */

//fechando o banco 
mysqli_close($conn);

//voltando para a tela
if(empty($_POST['id_user'])){
    header('location: dashboard.php?msn=1&pagina=1');//MSN = 1 (EDITADO COM SUCESSO!)
}else{
    header('location: edit_user.php?pagina=4&id='.$id_usuario.'&msn=1');//MSN = 1 (EDITADO COM SUCESSO!)
}

?>