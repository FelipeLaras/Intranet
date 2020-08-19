<?php
//chamando o banco de dados
require '../adm/conexao.php';
//data de hoje
$data = date('d/m/Y');

//DADOS DA FILIAL
$queryFilial = "SELECT tv_nomeFilial FROM tv_filiais WHERE id = '" . $_GET['id'] . "'";
$resultFilial = mysqli_query($conn, $queryFilial);
$filial = mysqli_fetch_assoc($resultFilial);

//DADOS DA POSTAGENS
$queyPostagem = "SELECT id, tv_dataDesativar FROM tv_postagem WHERE tv_desativar = 0 AND tv_filial = '" . $_GET['id'] . "'";
$resultPostagem = mysqli_query($conn, $queyPostagem);

//DESATIVANDO POSTAGEM COM DATA DE HOJE
while ($verificandoData = mysqli_fetch_assoc($resultPostagem)) {
  if ($verificandoData['tv_dataDesativar'] == $data) {

    $desativar = "UPDATE tv_postagem SET tv_desativar = 1 WHERE id = " . $verificandoData['id'] . "";
    $resultDesativar = mysqli_query($conn, $desativar) or die(mysqli_error($conn));
  }
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>TV - <?= $filial['tv_nomeFilial'] ?></title>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <!--<script src='config.js'></script>-->
  <script src="./dist/Slidr.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modo FullScreen</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
          <button type="button" class="btn btn-primary" onclick="entrarFullScreen()">Sim</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Fim Modal -->

  <div id="timer" class="timer" style="display: none;"></div>
  <div id="botao" style="display: none;">
    <button data-pause class="slider__control">&#10073;&#10073;</button>
    <button data-resume class="slider__control control-hidden">&#9658;</button>
  </div>
  <div class="slider">
    <?php

    //DADOS DA POSTAGENS
    $pesquisaPostagem = "SELECT id, tv_caminhoImg, tv_corFundo FROM tv_postagem WHERE tv_desativar = 0 AND tv_filial = '" . $_GET['id'] . "'";
    $resultPesquisaPostagem = mysqli_query($conn, $pesquisaPostagem);

    while ($postagem = mysqli_fetch_assoc($resultPesquisaPostagem)) {

      echo '<div data-slide="slide' . $postagem['id'] . '" class="slide" style="background-color:' . $postagem['tv_corFundo'] . '">
                <img src="' . $postagem['tv_caminhoImg'] . '" alt="imgPostagem_' . $postagem['id'] . '" class="imgJPG">
              </div>';
    }
    ?>
    <script>
      document.addEventListener('DOMContentLoaded', () => {

        const $timer = document.getElementById('timer')
        const $progress = document.getElementById('slider_progress')
        const $dotNav = document.getElementById('nav__dots')
        const $pauseBtn = document.querySelector('[data-pause]')
        const $resumeBtn = document.querySelector('[data-resume]')
        const populateTimer = timeout => {
          let cpt = timeout / 1000
          $timer.innerHTML = cpt.toString()
          return window.setInterval(() => {
            cpt--
            $timer.innerHTML = cpt.toString()
          }, 1000)
        }
        const cancelTimer = timer => {
          if (timer !== null)
            window.clearInterval(timer)
        }
        const populateProgress = (progress) => {
          $progress.style.width = progress + '%'
        }

        let timer = null
        let remaining = 0
        const slider = new window.Slidr({
          animate: false
        })
        slider

        <?php
        //DADOS DA POSTAGENS
        $pesquisaPostagemJava = "SELECT id, tv_tempoExecucao FROM tv_postagem WHERE tv_desativar = 0 AND tv_filial = '" . $_GET['id'] . "'";
        $resultPesquisaPostagemJava = mysqli_query($conn, $pesquisaPostagemJava);

        while ($postagemJava = mysqli_fetch_assoc($resultPesquisaPostagemJava)) {
          echo ".add({ name: 'slide" . $postagemJava['id'] . "', timeout: " . $postagemJava['tv_tempoExecucao'] . " * 1000 })";
        }
        ?>
          .listen('beforeEnter', function() {
            timer = populateTimer(this.current_slide.timeout)
            remaining = this.current_slide.timeout
            $resumeBtn.classList.add('control-hidden')
            $pauseBtn.classList.remove('control-hidden')
            populateProgress(this.progress)
            $dotNav.querySelectorAll(`[data-index]:not([data-index="${this.current_slide.index}"])`).forEach(dot => dot.classList.remove('active'))
            $dotNav.querySelector(`[data-index="${this.current_slide.index}"]`).classList.add('active')
          })
          .listen('beforeLeave', function() {
            cancelTimer(timer)
          });


        slider.slides.forEach(({
          index
        }) => {
          let dot = document.createElement('div')
          dot.classList.add('nav__dot')
          dot.dataset.index = index

          dot.addEventListener('click', e => {
            e.preventDefault()
            slider.goTo(index)
            document.querySelectorAll('.nav__dot').forEach(d => d.classList.remove('active'))
            dot.classList.add('active')
          })

          $dotNav.appendChild(dot)
        });

        document.querySelector('[data-prev]').addEventListener('click', e => {
          e.preventDefault()
          slider.prev()
        })

        document.querySelector('[data-next]').addEventListener('click', e => {
          e.preventDefault()
          slider.next()
        })

        $pauseBtn.addEventListener('click', e => {
          e.preventDefault()
          $pauseBtn.classList.add('control-hidden')
          $resumeBtn.classList.remove('control-hidden')
          cancelTimer(timer)
          timer = null
          remaining = slider.pause()
        })

        $resumeBtn.addEventListener('click', e => {
          e.preventDefault()
          $resumeBtn.classList.add('control-hidden')
          $pauseBtn.classList.remove('control-hidden')
          timer = populateTimer(remaining)
          remaining = 0
          slider.resume()
        })

        slider.run()

      })
    </script>
     <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
        <script>
            $(document).ready(function(){
                $('#exampleModal').modal('show');
            });
        </script>
        <script language="JavaScript">
          function entrarFullScreen(){
            if (!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) { 
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.msRequestFullscreen) {
                    document.documentElement.msRequestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) {
                    document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
                }
            }
          }
        </script> 
    <div class="slider__nav" style="display: none;">
      <button data-prev class="slider__prev">&lt;</button>
      <div id="nav__dots" class="nav__dots"></div>
      <button data-next class="slider__prev">&gt;</button>
    </div>
    <div id="slider_progress" class="slider_progress"></div>
  </div>
</body>

</html>