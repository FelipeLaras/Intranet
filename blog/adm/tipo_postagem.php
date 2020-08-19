<!DOCTYPE html>
<?php 
  //validando
  if($_GET['pagina'] != 5){
    header('location: 404.php');
  }
  require 'header.php';

  require 'menu_lateral.php'; 

  $post_query = "SELECT titulo, mensagem FROM blog_post WHERE id_postagem = ".$_GET['id_post']."";
  $result_post = mysqli_query($conn, $post_query);
  $post = mysqli_fetch_assoc($result_post);

?>
<!--main content start-->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-plus-square"></i> Nova Postagem</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php?pagina=1">Home</a></li>
              <li><i class="fa fa-plus-square"></i>Nova Postagem</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
        <div class="row">                    
          <div class="col-sm-6">
            <a href="nova_publicacao.php?pagina=4" class="publicacao">
              <section class="panel">
                <div class="panel-body-carousel">
                  <img src="img/info_carousel_one.png" alt="" id="caroselOne">
                  <p class="titulo_carrosel">Apenas uma imagem em uma publicação</p>
                </div>            
              </section>                
            </a>
          </div>
          <div class="col-sm-6">  
            <a href="nova_publicacao_carousel.php?pagina=6" class="publicacao">          
              <section class="panel">
                <div class="panel-body-carousel">
                  <img src="img/info_carousel.png" alt="" id="carosel">
                  <p class="titulo_carrosel">Várias imagens em uma publicação</p>
                </div>
              </section>
            </a>
          </div>
        </div>
        <!-- page end-->
      </section>
    </section>
  </section>
  <!-- container section end -->
  <!-- javascripts -->
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <!-- nice scroll -->
  <script src="js/jquery.scrollTo.min.js"></script>
  <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
  <!--custome script for all page-->
  <script src="js/scripts.js"></script>


</body>

</html>
