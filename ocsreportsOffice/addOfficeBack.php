<?php
//iniciando sessão
session_start();

//chamando o banco
require_once('conexao.php');

//salvando office no banco
$insertOffice = "INSERT INTO officepack (HARDWARE_ID, OFFICEVERSION, PRODUCT, TYPE, OFFICEKEY, INSTALL) VALUES ('".$_SESSION['systemid']."', '---', '".$_POST['versao']."', '".$_POST['tipo']."', '".$_POST['serial']."', '0')";

if($resultInsert = $conn->query($insertOffice)){
    header('location: msn.php?msn=1');
}else{
    echo "ops aconteceu algo de errado <br />";

    printf("Errormessage: %s\n", $conn->error);
}

?>