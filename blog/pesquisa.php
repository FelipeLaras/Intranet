<?php   //ocultando erros do PHP
   error_reporting(0);
   ini_set(“display_errors”, 0 );
?>
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
              <i class="icon-search"></i>
              Resultado da pesquisa
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <section id="maincontent">
    <div class="container">
      <div class="row">
        <div class="span8">

        <?php
	//conexão com o bando de dados
	require 'conexao.php';
	//pesquisa para o BD
	$busca = "SELECT 
              id_postagem, 
              titulo, 
              tipo_arquivo,
              file_img AS caminho, 
              mensagem, 
              data,
              BU.exibicao AS usuario
            FROM
              blog_post BP
            LEFT JOIN
              blog_user BU ON BP.id_post_user = BU.id_user
            WHERE
              BP.deletar = 0 AND
              BP.titulo like '%".$_POST['pesquisar']."%'
            ORDER BY id_postagem DESC";
	//Total por pagina
    $total_reg = "3"; // número de registros por página
    //tipo de arquivo de video
    $tipo = 'video/mp4';

    //evita de exibir a página 0 de início	
	$pagina = $_GET['pagina'];
	
	if ($pagina == NULL) {
	$pc = "1";
	} else {
	$pc = $pagina;
	}	

	//valor inicial das buscas limitadas:
	$inicio = $pc - 1;
	$inicio = $inicio * $total_reg;

	//Execução da pesquisa no BD
  $limite = mysqli_query($conn, "$busca LIMIT $inicio, $total_reg");

	$todos = mysqli_query($conn, $busca);
	 
	$tr = mysqli_num_rows($todos); // verifica o número total de registros
	$tp = $tr / $total_reg; // verifica o número total de páginas
	 
	// vamos criar as postagens
	while ($dados = mysqli_fetch_array($limite)) {

    //contador de comentários
    $comentario =  "SELECT count(*) AS contagem FROM blog_comentarios WHERE id_postagem = '".$dados['id_postagem']."'";
    $result = mysqli_query($conn, $comentario); 
    $row_comentario = mysqli_fetch_assoc($result);

    if($dados['mensagem'] != NULL){
      echo "<article class='blog-post'>
              <div class='post-heading'><!--titulo-->
                <h3><a href='postagem.php?id_post=".$dados['id_postagem']."'>".$dados['titulo']."</a></h3>
              </div><!--fim titulo-->
              <div class='row'><!--corpo-->
                  <div class='span3'><!--imagem-->
                    <div class='post-image'>
                      <a href='postagem.php?id_post=".$dados['id_postagem']."'>";
                        if($dados['tipo_arquivo'] == $tipo){
                          echo "
                              <video width='295' controls>
                                  <source src='".$dados['caminho']."' type='video/mp4'>
                                  <source src='".$dados['caminho']."' type='video/ogg'>
                                  Seu navegador não suporta HTML5 video.
                              </video>";
                        }else{
                          echo "<img src='".$dados['caminho']."' style='width: 100%;'/>";
                        }
        echo"
                      </a>
                    </div>
                  </div><!--Fim imagem-->

                  <div class='span5'>
                  <ul class='post-meta'>
                    <li class='first'><i class='icon-calendar'></i><span>".$dados['data']."</span></li>
                    <li><i class='icon-list-alt'></i><span><a href='postagem.php?id_post=".$dados['id_postagem']."' title='Adicione um comentário'>".$row_comentario['contagem']." comentários</a></span></li>
                    <li class= 'last'><i class='icon-tags'></i><span><a href='postagem.php?id_post=".$dados['id_postagem']."'>".$dados['usuario']."</a></span></li>
                  </ul>
                  <div class='clearfix'>
                  </div>
                  <p>
                    ".$dados['mensagem']."
                  </p>
                </div>

              </div><!--fim corpo-->
            </article>";
    }else{

      echo "<article class='blog-post'>
              <div class='post-heading'>
                <h3><a href='postagem.php?id_post=".$dados['id_postagem']."'>".$dados['titulo']."</a></h3>
              </div>";
              if($dados['tipo_arquivo'] == $tipo){
                echo "
                    <video width='560' controls>
                        <source src='".$dados['caminho']."' type='video/mp4'>
                        <source src='".$dados['caminho']."' type='video/ogg'>
                        Seu navegador não suporta HTML5 video.
                    </video>";
              }else{
                echo "<a href='postagem.php?id_post=".$dados['id_postagem']."'><img src='".$dados['caminho']."' style='width: 100%;'/></a>";
              }
      echo"
              <ul class='post-meta'>
                <li class='first'><i class='icon-calendar'></i><span>".$dados['data']."</span></li>
                <li><i class='icon-list-alt'></i><span><a href='postagem.php?id_post=".$dados['id_postagem']."' title='Adicione um comentário'>".$row_comentario['contagem']." comentários</a></span></li>
                <li class= 'last'><i class='icon-tags'></i><span><a href='postagem.php?id_post=".$dados['id_postagem']."'>".$dados['usuario']."</a></span></li>
              </ul>
            </article>";

    }//Fim IF postagem

      

  }//Fim While postagem
  ?>
          <!--PAGINAÇÃO-->
          <div class="pagination">
          <?php
              // agora vamos criar os botões "Anterior e próximo"
              $anterior = $pc -1;
              $proximo = $pc +1;
              if ($pc>1) {
                echo " <div><a href='?pagina=$anterior' class='paginacao'>Postagens mais novas</a></div>";

                echo " <div style='float: right; margin-top: -21px;'>
                          <a href='?pagina=$proximo' class='paginacao'>Postagens mais antigas</a>
                        </div> ";

              }elseif($pc<$tp){
                echo " <div style='float: right;'>
                          <a href='?pagina=$proximo' class='paginacao'>Postagens mais antigas</a>
                        </div> ";
              } 
            ?>
            </ul>
          </div>
        </div>
        <div class="span4">
          <aside>
            <div class="widget">
              <form class="form-search">
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
                    $comentario =  "SELECT count(*) AS contagem FROM blog_comentarios WHERE id_postagem = '".$dados['id_postagem']."'";
                    $result = mysqli_query($conn, $comentario); 
                    $row_comentario = mysqli_fetch_assoc($result);

                    echo "                  
                          <li><a href='postagem.php?id_post=".$linha['id_postagem']."'>".$linha['titulo']."</a>
                          <div class='clear'>
                          </div>
                          <span class='date'><i class='icon-calendar'></i>".$linha['data']."</span>
                          <span class='comment'><i class='icon-comment'></i> ".$row_comentario['contagem']." Comentários</span>
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
              Projetado por <a href="javascript:">Felipe Lara</a> - Ramal: 110-2151
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

<?php mysqli_close($conn);?>