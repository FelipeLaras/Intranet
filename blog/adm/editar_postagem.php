<!DOCTYPE html>
<?php 
  //validando
  if($_GET['pagina'] != 3){
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
            <h3 class="page-header"><i class='fas fa-edit'></i> Postagem sendo editada</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php?pagina=1">Minhas postagens</a></li>
              <li><i class='fas fa-edit'></i>Editando</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6" style="width: 86%;">
            <section class="panel">
              <div class="panel-body">
                <form role="form" method="POST" action="editar.php" enctype="multipart/form-data">
                  <input name="id_post" value="<?=$_GET['id_post']?>" style="display: none;" />
                  <div class="form-group">
                    <label for="exampleInputEmail1">Titulo: </label>
                    <input name="titulo" type="text" class="form-control" style="width: 81%;" id="exampleInputEmail1" value="<?= $post['titulo'] ?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Deseja usar a mesma imagem / video ?</label><br />                    
                    <label class="label_radio r_on" for="radio-01">
                        <input name="arquivo" id="radio-01" value="1" type="radio" checked> Sim
                    </label>
                    <label class="label_radio r_on" for="radio-02">
                        <input name="arquivo" id="radio-02" value="0" type="radio" style="margin-left: 10px;"> Não
                    </label>
                  </div>
                  <div class="form-group" style="display: none;" id='file'>
                    <label for="exampleInputFile">Anexar um arquivo</label>
                    <input name="file" type="file" id="exampleInputFile">
                  </div>
                  <!-- CKEditor -->
                  <div class="form-group">
                    <div class="col-sm-10">
                      <label for="exampleInputEmail1">Mensagem: </label>
                      <textarea name="mensagem" style="width: 100%;"><?= $post['mensagem'] ?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-10" style="margin-top: 20px; margin-left: -16px;">
                      <button type="submit" class="btn btn-primary">Editar</button>
                    </div>
                  </div>                  
                </form>
              </div>
            </section>
          </div>
        </div>
        <!-- page end-->
      </section>
    </section>
  </section>
  <!--MOSTRAR / ESCONDER-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
  <script>
    $('input[name="arquivo"]').change(function () {
      if ($('input[name="arquivo"]:checked').val() === "0") {
          $('#file').show();
      } else {
          $('#file').hide();
      }
    })
  </script>

  <!--TEXTAREA EDIÇÃO-->
  <script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script> <script type="text/javascript">
//<![CDATA[
        bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
  //]]>
  </script>
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
  <!-- bootstrap-wysiwyg -->
  <script src="js/jquery.hotkeys.js"></script>
  <script src="js/bootstrap-wysiwyg.js"></script>
  <script src="js/bootstrap-wysiwyg-custom.js"></script>
  <script src="js/moment.js"></script>
  <script src="js/bootstrap-colorpicker.js"></script>
  <script src="js/daterangepicker.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
</body>
</html>
