<?php
//session
session_start();

//chamando banco de dados
require '../conexao.php';

//pegando a ultima postagem apenas para vizualização
$queyPostagem = "SELECT * FROM tv_postagemVisualizar TPV WHERE TPV.tv_usuario = ".$_SESSION["id"]." ORDER BY TPV.id DESC";
$resultadoPostagem = mysqli_query($conn, $queyPostagem);
$postagem = mysqli_fetch_assoc($resultadoPostagem);

?>


<!DOCTYPE html>
<html>

<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>Veja como ficou!</title>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <script src='config.js'></script>
  <script src="./dist/Slidr.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>

  <div id="timer" class="timer" style="display: none;"></div>
  <div id="botao" style="display: none;">
    <button data-pause class="slider__control">&#10073;&#10073;</button>
    <button data-resume class="slider__control control-hidden">&#9658;</button>
  </div>
  <div class="slider">

    <div data-slide="slide1" class="slide" style="background-color: <?= $postagem['tv_corFundo']   ?>">
      <center>
        <img src="<?= $postagem['tv_caminhoImg'] ?>" alt="propaganda" class="imgJPG">
      </center>
    </div>

    <div class="slider__nav" style="display: none;">
      <button data-prev class="slider__prev">&lt;</button>
      <div id="nav__dots" class="nav__dots"></div>
      <button data-next class="slider__prev">&gt;</button>
    </div>
    <div id="slider_progress" class="slider_progress"></div>
  </div>

</body>

</html>