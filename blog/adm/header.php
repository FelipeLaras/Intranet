<?php
//ocultando erros do PHP
error_reporting(0);
//iniciando as sessões
session_start();
//banco de dados
require 'conexao.php';
//validando usuário
if($_SESSION["id"] == NULL){
  header('location: index.php');
}

/* --------------- CONTADOR DE COMENTÁRIOS --------------- */

$query_contador = "SELECT  COUNT(id_postagem) AS contagem FROM blog_comentarios WHERE avisado_responsavel = 0 AND  id_postagem IN (SELECT id_postagem FROM blog_post WHERE id_post_user = ".$_SESSION['id'].") ORDER BY id_postagem DESC";
$result_contador = mysqli_query($conn, $query_contador);
$contador = mysqli_fetch_assoc($result_contador);


?>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
  <meta name="author" content="GeeksLabs">
  <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
  <link rel="shortcut icon" href="favicon.ico">

  <title>Dashboard - BLOG</title>
  <!--FAVICON 5-->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <!--FAVICON 5 END-->

  <!-- Bootstrap CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- bootstrap theme -->
  <link href="css/bootstrap-theme.css" rel="stylesheet">
  <!--external css-->
  <!-- font icon -->
  <link href="css/elegant-icons-style.css" rel="stylesheet" />
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <!-- full calendar css-->
  <link href="assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
  <link href="assets/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" />
  <!-- easy pie chart-->
  <link href="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen" />
  <!-- owl carousel -->
  <link rel="stylesheet" href="css/owl.carousel.css" type="text/css">
  <link href="css/jquery-jvectormap-1.2.2.css" rel="stylesheet">
  <!-- Custom styles -->
  <link rel="stylesheet" href="css/fullcalendar.css">
  <link href="css/widgets.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet" />
  <link href="css/xcharts.min.css" rel=" stylesheet">
  <link href="css/jquery-ui-1.10.4.min.css" rel="stylesheet">
  <!-- =======================================================
    Theme Name: NiceAdmin
    Theme URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
    Author: BootstrapMade
    Author URL: https://bootstrapmade.com
  ======================================================= -->
</head>

<body>
    <!-- container section start -->
    <section id="container" class="">
      <header class="header dark-bg">
        <div class="toggle-nav">
          <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
        </div>
        <!--logo start-->
        <a href="dashboard.php?pagina=1" class="logo">Blog <span class="lite">Admin</span></a>
        <!--logo end-->
  
        <div class="top-nav notification-row">
          <!-- notificatoin dropdown start-->
          <ul class="nav pull-right top-menu">
            <!-- inbox notificatoin start-->
            <li id="mail_notificatoin_bar" class="dropdown">
              <a href="postagens.php?pagina=2" class="dropdown-toggle" title="Comentários em suas postagens">
                  <i class="icon-envelope-l"></i>
                  <span class="badge bg-important"><?php if($contador['contagem'] != 0){ echo $contador['contagem'];}?></span>
              </a>
            </li>
            <!-- inbox notificatoin end -->
            <!-- user login dropdown start-->
            <li class="dropdown">
              <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <span class="username exibicao"><?= $_SESSION['exibicao'] ?></span>
                <b class="caret"></b>
              </a>
              <ul class="dropdown-menu extended logout">
                <li>
                  <a href="#myModal-1" data-toggle="modal"><i class="icon_profile"></i> Meu Perfil</a>
                </li>
                <?php
                if($_SESSION["id"] == 8){
                  echo "<li><a href='list_user.php?pagina=4'><i class='icon_group'></i>Usuários</a></li>";
                }
                ?>
                <li class="eborder-top">
                  <a href="unset.php"><i class="icon_key_alt"></i> Sair</a>
                </li>
              </ul>
            </li>
            <!-- user login dropdown end -->
          </ul>
          <!-- notificatoin dropdown end-->
        </div>
      </header>
      <!--header end-->
      <!--MODAL-->
      <div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal-1" class="modal fade in" style="display: none;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
              <h4 class="modal-title">Editando Perfil</h4>
            </div>
            <div class="modal-body">

              <form class="form-horizontal" role="form" method="POST" action="editando_user.php">
                <input name="senha_atual" style="display: none;" value='<?= $_SESSION['senha']?>'>
                <div class="form-group">
                  <label for="inputEmail1" class="col-lg-2 control-label">Nome</label>
                  <div class="col-lg-10">
                    <input name="exibicao" type="text" class="form-control" id="inputEmail4" value='<?= $_SESSION['exibicao']?>'>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail1" class="col-lg-2 control-label">E-mail</label>
                  <div class="col-lg-10">
                    <input name="email" type="email" class="form-control" id="inputEmail4" value="<?= $_SESSION['email']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail1" class="col-lg-2 control-label">Login</label>
                  <div class="col-lg-10">
                    <input name="nome" type="text" class="form-control menor" id="inputEmail4" value="<?= $_SESSION['nome']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword1" class="col-lg-2 control-label">Senha</label>
                  <div class="col-lg-10">
                    <input type="password" class="form-control menor" placeholder="Senha" id="password">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword1" class="col-lg-2 control-label">Redigite</label>
                  <div class="col-lg-10">
                    <input name="senha" type="password" class="form-control menor" placeholder="Confirme Senha" id="confirm_password">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">
                    <button type="submit" class="btn btn-info" style="float: right;">Editar</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
<!--FIM MODAL-->

      <!--VALIDANDO SENHAS--->
      <script>
        var password = document.getElementById("password")
            , confirm_password = document.getElementById("confirm_password");

          function validatePassword(){
            if(password.value != confirm_password.value) {
              confirm_password.setCustomValidity("Senhas diferentes!");
            } else {
              confirm_password.setCustomValidity('');
            }
          }

          password.onchange = validatePassword;
          confirm_password.onkeyup = validatePassword;
      </script>

      <!-- nice scroll -->
      <script src="js/jquery.scrollTo.min.js"></script>
      <script src="js/jquery.nicescroll.js" type="text/javascript"></script>

      <!-- jquery ui -->
      <script src="js/jquery-ui-1.9.2.custom.min.js"></script>

      <!--custom checkbox & radio-->
      <script type="text/javascript" src="js/ga.js"></script>
      <!--custom switch-->
      <script src="js/bootstrap-switch.js"></script>
      <!--custom tagsinput-->
      <script src="js/jquery.tagsinput.js"></script>

      <!-- colorpicker -->

      <!-- bootstrap-wysiwyg -->
      <script src="js/jquery.hotkeys.js"></script>
      <script src="js/bootstrap-wysiwyg.js"></script>
      <script src="js/bootstrap-wysiwyg-custom.js"></script>
      <script src="js/moment.js"></script>
      <script src="js/bootstrap-colorpicker.js"></script>
      <script src="js/daterangepicker.js"></script>
      <script src="js/bootstrap-datepicker.js"></script>
      <!-- custom form component script for this page-->
      <script src="js/form-component.js"></script>
      <!-- custome script for all page -->
      <script src="js/scripts.js"></script>
