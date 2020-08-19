<?php   
  //ocultando erros do PHP
   error_reporting(0);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
  <meta name="author" content="GeeksLabs">
  <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
  <link rel="shortcut icon" href="img/favicon.ico">

  <title>Login | BLOG - Grupo Servopa</title>

  <!-- Bootstrap CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- bootstrap theme -->
  <link href="css/bootstrap-theme.css" rel="stylesheet">
  <!--external css-->
  <!-- font icon -->
  <link href="css/elegant-icons-style.css" rel="stylesheet" />
  <link href="css/font-awesome.css" rel="stylesheet" />
  <!-- Custom styles -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet" />

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->

    <!-- =======================================================
      Theme Name: NiceAdmin
      Theme URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
      Author: BootstrapMade
      Author URL: https://bootstrapmade.com
    ======================================================= -->
</head>

<body class="login-img3-body">

  <div class="container">
    <form class="login-form" action="validation.php" method="post">
      <div class="login-wrap">
        <p class="login-img"><img src="img/logo.png"></p>
        <div class="input-group">
          <span class="input-group-addon"><i class="icon_profile"></i></span>
          <input name='login' type="text" class="form-control" placeholder="E-mal" autofocus>
        </div>
        <div class="input-group">
          <span class="input-group-addon"><i class="icon_key_alt"></i></span>
          <input name='senha' type="password" class="form-control" placeholder="Senha">
        </div>
        <?php
          if($_GET['msn'] == 1){
            echo "
            <div class='alert alert-block alert-danger fade in'>
              Usuário não encontrado!
            </div>";
          }
          if($_GET['msn'] == 2){
            echo "
            <div class='alert alert-block alert-danger fade in'>
              Usuário Desativado!<br />
              <span style='font-size:12px'>Entre em contato com o administrador do blog</span>
            </div>";
          }
        ?>
        <label class="checkbox">
          
            <span class="pull-right"> <a href="#myModal-2" data-toggle="modal"> Esqueci minha senha!</a></span>
        </label>
        <button class="btn btn-primary btn-lg btn-block" type="submit">Logar</button>
      </div>
    </form>
    <div class="text-right">
      <div class="credits">
          <!--
            All the links in the footer should remain intact.
            You can delete the links only if you purchased the pro version.
            Licensing information: https://bootstrapmade.com/license/
            Purchase the pro version form: https://bootstrapmade.com/buy/?theme=NiceAdmin
          -->
        </div>
    </div>
  </div>
</body>
<!--MODAL ESQUECI MINHA SENHA-->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal-2" class="modal fade" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h4 class="modal-title">Esqueci minha senha!</h4>
      </div>
      <div class="modal-body">
        <form class="form-inline" role="form">
          <div class="form-group">
            <label class="sr-only" for="exampleInputEmail2">Email address</label>
            <input type="email" class="form-control sm-input aumenta" id="exampleInputEmail5" placeholder="Enter email">
          </div>
          <button type="submit" class="btn btn-success">Enviar</button>
        </form>
      </div>

    </div>
  </div>
</div>

</html>
<!-- javascripts -->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
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
<!-- ck editor -->
<script type="text/javascript" src="assets/ckeditor/ckeditor.js"></script>
<!-- custom form component script for this page-->
<script src="js/form-component.js"></script>
<!-- custome script for all page -->
<script src="js/scripts.js"></script>