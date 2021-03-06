<?php 
    include "adm/conexao.php";//banco de dados 
    //chamando todas as filiais ativas
    $queryFilial = "SELECT id, tv_nomeFilial FROM tv_filiais where tv_concessionaria = ".$_GET['id']." AND tv_desativarFilial = 0";
    $resultFilial = mysqli_query($conn, $queryFilial);
    //pegando nome da concessionaria
    $queryConcessionaria = "SELECT tv_nomeFilial FROM tv_concessionarias WHERE id = ".$_GET['id']."";
    $resultConcessionaria = mysqli_query($conn, $queryConcessionaria);
    $rowConcessionaria = mysqli_fetch_assoc($resultConcessionaria);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title><?= $rowConcessionaria['tv_nomeFilial'] ?></title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <!--bootstrap 4-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src='main.js'></script>
    <!--FAVICON 5-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <!--FAVICON 5 END-->
</head>
<body>
    <div class="content"> 
        <div  style="margin: 10px">
            <a href="index.php" title="Voltar">
                <i class="fas fa-arrow-circle-left fa-2x"></i>
            </a>
        </div>           
        <div class="mx-auto">            
            <ul>
            <?php
                while($rowFilial= mysqli_fetch_assoc($resultFilial)){
                    echo '
                        <li class="filiais">
                            <a href="postagens/index.php?id='.$rowFilial['id'].'" class="badge badge-secondary grow">
                                <span class="nomeFilial">'.$rowFilial['tv_nomeFilial'].'</span>
                            </a>
                        </li>
                    ';
                }
            ?>                
            </ul>
        </div> 
    </div>      
</body>
<!--bootstrap 4-->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</html>