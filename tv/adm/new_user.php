<?php
//validando
if ($_GET['pagina'] != 7) {
  header('location: 404.php');
}
require 'header.php';

require 'menu_lateral.php';

//chamando os perfils
$queryPerfil = "SELECT * FROM tv_perfil";
$resultadoPerfil = mysqli_query($conn, $queryPerfil);

//selecionando todas as concessionarias
$queryConcessionaria = "SELECT * FROM tv_concessionarias WHERE tv_desativarFilial = '0'";
$resultadoConcessionaria = mysqli_query($conn, $queryConcessionaria);

?>

<!--main content start-->
<section id="main-content">
  <section class="wrapper">
    <div class="row">
      <div class="col-lg-12">
        <h3 class="page-header"><i class='fas fa-plus'></i> Criando Usuário</h3>
        <ol class="breadcrumb">
          <li><i class="fa fa-home"></i><a href="dashboard.php?pagina=1">Dashboard</a></li>
          <li><i class="icon_group"></i><a href="list_user.php?pagina=4">Lista usuários</a></li>
          <li><i class='fas fa-plus'></i>Novo Usuário</li>
        </ol>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6" style="width: 86%;">
        <section class="panel">
          <div class="panel-body">
            <form role="form" method="POST" action="insert_user.php">              
            <div class="form-group">
                <label for="exibicao">Nome: </label>
                <input name="exibicao" type="text" class="form-control" style="width: 40%;" id="exibicao" value="">
              </div>
              <div class="form-group">
                <label for="nome">Login: </label>
                <input name="nome" type="text" class="form-control" style="width: 40%;" id="login" value="">
              </div>              
              <div class="form-group">
                <label for="senha_atual">Senha: </label>
                <input name="senha_atual" type="password" class="form-control" style="width: 30%;" id="senha_atual">
              </div>
              <div class="form-group menor">
                <label for="nome">Perfil: </label>
                <select class="form-control" name='perfil' style="width: 40%;" required>
                  <option value="" selected>---</option>
                  <?php
                    while($rowPerfil = mysqli_fetch_assoc($resultadoPerfil)){echo "<option value='".$rowPerfil['id']."'>".$rowPerfil['tv_nome']."</option>";}
                  ?>
                </select>
              </div>              
              <div class="form-group" style="margin-left: -13px;">
                    <label class="control-label col-lg-2" for="inputSuccess">Filiais:</label>
                    <div class="col-lg-5">
                        <ul class="list-group list-group-flush">                                        
                            <?php
                                $id = "a";

                                while($rowConcessionaria = mysqli_fetch_assoc($resultadoConcessionaria)){

                                  //selecionando todas as filiais
                                  $queryFiliais = "SELECT * FROM tv_filiais WHERE tv_desativarFilial = '0' AND tv_concessionaria = ".$rowConcessionaria['id']."";
                                  $resultadoFiliais = mysqli_query($conn, $queryFiliais);

                                    echo '
                                        <li class="concessionaria">
                                          <div class="checkbox">
                                            <label class="blue">              
                                              <input name="concessionaria[]" value="'.$rowConcessionaria['id'].'" type="checkbox" class="btn btn-sm btn-2 glyphicon" data-toggle="collapse" data-target="#'.$id.'">                                                            
                                              '.$rowConcessionaria['tv_nomeFilial'].'
                                            </label>
                                          </div>
                                            <div id="'.$id.'" class="collapse filial">';

                                            while($rowFilial = mysqli_fetch_assoc($resultadoFiliais)){
                                              echo '
                                              <div class="checkbox left">
                                                  <label>
                                                    <input name="filial'.$id.'[]" type="checkbox" value="'.$rowFilial['id'].'">'.$rowFilial['tv_nomeFilial'].'
                                                  </label>
                                              </div>';
                                            }
                                    echo '            
                                            </div>
                                        </li>
                                    ';

                                    $id++;
                                }
                            ?>
                            
                        </ul>
                    </div>
                </div>
              <div class="form-group">
                <div class="col-sm-10" style="margin-top: 20px; margin-left: -16px;">
                  <button type="submit" class="btn btn-primary">Salvar</button>
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
  $('input[name="arquivo"]').change(function() {
    if ($('input[name="arquivo"]:checked').val() === "0") {
      $('#file').show();
    } else {
      $('#file').hide();
    }
  })
</script>

<!--TEXTAREA EDIÇÃO-->
<script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script>
<script type="text/javascript">
  //<![CDATA[
  bkLib.onDomLoaded(function() {
    nicEditors.allTextAreas()
  });
  //]]>
</script>
</body>

</html>