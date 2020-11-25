<?php
//iniciando sessão
session_start();
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--FAVICON-->
    <link rel="shortcut icon" href="favicon.ico" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>OFFICE LICENCES - ADD</title>

</head>

<body>
    <div class="container-sm">
        <div class="text-center">
            <img src="themes/OCS/logo.png" class="rounded" alt="Logo OCS" style="width: 15%;">
            <?= ($_GET['msn'] == 1) ? "<h1>Office <span style='color: blue'>ADICIONADO</span> com sucesso!</h1>" : "<h1>Office <span style='color: red'>REMOVIDO</span> com sucesso!</h1>" ?>            
            <a href="http://rede.paranapart.com.br/ocsreports/index.php?function=computer&amp;head=1&amp;systemid=<?= $_SESSION['systemid'] ?>&amp;cat=software" class="btn btn-info" style="margin-top: 33px;">Voltar para OCS</a>
        </div>        
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
<footer style="margin-top: 100px;">
    <hr>
    <div class="container">
        <img src="themes/OCS/banniere.png" class="rounded float-left" alt="Banner OCS" style="width: 79px;">
    </div>
</footer>

</html>