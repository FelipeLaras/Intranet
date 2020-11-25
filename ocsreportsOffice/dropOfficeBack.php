<?php
//iniciando sessão
session_start();

//chamando o banco
require_once('conexao.php');

//salvando office no banco
$deleteOffice = "DELETE FROM officepack WHERE (`ID` = '".$_GET['id_off']."') and (`HARDWARE_ID` = '".$_SESSION['systemid']."')";

if($resultDelete = $conn->query($deleteOffice)){
    header('location: msn.php?msn=2');
}else{
    echo "ops aconteceu algo de errado <br />";

    printf("Errormessage: %s\n", $conn->error);
}

?>