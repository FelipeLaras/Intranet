<!DOCTYPE html>
<?php 

//validando
if($_GET['pagina'] != 2){
  header('location: 404.php');
}

require 'header.php';

require 'menu_lateral.php';

//coletando os comentarios em geral 
$query_comentario = "SELECT 
                        COUNT(BC.id_postagem) AS contagem, BC.id_postagem, BP.titulo, BP.data
                    FROM
                        blog_post BP
                    INNER JOIN
                        blog_comentarios BC ON BP.id_postagem = BC.id_postagem
                    WHERE 
                        BC.avisado_responsavel = 0 AND 
                        BP.id_post_user = ".$_SESSION['id']."
                        GROUP  BY BC.id_postagem;";
$result_comentario = mysqli_query($conn, $query_comentario);
?>
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header"><i class="far fa-comments"></i> Comentários</h3>
                <ol class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="dashboard.php?pagina=1">Home</a></li>
                    <li><i class="fa fa-comments"></i>Comentários</li>
                </ol>
            </div>
        </div>
        <?php

        $add = 0;

        while($comentario_geral = mysqli_fetch_assoc($result_comentario)){
        echo "        
        <!-- page start-->
        <div class='panel-group m-bot20' id='accordion'>
            <div class='panel panel-default'>
                <div class='panel-heading'>
                    <h4 class='panel-title'>
                        <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion' href='#collapse".$add."'>
                            ".$comentario_geral['titulo']." - <span class='contagem'>".$comentario_geral['contagem']." comentários não resolvidos</span>
                        </a>
                    </h4>
                </div>
                <div id='collapse".$add."' class='panel-collapse collapse in' style='height: 0px;'>
                    <div class='panel-body'>";                        
                        $query_detalhesComentario = "SELECT 
                                                        BC.id_comentario,
                                                        BC.id_postagem,
                                                        BC.nome AS colaborador,
                                                        BE.nome AS empresa,
                                                        BD.nome AS departamento,
                                                        BC.comentario,
                                                        BC.data,
                                                        BP.titulo
                                                    FROM
                                                        blog_comentarios BC
                                                    LEFT JOIN
                                                        blog_empresa BE ON BC.empresa = BE.id_empresa
                                                    LEFT JOIN
                                                        blog_departamento BD ON BC.departamento = BD.id_departamento
                                                    LEFT JOIN
                                                        blog_post BP ON BC.id_postagem = BP.id_postagem
                                                    WHERE 
                                                        BC.avisado_responsavel = 0 AND 
                                                        BC.id_postagem = ".$comentario_geral['id_postagem']." ORDER BY BC.id_comentario DESC";
                        $resultado = mysqli_query($conn, $query_detalhesComentario);

                        while($comentario = mysqli_fetch_assoc($resultado)){
                            echo "<div class='panel panel-info'>
                            <div class='panel-heading'>
                                <span class='colaborador'>".$comentario['colaborador']."</span> <span class='departamento'>".$comentario['departamento']." - ".$comentario['empresa']."</span>
                                <span class='acao'>
                                    <a href='../postagem.php?id_post=".$comentario['id_postagem']."#comentarioTag' class='acaoComentario' title='Ver comentário na postagem'>
                                        <i class='fas fa-eye'></i>
                                    </a>  
                                    <a href='alter_comentario.php?avisa=".$comentario['id_comentario']."' class='acaoComentario' title='Não quero ver mais esse comentário'>
                                        <i class='far fa-window-close'></i>
                                    </a>                                      
                                </span>
                            </div>
                            <div class='panel-content'>".$comentario['comentario']."</div>
                        </div>";
                        }
                    echo "    
                    </div>
                </div>                
            </div>
        </div>
        <!-- page end-->"; 

        $add++;
    } 
        ?>
   
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