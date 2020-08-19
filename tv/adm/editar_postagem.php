<?php 
  //validando
  if($_GET['pagina'] != 3){
    header('location: 404.php');
  }
  require 'header.php';

  require 'menu_lateral.php'; 

  $post_query = "SELECT * FROM tv_postagem WHERE id = ".$_GET['id_post']."";
  $result_post = mysqli_query($conn, $post_query);
  $post = mysqli_fetch_assoc($result_post);


  //SELECIONADO AS FILIAIS QUE JÁ TENHO
  $queryFiliaisMeus = "SELECT TP.tv_filial, TF.tv_nomeFilial FROM tv_postagem TP LEFT JOIN tv_filiais TF ON TP.tv_filial = TF.id  WHERE TP.id = ".$_GET['id_post']."";
  $resultFiliaisMeus = mysqli_query($conn, $queryFiliaisMeus);

  //SELECIONADO TODAS AS FILIAIS
  $queryFiliais = "SELECT * FROM tv_filiais WHERE tv_desativarFilial = 0 AND id NOT IN (";

  $FiliaisMeus = "SELECT tv_filial FROM tv_postagem WHERE  id = ".$_GET['id_post']."";
  $resultMeus = mysqli_query($conn, $FiliaisMeus);

  while($linhaFilial = mysqli_fetch_assoc($resultMeus)){

    $queryFiliais .= $linhaFilial['tv_filial'].",";

  }

  $queryFiliais .= "'')";

  $resultFiliais = mysqli_query($conn, $queryFiliais);
?>
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class='fas fa-edit'></i> Editando Postagem</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php?pagina=1">Dashboard</a></li>
              <li><i class='fas fa-edit'></i>Editando</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6" style="width: 86%;">
            <section class="panel">
              <div class="panel-body">
                <form role="form" method="POST" action="editar.php?id_post=<?=$_GET['id_post']?>" enctype="multipart/form-data">
                  <div class="form-group ">
                      <label for="cname" class="control-label col-lg-2">Tempo de execusão:</label>
                      <div class="col-lg-10">
                          <input class="form-control" id="cname" name="tempo" type="number" value="<?= $post['tv_tempoExecucao'] ?>">
                          <span class="help-block" style="margin-top: -21px; margin-left: 67px;">Segundos</span>
                      </div>
                  </div>                        
                  <div class="form-group" id="dataDiv">
                      <label for="agree" class="control-label col-lg-2 col-sm-3">Inativar postagem:</label>
                      <input type="text" class="form-control col-4 inativarDate" id="dataInput" placeholder="DD / MM / AAAA" name="dataFim" value="<?= $post['tv_dataDesativar'] ?>">
                  </div>
                  <div class="form-group">
                      <label for="agree" class="control-label col-lg-2 col-sm-3" style="width: 17%;">Cor de Fundo:</label>
                      <input class="form-control" id="corfundo" name="corfundo" type="color" style="width: 10%;" oninput="mostrarValor()" value="<?= $post['tv_corFundo'] ?>">
                      <input class="form-control" id="corfundoHex" name="corfundoHex" type="colorHex" style="width: 10%;  margin-left: 17%; margin-top: 4px;" oninput="inserirValor()" value="<?= $post['tv_corFundo'] ?>">
                  </div>
                  <div class="form-group">
                      <label class="control-label col-lg-2" for="inputSuccess">Filiais:</label>
                      <div class="col-lg-10" style="margin-bottom: 14px; margin-top: 10px;">
                        <?php  
                          while($FiliaisMeusa = mysqli_fetch_assoc($resultFiliaisMeus)){
                            echo "<label class='checkbox-inline' style='text-transform: capitalize'><input type='radio' id='inlineCheckbox".$FiliaisMeusa['tv_filial']."' value='".$FiliaisMeusa['tv_filial']."' name='filial[]' checked> ".$FiliaisMeusa['tv_nomeFilial']."</label><br />";
                          }
                          while($filiais = mysqli_fetch_assoc($resultFiliais)){
                            echo "<label class='checkbox-inline' style='text-transform: capitalize'><input type='radio' id='inlineCheckbox".$filiais['id']."' value='".$filiais['id']."' name='filial[]'> ".$filiais['tv_nomeFilial']."</label><br />";
                          }
                        ?>
                      </div>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Deseja usar a mesma imagem ?</label><br />                 
                    <label class="label_radio r_on" for="radio-01">
                        <input name="arquivo" id="radio-01" value="1" type="radio" checked=""> Sim
                    </label>
                    <label class="label_radio r_on" for="radio-02">
                        <input name="arquivo" id="radio-02" value="0" type="radio" style="margin-left: 10px;"> Não
                    </label>
                  </div>
                  <div class="form-group" style="display: none" id="file">
                    <label for="exampleInputFile">Anexar um arquivo</label>
                    <input name="file" type="file" id="exampleInputFile">
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
  <script>
function mostrarValor() {
    var cor = document.getElementById("corfundo").value;

    document.getElementById('corfundoHex').value = cor;
}

function inserirValor() {
    var cor = document.getElementById("corfundoHex").value;

    document.getElementById('corfundo').value = cor;
}
</script>
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
</body>
</html>