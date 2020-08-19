<!DOCTYPE html>
<?php 
  //validando
  if($_GET['pagina'] != 7){
    header('location: 404.php');
  }
  require 'header.php';

  require 'menu_lateral.php'; 

  $post_query = "SELECT titulo, mensagem FROM blog_post WHERE id_postagem = ".$_GET['id_post']."";
  $result_post = mysqli_query($conn, $post_query);
  $post = mysqli_fetch_assoc($result_post);

?>
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header"><i class="fas fa-plus-square"></i>Nova postagem</h3>
                <ol class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="dashboard.php?pagina=1">Home</a></li>
                    <li><i class="fa fa-plus-square"></i>Nova Postagem</li>
                </ol>
                <p>Apenas uma imagem:</p>
            </div>
        </div>
        <!-- page start-->
        <div class="row">
            <div class="col-lg-6" style="width: 86%;">
                <section class="panel">
                    <div class="panel-body">
                        <form class="form-validate form-horizontal" id="feedback_form" method="POST"
                            action="salvar_postagem.php?pagina=5" enctype="multipart/form-data" autocomplete="off">
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-2">Titulo:</label>
                                <div class="col-lg-10">
                                    <input class="form-control" id="cname" name="titulo" maxlength="40" type="text" required>
                                    <span class="help-block">Limite de 40 caracteres</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="agree" class="control-label col-lg-2 col-sm-3">Tipo da postagem:</label>
                                <div class="col-lg-10 col-sm-9">
                                    <input class="form-check-input" type="radio" id="tipoPostagem1" value="0"
                                        name="tipo_postagem" checked="">
                                    <span class="form-check-label" for="tipoPostagem1">
                                        Simples                                          
                                    </span>
                                </div>
                                <div class="col-lg-10 col-sm-9">
                                    <input class="form-check-input" type="radio" id="tipoPostagem2" value="1"
                                        name="tipo_postagem">
                                    <span class="form-check-label" for="tipoPostagem2">
                                        Modal
                                        <a href="javascript:">
                                            <i class="fas fa-question-circle menor"
                                                title="Quando abrir a intranet a postagem ficará na tela principal, ideal para postagem importantes."
                                                aria-hidden="true"></i>
                                        </a>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="agree" class="control-label col-lg-2 col-sm-3">Data fim de
                                    visibiliade?</label>
                                <select class="form-control m-bot15 fimDate" id="dataFim" required>
                                    <option value="">Selecione...</option>
                                    <option value="0">Sim</option>
                                    <option value="1">Não</option>
                                </select>

                            </div>
                            <div class="form-group" style="display: none;" id="dataDiv">
                                <label for="agree" class="control-label col-lg-2 col-sm-3">Inativar postagem:</label>
                                <input type="text" class="form-control col-4 inativarDate" id="dataInput"
                                    placeholder="DD / MM / AAAA" name="dataFim">
                            </div>
                            <div class="form-group">
                              <label for="agree" class="control-label col-lg-2 col-sm-3" style="width: 17%;">Alerta comentários? 
                                <a href="javascript:">
                                    <i class="fas fa-question-circle menor"
                                        title="Todo comentário referente a está postagem você receberá por e-mail !"
                                        aria-hidden="true"></i>
                                </a>
                              </label>
                              <select class="form-control m-bot15 fimDate" id="dataFim" name='alertar_comentario' required>
                                  <option value="">Selecione...</option>
                                  <option value="1">Sim</option>
                                  <option value="0">Não</option>
                              </select>
                            </div>
                            <div class="form-group">
                                <label for="agree" class="control-label col-lg-2 col-sm-3">Imagem / Video:</label>
                                <input type="file" class="form-control-file" id="file" name="file">
                            </div>
                            <!-- CKEditor -->
                            <div class="form-group">
                              <div class="col-sm-10">
                                <label for="agree" class="control-label col-lg-2 col-sm-3">Mensagem:</label>
                                <div id='texto'>
                                  <textarea name="mensagem" style="width: 100%;"></textarea>
                                </div>
                              </div>
                            </div>
                            <button type="submit" class="btn btn-primary postar">Realizar a Postagem</button>
                        </form>
                    </div>
                </section>
            </div>
        </div>
        <!-- page end-->
    </section>
</section>
<!-- container section end -->
<!--MOSTRAR / ESCONDER-->
<!--jquery para funciionario o mostrar e econder-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
<!--MOSTRAR E ESCONDER-->
<script>
$("#dataFim").change(

    function() {
        $('#dataDiv').hide();

        if (this.value == "0") {
            $('#dataDiv').show();
        }

    }

);
</script>

<!--TEXTAREA EDIÇÃO-->
<script src="https://cdn.tiny.cloud/1/dqzhgrnm6i4pdh6dtzylwat5bntthf86t9852obx0fvy58ei/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>tinymce.init({selector:'textarea'});</script>
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