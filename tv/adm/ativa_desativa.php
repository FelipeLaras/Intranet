<?php
//sessão
session_start();

//banco de dados
require 'conexao.php';

//data hoje
$data = date('d/m/Y H:i:s');

/* ----------------- ATIVANDO OU DESATIVANDO USUÁRIO OU POSTAGEM ----------------- */

if($_GET['ativa'] == 'sim'){//ativando

    if(empty($_GET['id'])){
        //postagem
        $ativa = "UPDATE tv_postagem SET tv_desativar = 0 WHERE id = ".$_GET['id_post']."";
        $result = mysqli_query($conn, $ativa) or die(mysqli_error($conn));

        /* ----------------- SALVANDO LOG ----------------- */        
        //ATIVANDO POSTAGEM
        $inserLog = "INSERT INTO tv_log (tv_usuarioAcao, tv_postagemAlterada, tv_log, tv_data) VALUES ('".$_SESSION['id']."', '".$_GET['id_post']."', 8, '".$data."')";
        $resultadoLog = mysqli_query($conn, $inserLog) or die(mysqli_error($conn));

    }else{
        //usuário
        $ativa = "UPDATE tv_login SET tv_deletado = 0 WHERE id = ".$_GET['id']."";
        $result = mysqli_query($conn, $ativa) or die(mysqli_error($conn));
        
        /* ----------------- SALVANDO LOG ----------------- */
        //ATIVANDO USUÁRIO
        $inserLog = "INSERT INTO tv_log (tv_usuarioAcao, tv_usuarioAlterado, tv_log, tv_data) VALUES ('".$_SESSION['id']."', '".$_GET['id']."', 4, '".$data."')";
        $resultadoLog = mysqli_query($conn, $inserLog) or die(mysqli_error($conn));    
    }  

}else{//desativa

    if(empty($_GET['id'])){
        //postagem
        $desativa = "UPDATE tv_postagem SET tv_desativar = 1 WHERE id = ".$_GET['id_post']."";
        $result = mysqli_query($conn, $desativa) or die(mysqli_error($conn));

        /* ----------------- SALVANDO LOG ----------------- */
        //DESATIVANDO POSTAGEM
        $inserLog = "INSERT INTO tv_log (tv_usuarioAcao, tv_postagemAlterada, tv_log, tv_data) VALUES ('".$_SESSION['id']."', '".$_GET['id_post']."', 3, '".$data."')";
        $resultadoLog = mysqli_query($conn, $inserLog) or die(mysqli_error($conn));

    }else{
        //usuário
        $desativa = "UPDATE tv_login SET tv_deletado = 1 WHERE id = ".$_GET['id']."";
        $result = mysqli_query($conn, $desativa) or die(mysqli_error($conn));

        /* ----------------- SALVANDO LOG ----------------- */
        //DESATIVANDO USUÁRIO
        $inserLog = "INSERT INTO tv_log (tv_usuarioAcao, tv_usuarioAlterado, tv_log, tv_data) VALUES ('".$_SESSION['id']."', '".$_GET['id']."', 3, '".$data."')";
        $resultadoLog = mysqli_query($conn, $inserLog) or die(mysqli_error($conn));       
    }        
}

/* ----------------- FINALIZANDO ----------------- */

//fechando o banco
mysqli_close($conn);

//volta para a tela

if(empty($_GET['id'])){
    //postagem
    if($_GET['ativa'] === 'sim'){//ativando
        header('location: dashboard.php?pagina=1&msn=2');
    }else{
        header('location: dashboard.php?pagina=1&msn=3');
    }

}else{
    //usuário
    if($_GET['ativa'] === 'sim'){//ativando
        header('location: list_user.php?pagina=4&msn=2');
    }else{
        header('location: list_user.php?pagina=4&msn=3');
    }
}
?>