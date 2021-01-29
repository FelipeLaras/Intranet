<?php 
session_start();

if(empty($_SESSION["id"])){
  header('location: index.php');
}

//validando
if($_GET['pagina'] != 1){
  header('location: 404.php');
}
require 'header.php';

require 'menu_lateral.php'; 

//pegando todas as postagens

$postagens_query = "SELECT 
                id_postagem, titulo, mensagem, file_img, data, data_drop, deletar, carousel
              FROM
                blog_post
              WHERE id_post_user = ".$_SESSION['id']." ORDER BY id_postagem DESC";

$result_postagem = mysqli_query($conn, $postagens_query);

?>
<!DOCTYPE html>
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <!--overview start-->
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fas fa-book-open"></i> Minhas publicações</h3>

            <div id="new">
              <a class="btn btn-danger" href="tipo_postagem.php?pagina=5">
                <i class="fas fa-plus"></i> Nova Postagem
              </a>
            </div>

            <?php
                if($_GET['msn'] == 1){
                  echo "
                  <div class='alert alert-success fade in'>
                    <button data-dismiss='alert' class='close close-sm' type='button'>
                      <i class='far fa-times-circle' style='color: red;'></i>
                    </button>
                  <strong>Atenção</strong> Cadastrado realizado com sucesso!. SAIA E ENTRE NOVAMENTE PARA APLICAR A ATUALIZAÇÃO
                </div>";
              }

              if($_GET['msn'] == 2){
                echo "<div class='alert alert-info fade in'>
                <button data-dismiss='alert' class='close close-sm' type='button'>
                  <i class='far fa-times-circle' style='color: red;'></i>
                </button>
                <strong>Atenção</strong> Postagem reativada com sucesso!.
              </div>";
              }

              if($_GET['msn'] == 3){
                echo "<div class='alert alert-block alert-danger fade in'>
                <button data-dismiss='alert' class='close close-sm' type='button'>
                  <i class='far fa-times-circle' style='color: blue;'></i>
                </button>
                <strong>Atenção</strong> Publicação desativada com sucesso!.
              </div>";
              }

              if($_GET['msn'] == 4){
                echo "<div class='alert alert-info fade in'>
                <button data-dismiss='alert' class='close close-sm' type='button'>
                  <i class='far fa-times-circle' style='color: red;'></i>
                </button>
                <strong>Atenção</strong> Postagem editada com sucesso!.
              </div>";
              }

              if($_GET['msn'] == 5){
                echo "<div class='alert alert-info fade in' style='margin-top: 33px;'>
                <button data-dismiss='alert' class='close close-sm' type='button'>
                  <i class='far fa-times-circle' style='color: red;'></i>
                </button>
                <strong>Atenção</strong> Postagem realizada com sucesso!.
              </div>";
              }
            ?>
          </div>
        </div>

        <div class="row"></div>
          <div class="col-lg-12">
            <section class="panel">
              <table class="table table-striped table-advance table-hover">
                <tbody>
                  <tr>
                    <th>Titulo</th>
                    <th>Imagem / Video</th>
                    <th>Mensagem</th>                    
                    <th>Data postagem</th>                                        
                    <th>Data exclusão</th>
                    <th>Ação</th>
                  </tr>

                  <?php

                  while($postagens = mysqli_fetch_assoc($result_postagem)){

                    $carrorel = "SELECT file_img FROM blog.blog_post_carousel WHERE id_postagem = ".$postagens['id_postagem']."";
                    $reCarrosel = mysqli_query($conn, $carrorel);


                    echo "
                    <tr>
                      <td>".$postagens['titulo']."</td>";


                      if($postagens['carousel'] == 1){
                        echo "<td><a href='#arquivo".$postagens['id_postagem']."' data-toggle='modal' title='Clique para ver o arquivo'>Arquivo</a></td>";
                      }else{
                        echo "<td><a href='../".$postagens['file_img']."' target='_blank' title='Clique para ver o arquivo'>Arquivo</a></td>";
                      }

                     echo "<td><a href='#".$postagens['id_postagem']."' data-toggle='modal' title='Clique para ver a mensagem'>Mensagem</a></td>
                      <td>".$postagens['data']."</td>
                      <td>".$postagens['data_drop']."</td>
                      <td>
                        <div class='btn-group'>";
                          
                          if($postagens['deletar'] == 0){                            
                                echo "
                                    <a class='btn btn-primary' href='../postagem.php?id_post=".$postagens['id_postagem']."' title='ver no blog' target='_blank'><i class='fas fa-eye'></i></a>
                                    <a class='btn btn-danger' href='ativa_desativa.php?id_post=".$postagens['id_postagem']."&ativa=nao' title='desativar'><i class='icon_close_alt2'></i></a>";
                            }else{
                              echo "<a class='btn btn-success' href='ativa_desativa.php?id_post=".$postagens['id_postagem']."&ativa=sim' title='ativar'><i class='icon_check_alt2'></i></a>";
                            }                      
                            echo "
                          <a class='btn btn-warning' href='editar_postagem.php?pagina=3&id_post=".$postagens['id_postagem']."' title='editar'><i class='fas fa-edit'></i></a>
                        </div>
                      </td>
                  </tr>";
                    //modal mensagem        
                  echo "
                  <div aria-hidden='false' aria-labelledby='myModalLabel' role='dialog' tabindex='-1' id='".$postagens['id_postagem']."' class='modal fade in' style='display: none;'>
                  <div class='modal-dialog'>
                    <div class='modal-content'>
                      <div class='modal-header'>
                        <button aria-hidden='true' data-dismiss='modal' class='close' type='button'>×</button>
                        <h4 class='modal-title'>Mensagem da Publicação - ".$postagens['titulo']."</h4>
                      </div>
                      <div class='modal-body'>
                            ".$postagens['mensagem']."
                      </div>

                    </div>
                  </div>
                </div>";

                //modal File        
                echo "
                <div aria-hidden='false' aria-labelledby='myModalLabel' role='dialog' tabindex='-1' id='arquivo".$postagens['id_postagem']."' class='modal fade in' style='display: none;'>
                <div class='modal-dialog'>
                  <div class='modal-content'>
                    <div class='modal-header'>
                      <button aria-hidden='true' data-dismiss='modal' class='close' type='button'>×</button>
                      <h4 class='modal-title'>Mensagem da Publicação - ".$postagens['titulo']."</h4>
                    </div>
                    <div class='modal-body'>
                          
                    <div class='container'>
  <div id='myCarousel' class='carousel slide' data-ride='carousel'>
    <!-- Wrapper for slides -->
    <div class='carousel-inner'>";

    $conte = 0;

    while($row_carrosel = mysqli_fetch_assoc($reCarrosel)){

    switch ($conte) {
      case '0':
        echo "<div class='item active'><img src='../".$row_carrosel['file_img']."'></div>";

      break;
         
      default:
        echo "<div class='item'><img src='../".$row_carrosel['file_img']."'></div>";
    }
    $conte++;    
  }

echo "
    </div>

    <!-- Left and right controls -->
    <a class='left carousel-control' href='#myCarousel' data-slide='prev'>
    </a>
    <a class='right carousel-control' href='#myCarousel' data-slide='next'>
    </a>
  </div>
</div>























                    </div>

                  </div>
                </div>
              </div>";
                  }
                  ?>
                </tbody>
              </table>
            </section>
          </div>
        </div>
        <!-- page end-->
      </section>
    </section>
    <!--main content end-->

  <!-- javascripts -->
  <script src="js/jquery.js"></script>
  <script src="js/jquery-ui-1.10.4.min.js"></script>
  <script src="js/jquery-1.8.3.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>
  <!-- bootstrap -->
  <script src="js/bootstrap.min.js"></script>
  <!-- nice scroll -->
  <script src="js/jquery.scrollTo.min.js"></script>
  <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
  <!-- charts scripts -->
  <script src="assets/jquery-knob/js/jquery.knob.js"></script>
  <script src="js/jquery.sparkline.js" type="text/javascript"></script>
  <script src="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
  <script src="js/owl.carousel.js"></script>
  <!-- jQuery full calendar -->
  <<script src="js/fullcalendar.min.js"></script>
    <!-- Full Google Calendar - Calendar -->
    <script src="assets/fullcalendar/fullcalendar/fullcalendar.js"></script>
    <!--script for this page only-->
    <script src="js/calendar-custom.js"></script>
    <script src="js/jquery.rateit.min.js"></script>
    <!-- custom select -->
    <script src="js/jquery.customSelect.min.js"></script>
    <script src="assets/chart-master/Chart.js"></script>

    <!--custome script for all page-->
    <script src="js/scripts.js"></script>
    <!-- custom script for this page-->
    <script src="js/sparkline-chart.js"></script>
    <script src="js/easy-pie-chart.js"></script>
    <script src="js/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="js/jquery-jvectormap-world-mill-en.js"></script>
    <script src="js/xcharts.min.js"></script>
    <script src="js/jquery.autosize.min.js"></script>
    <script src="js/jquery.placeholder.min.js"></script>
    <script src="js/gdp-data.js"></script>
    <script src="js/morris.min.js"></script>
    <script src="js/sparklines.js"></script>
    <script src="js/charts.js"></script>
    <script src="js/jquery.slimscroll.min.js"></script>
    <script>
      //knob
      $(function() {
        $(".knob").knob({
          'draw': function() {
            $(this.i).val(this.cv + '%')
          }
        })
      });

      //carousel
      $(document).ready(function() {
        $("#owl-slider").owlCarousel({
          navigation: true,
          slideSpeed: 300,
          paginationSpeed: 400,
          singleItem: true

        });
      });

      //custom select box

      $(function() {
        $('select.styled').customSelect();
      });
    </script>

</body>

</html>
