<?php
    //chamando banco de dados
    include 'conexao.php';

    //data de hoje
    $data = date('d/m/Y');

    $inserindo = "INSERT INTO blog_comentarios (id_postagem, nome, departamento, empresa, comentario, data)
                    VALUE
                        ('".$_POST['id_postagem']."','".$_POST['nome']."','".$_POST['departamento']."','".$_POST['empresa']."','".$_POST['comentario']."','".$data."')";
    $resultado = mysqli_query($conn, $inserindo) or die(mysqli_error($conn));


    //verificando se quem fez a postagem pediu para receber e-mail deste comentário

    $permissao_envio = "SELECT alerta_comentario FROM blog_post where id_postagem = ".$_POST['id_postagem']."";
    $resposta_envio = mysqli_query($conn, $permissao_envio);

    if($linha_envio = mysqli_fetch_assoc($resposta_envio)){

        if($linha_envio['alerta_comentario'] == 1){
            //envia e-mail
            header('location: enviar_email.php?id_post='.$_POST['id_postagem'].'');
            exit;

        }else{        
            //voltando para informar que foi salvo com sucesso!
            header('location: postagem.php?id_post='.$_POST['id_postagem'].'&msn=1');
        }
    }

    mysqli_close($conn);
?>