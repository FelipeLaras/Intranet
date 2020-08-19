<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Blog Servopa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- styles -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,400,600,700" rel="stylesheet">
  <link href="assets/css/bootstrap.css" rel="stylesheet">
  <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
  <link href="assets/css/docs.css" rel="stylesheet">
  <link href="assets/css/prettyPhoto.css" rel="stylesheet">
  <link href="assets/js/google-code-prettify/prettify.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/color/default.css" rel="stylesheet">

  <!-- fav and touch icons -->
  <link rel="shortcut icon" href="assets/ico/favicon.ico">
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">

  <!-- =======================================================
    Theme Name: Serenity
    Theme URL: https://bootstrapmade.com/serenity-bootstrap-corporate-template/
    Author: BootstrapMade.com
    Author URL: https://bootstrapmade.com
  ======================================================= -->
</head>

<body data-spy="scroll" data-target=".bs-docs-sidebar">
  <header>
    <!-- Navbar
    ================================================== -->
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <!-- logo -->
          <a class="brand logo" href="index.php?pagina=1"><img src="assets/img/logo.png"/></a>
          <!-- end logo -->
          <div class="navigation">
            <nav>
              <ul class="nav topnav">
                <li>
                  <?php
                      if($_GET['usuario'] != NULL){
                          echo "<a href='adm/index.php'><i class='icon-user'></i>".$_GET['usuario']."</a>";
                      }else{
                        echo "<a href='adm/index.php'><i class='icon-user'></i>Entrar</a>";
                      }
                  ?>
                </li>
              </ul>
          </div>
        </div>
        
      </div>
    </div>
  </header>
  <!-- Subhead
================================================== -->
  <section id="subintro">
    <div class="jumbotron subhead" id="overview">    
    </div>
  </section>
  <section id="breadcrumb">
    <div class="container">
      <div class="row">
        <div class="span12">
          <ul class="breadcrumb notop">
            <li>
                <i class="icon-home"></i>
                <a href="http://rede.paranapart.com.br">Intranet</a>
                <span class="divider">/</span>
            </li>
            <li>
              <i class="icon-tags"></i>
              <a href="index.php?pagina=1">Blog - Grupo Servopa</a>
              <span class="divider">/</span>
            </li>
            <li class="active">
              <i class="icon-hand-right"></i>
              Postagem
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <?php
//tipo de arquivo
$video = "video/mp4";
$pdf = "application/pdf";

 if($_GET['msn'] == 1){
  echo "<div class='alert alert-success'>
          <button type='button' class='close' data-dismiss='alert'>×</button>
          <strong>Atenção</strong> Comentário adicionado com sucesso!
        </div>";
 }
	//conexão com o bando de dados
	require 'conexao.php';
	//pesquisa para o BD
	$busca = "SELECT 
              BP.id_postagem, 
              BP.titulo, 
              BP.tipo_arquivo,
              BP.file_img AS caminho, 
              BP.mensagem, 
              BP.data,
              BU.exibicao AS usuario,
              BP.carousel
            FROM
              blog_post BP
            LEFT JOIN
              blog_user BU ON BP.id_post_user = BU.id_user
            WHERE
              BP.deletar = 0 AND
              BP.id_postagem = '".$_GET['id_post']."'
            ORDER BY BP.id_postagem DESC";
$resultado = mysqli_query($conn, $busca);

 //contador de comentários
 $comentario =  "SELECT count(*) AS contagem FROM blog_comentarios WHERE id_postagem = '".$_GET['id_post']."'";
 $result = mysqli_query($conn, $comentario); 
 $row_comentario = mysqli_fetch_assoc($result);

?>
  <section id="maincontent">
    <div class="container">
      <div class="row">
        <div class="span8">
          <!-- POSTAGEM -->
           <?php

            if($linha = mysqli_fetch_assoc($resultado)){
              echo "<article class='blog-post'>
              <div class='post-heading'>
                <h3><a href='javascript:'>".$linha['titulo']."</a></h3>
              </div>
              <div class='clearfix'>
              </div>";
              if($linha['tipo_arquivo'] == $video){
                echo "
                <video width='700' controls>
                    <source src='".$linha['caminho']."' type='video/mp4'>
                    <source src='".$linha['caminho']."' type='video/ogg'>
                    Seu navegador não suporta HTML5 video.
                </video>";
              }elseif($linha['tipo_arquivo'] == $pdf){
                echo "<iframe src='".$linha['caminho']."' width='780' height='600'></iframe>";
              }elseif($linha['carousel'] == 1){

                $carrorel = "SELECT file_img FROM blog_post_carousel WHERE id_postagem = ".$linha['id_postagem']."";

                $reCarrosel = mysqli_query($conn, $carrorel);

                echo "<div class='container'>
                <div id='myCarousel' class='carousel slide' data-ride='carousel'>
                  <!-- Wrapper for slides -->
                  <div class='carousel-inner'>";
              
                  $conte = 0;
              
                  while($row_carrosel = mysqli_fetch_assoc($reCarrosel)){
              
                  switch ($conte) {
                    case '0':
                      echo "<div class='item active'><img src='../blog/".$row_carrosel['file_img']."'></div>";
                    break;
                                         
                    default:
                      echo "<div class='item'><img src='../blog/".$row_carrosel['file_img']."'></div>";
                  }
                  $conte++;    
                }
              
              echo "
                  </div>
              
                  <!-- Left and right controls -->
                  <a class='left carousel-control' href='#myCarousel' data-slide='prev'><
                  </a>
                  <a class='right carousel-control' href='#myCarousel' data-slide='next'>>
                  </a>
                </div>
              </div>";

              }else{
                echo "<img src='".$linha['caminho']."' style='width: 100%' />";
              }           
              echo "<ul class='post-meta'>
                <li class='first'><i class='icon-calendar'></i><span>".$linha['data']."</span></li>
                <li><i class='icon-list-alt'></i><span><a href='javascript:'>".$row_comentario['contagem']." comentários</a></span></li>
                <li class='last'><i class='icon-tags'></i><span><a href='javascript'>".$linha['usuario']."</a></span></li>
              </ul>
              <p>".$linha['mensagem']."</p>
            </article>
            <!-- end article full post -->";
            }
           

           ?>
          <h4><i class='icon-flag'></i> Comentários</h4>
          <ul class="media-list postagem">
            <?php
            $id = 0;
              //coletando os comentários
              $comentario_text = "SELECT 
                                      BC.nome,
                                      BC.data,
                                      BC.comentario,
                                      BC.id_postagem,
                                      BD.nome AS departamento,
                                      BE.nome AS empresa
                                  FROM
                                      blog_comentarios BC
                                          LEFT JOIN
                                      blog_departamento BD ON BC.departamento = BD.id_departamento
                                          LEFT JOIN
                                      blog_empresa BE ON BC.empresa = BE.id_empresa
                                  WHERE
                                      BC.id_postagem = '".$_GET['id_post']."' order by BC.id_comentario DESC ";

              $resultado_text = mysqli_query($conn, $comentario_text);

              while($linha_text = mysqli_fetch_assoc($resultado_text)){                
                echo "
                    <li class='media'>
                      <div class='media-body'>
                        <h5 class='media-heading'>
                          <a href='javascript:'>
                            <i class='icon-user'></i>".$linha_text['nome']."
                          </a>
                          <b style='font-size: 10px'>".$linha_text['departamento']." - ".$linha_text['empresa']."</b>
                        </h5>                          
                        <span>".$linha_text['data']."</span>
                        <p>
                          ".$linha_text['comentario']."
                        </p>
                      </div>
                    </li> 
                    ";
                    $id++;
              }//fim while 
            ?>            
          </ul>

          <hr />
          <div class="comment-post">
            <h4>Insira o seu comentário</h4>
            <form action="salvar_comentario.php" method="post" class="comment-form" name="comment-form">
              <input name="id_postagem" value="<?php echo $_GET['id_post'] ?>" style="display:none;" />
              <div class="row">
                <div class="span6">
                  <label>Nome</label>
                  <input type="text" class="input-block-level" placeholder="Seu nome" name="nome"/>
                </div>
                <div class="span3">
                  <label>Departamento</label>
                  <select name="departamento">
                    <option value="">Selecione...</option>
                    <?php
                      $departamento = "SELECT * FROM blog_departamento ORDER BY nome ASC";
                      $resultado_departamento = mysqli_query($conn, $departamento);
                      while($row_depart = mysqli_fetch_assoc($resultado_departamento)){
                        echo "<option value='".$row_depart["id_departamento"]."'>".$row_depart["nome"]."</option>";
                      }
                    ?>                    
                  </select>
                </div>
                <div class="span3">
                  <label>Filial</label>
                  <select name="empresa">
                    <option value="">Selecione...</option>
                    <?php
                      $empresa = "SELECT * FROM blog_empresa ORDER BY nome ASC";
                      $resultado_empresa = mysqli_query($conn, $empresa);
                      while($row_empresa = mysqli_fetch_assoc($resultado_empresa)){
                        echo "<option value='".$row_empresa["id_empresa"]."'>".$row_empresa["nome"]."</option>";
                      }
                    ?>     
                  </select>
                </div>
                <div class="span8">
                  <label>Comentário <span>*</span></label>
                  <textarea rows="9" class="input-block-level" placeholder="Seu comentário" name="comentario" required></textarea>
                  <button class="btn btn-small btn-success" type="submit">Salvar comentário</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="span4">
          <aside>
            <div class="widget">
              <form class="form-search" method="post" action="pesquisa.php">
                <input placeholder="Digite algo" type="text" class="input-medium search-query" name="pesquisar">
                <button type="submit" class="btn btn-flat btn-color">Procurar</button>
              </form>
            </div>
            <div class="widget">
              <h4>Departamentos</h4>
              <ul class="cat">
                <li><a href="https://sites.google.com/a/servopa.com.br/rh/home">Recursos Humanos</a></li>
                <li><a href="https://sites.google.com/a/servopa.com.br/auditoria/">Auditoria</a></li>
                <li><a href="http://rede.paranapart.com.br/ti/index.html">TI</a></li>
                <li><a href="https://sites.google.com/servopa.com.br/gestaocompartilhada/gest%C3%A3o-compartilhada">Gestão Compartilhada</a></li>
              </ul>
            </div>
            <div class="widget">
              <h4>Postagens Recentes</h4>
              <ul class="recent-posts">
                <?php
                  $post_recent = "SELECT 
                                    id_postagem,
                                    titulo,
                                    data 
                                  FROM  
                                    blog_post BP 
                                  WHERE 
                                    BP.deletar = 0 ORDER BY id_postagem DESC Limit 6";
                  $result_recent = mysqli_query($conn, $post_recent);

                  while($linha = mysqli_fetch_assoc($result_recent)){

                     //contador de comentários
                    $comentario_recent =  "SELECT count(*) AS contagem FROM blog_comentarios WHERE id_postagem = '".$linha['id_postagem']."'";
                    $result_recente = mysqli_query($conn, $comentario_recent); 
                    $linha_comentario = mysqli_fetch_assoc($result_recente);
                    
                    echo "                  
                          <li><a href='postagem.php?id_post=".$linha['id_postagem']."'>".$linha['titulo']."</a>
                          <div class='clear'>
                          </div>
                          <span class='date'><i class='icon-calendar'></i>".$linha['data']."</span>
                          <span class='comment'><i class='icon-comment'></i> ".$linha_comentario['contagem']." Comentários</span>
                        </li>
                    ";
                  }
                ?>
              </ul>
            </div>
          </aside>
        </div>
      </div>
    </div>
  </section>
  <!-- Footer
 ================================================== -->
 <footer class="footer">
    <div class="verybottom">
      <div class="container">
        <div class="row">
          <div class="span6">
            <p>
              &copy; Departamento T.I - Todos os direitos reservados
            </p>
          </div>
          <div class="span6">
            <div class="credits">
              <!--
                All the links in the footer should remain intact.
                You can delete the links only if you purchased the pro version.
                Licensing information: https://bootstrapmade.com/license/
                Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=Serenity
              -->
              Desenvolvido por <a href="javascript:">Felipe Lara</a> - Ramal: 110-2151
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- JavaScript Library Files -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/jquery.easing.js"></script>
  <script src="assets/js/google-code-prettify/prettify.js"></script>
  <script src="assets/js/modernizr.js"></script>
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/jquery.elastislide.js"></script>
  <script src="assets/js/sequence/sequence.jquery-min.js"></script>
  <script src="assets/js/sequence/setting.js"></script>
  <script src="assets/js/jquery.prettyPhoto.js"></script>
  <script src="assets/js/application.js"></script>
  <script src="assets/js/jquery.flexslider.js"></script>
  <script src="assets/js/hover/jquery-hover-effect.js"></script>
  <script src="assets/js/hover/setting.js"></script>

  <!-- Template Custom JavaScript File -->
  <script src="assets/js/custom.js"></script>


</body>

</html>
