<?php
//iniciando as sessões
session_start();
//banco de dados
require 'conexao.php';
//validando usuário
if($_SESSION["id"] == NULL){
  header('location: index.php');
}

//chamando os perfils
$queryPerfil = "SELECT * FROM tv_perfil";
$resultadoPerfil = mysqli_query($conn, $queryPerfil);

//pegando o meu perfil
$meuPerfil = "SELECT * FROM tv_perfil WHERE id = ".$_SESSION["perfil"]."";
$resultadoMeuPerfil = mysqli_query($conn, $meuPerfil);
$rowMeuPerfil = mysqli_fetch_assoc($resultadoMeuPerfil)


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
  <meta name="author" content="GeeksLabs">
  <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
  <link rel="shortcut icon" href="favicon.ico">

  <title>Dashboard - Grupo Servopa</title>
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
        <!--logo start-->
        <a href="dashboard.php?pagina=1" class="logo">TV <span class="lite">Admin</span></a>
        <!--logo end-->
  
        <div class="top-nav notification-row">
          <!-- notificatoin dropdown start-->
          <ul class="nav pull-right top-menu">
            <!-- user login dropdown start-->
            <li class="dropdown">
              <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <span class="username exibicao"><?= $_SESSION['nome'] ?></span>
                <b class="caret"></b>
              </a>
              <ul class="dropdown-menu extended logout">
                <li>
                  <a href="#myModal-1" data-toggle="modal"><i class="icon_profile"></i> Meu Perfil</a>
                </li>
                <?php
                if($_SESSION["perfil"] == 1 || $_SESSION["perfil"] == 2){//administrador OU supervisor
                  echo "<li><a href='list_user.php?pagina=4'><i class='icon_group'></i>Listar usuário</a></li>";
                  echo "<li><a href='new_user.php?pagina=7'><i class='icon_plus'></i>Novo usuário</a></li>";
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
                    <input name="exibicao" type="text" class="form-control" id="inputEmail4" value='<?= $_SESSION['nome']?>'>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail1" class="col-lg-2 control-label">Login</label>
                  <div class="col-lg-10">
                    <input name="nome" type="text" class="form-control menor" id="inputEmail4" value="<?= $_SESSION['usuario']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail1" class="col-lg-2 control-label">Perfil</label>
                  <div class="col-lg-10">                    
                    <select class="form-control menor" name='perfil'>                   
                      <option value="<?=$rowMeuPerfil['id']?>" selected> <?=$rowMeuPerfil['tv_nome']?></option>
                      <option>---</option>
                      <?php 
                        if($_SESSION["perfil"] == 1 OR $_SESSION["perfil"] == 2){
                          while($rowPerfil = mysqli_fetch_assoc($resultadoPerfil)){echo "<option value='".$rowPerfil['id']."'>".$rowPerfil['tv_nome']."</option>";} 
                        }
                      ?>
                    </select>
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
<?php require 'footer.php'; ?>