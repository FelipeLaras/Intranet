<?php
//banco de dados
include 'conexao.php';

// SALVANDO OS FILES DA POSTAGEM
if($_FILES['file']['name'] != NULL){
    //salvando o file da nota
    $tipo_file = $_FILES['file']['type'];//Pegando qual é a extensão do arquivo
    $nome_db = $_FILES['file']['name'];
    $caminho = "/var/www/html/tv/documentos/postagens/" . $_FILES['file']['name'];//caminho onde será salvo o FILE
    $caminho_db = "../documentos/postagens/".$_FILES['file']['name'];//pasta onde está o FILE para salvar no Bando de dados

    /*VALIDAÇÃO DO FILE*/
    $sql_file = "SELECT tv_tipoArquivo FROM tv_arquivosPermitidos WHERE tv_tipoArquivo LIKE '".$tipo_file."'";//query de validação 

    $result =  mysqli_query($conn, $sql_file);//aplicando a query
    $row = mysqli_fetch_array($result);//salvando o resultado em uma variavel

    /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
    if($tipo_file != NULL){
        if ($row['tv_tipoArquivo'] != NULL) {//se é arquivo valido       
            if (move_uploaded_file($_FILES['file']['tmp_name'], $caminho )){//aplicando o salvamento
                //echo "Arquivo enviado para = ".$_FILES['file_nota_celular'.$cont_equip.'']['tmp_name'].$uploadfile;
            }else{
            echo "Arquivo não foi enviado!";
            }//se caso não salvar vai mostrar o erro!
        }else{// se o arquivo não é valido vai levar para tela de erro    
            echo "Arquivo Invalido!";
            exit;
        }//end IF validação
    }//end IF anexo cheio


    $alterando = "UPDATE tv_postagem SET tv_tempoExecucao = '".$_POST['tempo']."', 
                                         tv_dataDesativar = '".$_POST['dataFim']."', 
                                         tv_corFundo = '".$_POST['corfundo']."', 
                                         tv_filial = '".$_POST['filial']."', 
                                         tv_caminhoImg = '".$caminho_db."'
                    WHERE id = ".$_GET['id_post']."";
    $resultado_alterando = mysqli_query($conn, $alterando) or die(mysqli_error($conn));

}else{

    $alterando = "UPDATE tv_postagem SET    tv_tempoExecucao = '".$_POST['tempo']."', 
                                            tv_dataDesativar = '".$_POST['dataFim']."', 
                                            tv_corFundo = '".$_POST['corfundo']."', 
                                            tv_filial = '";
                                            if(isset($_POST['filial'])){
                                                foreach($_POST['filial'] as $filial){
                                                    $alterando .= $filial;
                                                }
                                            }
    $alterando .= "'WHERE id = ".$_GET['id_post']."";
    $resultado_alterando = mysqli_query($conn, $alterando) or die(mysqli_error($conn));

}

//fechando o banco
mysqli_close($conn);

//voltando para a tela
header('location: dashboard.php?pagina=1&msn=4');
?>