<?php
//iniciando sessão
session_start();
//id_micro
$_SESSION['systemid'] = $_GET['systemid'];

//chamando banco
require_once('conexao.php');

//coletando informações do office
$queryMicro = " SELECT 
                    OFF.ID, OFF.PRODUCT, OFF.TYPE, OFF.OFFICEKEY, AC.TAG, H.NAME
                FROM
                    officepack OFF
                LEFT JOIN
                    accountinfo AC ON (OFF.HARDWARE_ID = AC.HARDWARE_ID)
                LEFT JOIN
                    hardware H ON (OFF.HARDWARE_ID = H.ID)
                WHERE OFF.HARDWARE_ID = " . $_GET['systemid'] . "";

$resultMicro = $conn->query($queryMicro);


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

    <title>OFFICE LICENCES - REMOVER</title>

</head>

<body>
    <div class="container-sm">
        <div class="text-center">
            <img src="themes/OCS/logo.png" class="rounded" alt="Logo OCS" style="width: 15%;">
        </div>
        <h3>REMOVER OFFICE</h3>
        <hr>

        <?php
        while ($micro = $resultMicro->fetch_assoc()) {
            echo '<form action="" method="POST">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Computador</label>
                    <input type="text" class="form-control" id="inputEmail4" value="' . $micro['NAME'] . '" disabled>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">TAG</label>
                    <input type="text" class="form-control" id="inputPassword4" value="' . $micro['TAG'] . '" disabled>
                </div>
            </div>
            <div class="form-group">
                <label for="inputAddress2">Versão</label>
                <select id="inputState" class="form-control" name="versao" disabled>
                    <option selected>' . $micro['PRODUCT'] . '</option>
                </select>
            </div>
            <div class="form-group">
                <label for="inputAddress">Serial Key</label>
                <input type="text" class="form-control" id="inputAddress" name="serial" value="' . $micro['OFFICEKEY'] . '" disabled>
            </div>
            <div class="form-group">
                <label for="inputState">Tipo</label>
                <select id="inputState" class="form-control" name="tipo" disabled>
                    <option selected>' . $micro['TYPE'] . '</option>
                </select>
            </div>
            <a href="http://rede.paranapart.com.br/ocsreports/index.php?function=computer&head=1&systemid=12026&cat=software" class="btn btn-info">Voltar</a>
            <div style="float: right;">
                <a href="dropOfficeBack.php?id_off=' . $micro['ID'] . '" class="btn btn-danger">REMOVER OFFICE!</a>
            </div>
        </form><hr>';
        }

        ?>
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