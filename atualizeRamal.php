<!DOCTYPE html>
<?php
    /* Informa o nível dos erros que serão exibidos */
    error_reporting(E_ALL);
    
    /* Habilita a exibição de erros */
    ini_set("display_errors", 1);

    //chamando banco de dados
    require_once('conexao.php'); 

    //GET IP DO USUÁRIO
    $ip = $_SERVER['REMOTE_ADDR'];

    //DATA DE HOJE
    $dataHoje = date('d/m/yy');

    $insertLog = "INSERT INTO atualize_ramal_logs (ip, dataCriacao) VALUES ('".$ip."', '".$dataHoje."')";

    if(!$result = $banco_blog->query($insertLog)){

        printf("Erro de query: %s\n", $banco_blog->error);

    }
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Ramal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <!-- ICONES FONTAWESOME -->
    <script src="https://kit.fontawesome.com/7005bd725e.js" crossorigin="anonymous"></script>

    <style>
        div.imgGLPI {
            text-align: center;
        }

        img.imgGLPI {
            width: 50%;
        }

        h1 {
            text-align: center;
            text-transform: uppercase;
        }

        .red {
            color: red;
        }

        .containerOne {
            background-color: yellow;
            padding: 5px;
            width: 25%;
            margin: 2% 0% 1% 40%;
        }

        .containerTwo {
            background-color: antiquewhite;
            padding: 5px;
        }
    </style>
</head>

<body>
    <div id="titulo">
        <h1 class="red">Como eu atualizo o meu Ramal?</h1>
    </div>
    <div class="descricao">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <h3>1º - LOGAR NO GLPI</h3>
            </li>
            <li class="list-group-item">
                <p><i class="far fa-hand-point-right"></i> acesse o seu GLPI (Sistema de Chamados) e realize o seu LOGIN
                    - <a href="http://rede.paranapart.com.br/glpi" class="cliqueAqui" target="_blank">Clique Aqui</a>
                    para
                    que possamos te enviar até lá.</p>
                <div class="imgGLPI">
                    <a href="img/icones/loginGLPI.JPG" class="ampliarIMG" target="_blank">
                        <img src="img/icones/loginGLPI.JPG" alt="Login GLPI" class="imgGLPI">
                    </a>
                </div>
                <div class="containerOne">
                    <div class="containerTwo">
                        <p class="text-align-center">
                            <i class="fas fa-thumbtack"></i>
                            Caso não lembre ou não tenha o
                            acesso, basta entrar em contato com o TI que te auxiliamos. <a
                                href="http://10.100.1.217/lista/filiais/index.php?locations=4&amp;dep=TI"
                                class="cliqueAqui" target="_blank">CLIQUE AQUI</a> para saber quais são os números!
                        </p>
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <h3>2º - ATUALIZE O RAMAL E LOCALIZAÇÃO!</h3>
            </li>
            <li class="list-group-item">
                <p><i class="far fa-hand-point-right"></i> Clique na engrenagem que fica no canto superior direito:</p>
                <div class="imgGLPI">
                    <a href="img/icones/EngrenagemGLPI.JPG" class="ampliarIMG" target="_blank">
                        <img src="img/icones/EngrenagemGLPI.JPG" alt="EngrenagemGLPI" class="imgGLPI">
                    </a>
                </div>
                <p><i class="far fa-hand-point-right"></i> Agora basta localizar os campos de <b class="red">RAMAL</b>,
                    <b class="red">VOIP</b> e <b class="red">LOCALIZAÇÃO</b> alterar e clicar em SALVAR!</p>
                <div class="imgGLPI">
                    <a href="img/icones/FormularioGLPI.JPG" class="ampliarIMG" target="_blank">
                        <img src="img/icones/FormularioGLPI.JPG" alt="FormularioGLPI" class="imgGLPI">
                    </a>
                </div>
                
                <div class="containerOne">
                    <div class="containerTwo">
                        <p class="text-left"><i class="far fa-thumbs-up"></i> VIU COMO É FÁCIL FÁCIL!!</p>
                        <p class="text-left"><i class="far fa-thumbs-up"></i> ENTÃO NÃO DEIXE DESATUALIZADO.</p>
                        <p class="text-left"><i class="fas fa-check"></i> LEMBRE, MUDOU DE RAMAL!.... <b class="red">ATUALIZE!</b></p>
                    </div>
                </div>
                <div class="footer"><p class="text-right">Att. T.I</p></div>
            </li>
        </ul>
    </div>
</body>

</html>