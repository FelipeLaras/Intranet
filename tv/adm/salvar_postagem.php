<?php
//sessão
session_start();

//banco de dados
require 'conexao.php';

//data de hoje
$data = date('d/m/Y');


/*--------------------- SALVANDO A POSTAGEM PARA A PENAS A VISUALIZAÇÃO --------------------- */


if($_POST['veja'] == 1){
    // 1º iremos salvar a IMG
    $cont = 0;

  
    if($_POST['dataFim'] != NULL){
        $dataExclusao = $_POST['dataFim'];
    }else{
        $dataExclusao = "noDate";
    }

    while($_FILES['file'.$cont.''] != NULL){

        //salvando o file da nota
        $tipo_file = $_FILES['file'.$cont.'']['type'];//Pegando qual é a extensão do arquivo
        $nome_db = $_FILES['file'.$cont.'']['name'];
        $caminho = "/var/www/html/tv/documentos/postagens/" . $_FILES['file'.$cont.'']['name'];//caminho onde será salvo o FILE
        $caminho_db = "../../documentos/postagens/".$_FILES['file'.$cont.'']['name'];//pasta onde está o FILE para salvar no Bando de dados

 
        /*VALIDAÇÃO DO FILE*/
        $sql_file = "SELECT tv_tipoArquivo FROM tv_arquivosPermitidos WHERE tv_tipoArquivo LIKE '".$tipo_file."'";//query de validação 
        $result =  mysqli_query($conn, $sql_file);//aplicando a query
        $row = mysqli_fetch_array($result);//salvando o resultado em uma variavel

        /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
        if($tipo_file != NULL){
            if ($row['tv_tipoArquivo'] != NULL) {//se é arquivo valido       
                if (move_uploaded_file($_FILES['file'.$cont.'']['tmp_name'], $caminho )){//aplicando o salvamento
                    //echo "Arquivo enviado para = ".$_FILES['file'.$cont.'']['tmp_name'].$uploadfile;
                }else{
                    echo "Arquivo não foi enviado!";
                }//se caso não salvar vai mostrar o erro!
            }else{// se o arquivo não é valido vai levar para tela de erro    
                echo "Arquivo Invalido!";
                exit;
            }//end IF validação
        }//end IF anexo cheio

        if(isset($_POST['filial'])){
            foreach($_POST['filial'] as $filial){

                //salvando a postagem no banco
                $postagemVisualizar = "INSERT INTO tv_postagemVisualizar (tv_usuario, tv_filial, tv_caminhoImg, tv_tipoImg, tv_dataPostagem, tv_corFundo, tv_tempoExecucao, 
                tv_dataDesativar) 
                    VALUES ('".$_SESSION["id"]."', 
                            '".$filial."', 
                            '".$caminho_db."', 
                            '".$tipo_file."', 
                            '".$data."', 
                            '".$_POST['corfundo']."', 
                            '".$_POST['tempo']."', 
                            '".$dataExclusao."')";
                $resultPostVisual = mysqli_query($conn, $postagemVisualizar) or die(mysqli_error($conn));
            }
        }
        $cont++;
    }

    header('location: postagemVeja/veja.php');
}//FIM VEJA COMO FICOU


// 2º iremos salvar a postagem
if($_POST['postar'] == 1){
    // 1º iremos salvar a IMG
    $cont = 0;

  
    if($_POST['dataFim'] != NULL){
        $dataExclusao = $_POST['dataFim'];
    }else{
        $dataExclusao = "noDate";
    }

    while($_FILES['file'.$cont.''] != NULL){

        //salvando o file da nota
        $tipo_file = $_FILES['file'.$cont.'']['type'];//Pegando qual é a extensão do arquivo
        $nome_db = $_FILES['file'.$cont.'']['name'];
        $caminho = "/var/www/html/tv/documentos/postagens/" . $_FILES['file'.$cont.'']['name'];//caminho onde será salvo o FILE
        $caminho_db = "../documentos/postagens/".$_FILES['file'.$cont.'']['name'];//pasta onde está o FILE para salvar no Bando de dados

 
        /*VALIDAÇÃO DO FILE*/
        $sql_file = "SELECT tv_tipoArquivo FROM tv_arquivosPermitidos WHERE tv_tipoArquivo LIKE '".$tipo_file."'";//query de validação 
        $result =  mysqli_query($conn, $sql_file);//aplicando a query
        $row = mysqli_fetch_array($result);//salvando o resultado em uma variavel

        /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
        if($tipo_file != NULL){
            if ($row['tv_tipoArquivo'] != NULL) {//se é arquivo valido       
                if (move_uploaded_file($_FILES['file'.$cont.'']['tmp_name'], $caminho )){//aplicando o salvamento
                    //echo "Arquivo enviado para = ".$_FILES['file'.$cont.'']['tmp_name'].$uploadfile;
                }else{
                    echo "Arquivo não foi enviado!";
                }//se caso não salvar vai mostrar o erro!
            }else{// se o arquivo não é valido vai levar para tela de erro    
                echo "Arquivo Invalido!";
                exit;
            }//end IF validação
        }//end IF anexo cheio

        if(isset($_POST['filial'])){
            foreach($_POST['filial'] as $filial){

                //salvando a postagem no banco
                $postagemVisualizar = "INSERT INTO tv_postagem (tv_usuario, tv_filial, tv_caminhoImg, tv_tipoImg, tv_dataPostagem, tv_corFundo, tv_tempoExecucao, 
                tv_dataDesativar) 
                    VALUES ('".$_SESSION["id"]."', 
                            '".$filial."', 
                            '".$caminho_db."', 
                            '".$tipo_file."', 
                            '".$data."', 
                            '".$_POST['corfundo']."', 
                            '".$_POST['tempo']."', 
                            '".$dataExclusao."')";
                $resultPostVisual = mysqli_query($conn, $postagemVisualizar) or die(mysqli_error($conn));
            }
        }
        $cont++;
    }

    header('location: dashboard.php?pagina=1&msn=2');
}//FIM VEJA COMO FICOU

?>