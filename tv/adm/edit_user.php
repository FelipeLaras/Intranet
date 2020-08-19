<?php 
  //validando
  if($_GET['pagina'] != 4){
    header('location: 404.php');
  }
  require 'header.php';

  require 'menu_lateral.php'; 

  $post_query = "SELECT * FROM tv_login WHERE id = ".$_GET['id']."";
  $result_post = mysqli_query($conn, $post_query);
  $post = mysqli_fetch_assoc($result_post);

  //chamando os perfils
  $queryPerfil = "SELECT * FROM tv_perfil";
  $resultadoPerfil = mysqli_query($conn, $queryPerfil);

  //pegando o meu perfil
  $meuPerfil = "SELECT 
                  TL.tv_perfil, TP.tv_nome AS perfil, TP.id AS id_perfil
                FROM
                  tv_login TL
                      LEFT JOIN
                  tv_perfil TP ON TL.tv_perfil = TP.id
                WHERE
                  TL.id = ".$_GET['id']."";
  $resultadoMeuPerfil = mysqli_query($conn, $meuPerfil);
  $rowMeuPerfil = mysqli_fetch_assoc($resultadoMeuPerfil);

  //SELECIONADO TODAS AS FILIAIS
  $queryFiliais = "SELECT * FROM tv_filiais WHERE tv_desativarFilial = 0 AND id NOT IN (";

  $FiliaisMeus = "SELECT tv_filial, tv_concessionaria FROM tv_permissoes_filial WHERE  tv_usuario = ".$_GET['id']."";
  $resultMeus = mysqli_query($conn, $FiliaisMeus);

  while($linhaFilial = mysqli_fetch_assoc($resultMeus)){

    $queryFiliais .= $linhaFilial['tv_filial'].",";

  }

  $queryFiliais .= "'')";

  $resultFiliais = mysqli_query($conn, $queryFiliais);


  //SELECIONANDO TODAS AS CONCESSIONARIAS
  $queryConcessionaria = "SELECT * FROM tv_concessionarias WHERE tv_desativarFilial = 0 AND id NOT IN (";

  $conMeus = "SELECT tv_concessionaria FROM tv_permissoes_filial WHERE  tv_usuario = ".$_GET['id']."";
  $resultCons = mysqli_query($conn, $conMeus);

  while($linhaCon = mysqli_fetch_assoc($resultCons)){

    $queryConcessionaria .= $linhaCon['tv_concessionaria'].",";

  }

  $queryConcessionaria .= "'')";

  $resultConcessionaria = mysqli_query($conn, $queryConcessionaria);
  
  //MOSTRANDO APENAS AS CONCESSIONARIAS QUE POSSUO
  $queryConMeu = "SELECT DISTINCT
                    PF.tv_concessionaria AS id_com, TC.tv_nomeFilial AS nome_com
                  FROM
                    tv_permissoes_filial PF
                  LEFT JOIN 
                  tv_concessionarias TC ON PF.tv_concessionaria = TC.id
                  WHERE
                    tv_usuario = ".$_GET['id']."";
$resultConMeu = mysqli_query($conn, $queryConMeu);
?>
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
      <?php
        if($_GET['msn'] == 1){
            echo "
              <div class='alert alert-success fade in'>
                <button data-dismiss='alert' class='close close-sm' type='button'>
                  <i class='far fa-times-circle' style='color: red;'></i>
                </button>
                <strong>Atenção</strong> Usuário editado com sucesso!
              </div>
            ";
          }
        ?>
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class='fas fa-edit'></i> Editando Usuário</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-group"></i><a href="list_user.php?pagina=4">Usuários</a></li>
              <li><i class='fas fa-edit'></i>Editando</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6" style="width: 86%;">
            <section class="panel">
              <div class="panel-body">
                <form role="form" method="POST" action="editando_user.php">
                  <input name="id_user" value="<?=$_GET['id']?>" style="display: none;" />
                  <div class="form-group">
                    <label for="nome">Login: </label>
                    <input name="nome" type="text" class="form-control" style="width: 40%;" id="login" value="<?= $post['tv_usuario'] ?>">
                  </div>
                  <div class="form-group">
                    <label for="email">Perfil: </label>
                    <select class="form-control menor" name='perfil' style="width: 40%;" required>                   
                      <option value="<?= $rowMeuPerfil['id_perfil'] ?>" selected> <?= $rowMeuPerfil['perfil'] ?></option>
                      <option value="">---</option>
                      <?php while($rowPerfil = mysqli_fetch_assoc($resultadoPerfil)){echo "<option value='".$rowPerfil['id']."'>".$rowPerfil['tv_nome']."</option>";} ?>
                    </select>
                  </div>                  
                  <div class="form-group">
                    <label for="exibicao">Nome: </label>
                    <input name="exibicao" type="text" class="form-control" style="width: 40%;" id="exibicao" value="<?= $post['tv_nome'] ?>">
                  </div>                 
                  <div class="form-group">
                    <label for="senha_atual">Senha: </label>
                    <input name="senha" type="password" class="form-control" style="width: 30%;" id="senha_atual">
                    <input name="senha_atual" type="password" class="form-control" style="display:none;" id="senha" value="<?= $post['tv_senha'] ?>">
                  </div>   
                  <hr>     
                  <div class="form-group">
                    <label class="control-label col-lg-2" for="inputSuccess">Filiais:<br /><span class="minusculo"> (Sem permissão)</span></label>
                    <div class="col-lg-10" style="margin-left: -79px;">
                      <ul class="list-group list-group-flush">                                                           
                      <?php
                              $id = 1;

                              while($rowConcessionaria = mysqli_fetch_assoc($resultConcessionaria)){

                                  //selecionando todas as filiais
                                  $queryFiliais = "SELECT * FROM tv_filiais WHERE tv_desativarFilial = '0' AND tv_concessionaria = ".$rowConcessionaria['id']."";
                                  $resultadoFiliais = mysqli_query($conn, $queryFiliais);
  
                                    echo '
                                        <li class="concessionaria">
                                          <div class="checkbox">
                                            <label class="blue">              
                                              <input name="concessionaria'.$id.'" value="'.$rowConcessionaria['id'].'" type="checkbox" class="btn btn-sm btn-2 glyphicon" data-toggle="collapse" data-target="#'.$id.'">                                                            
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
                          <li class="concessionaria">
                            <div class="checkbox">
                              <label class="blue">              
                                -------------------------------
                              </label>
                            </div>
                          </li>
                        </ul>
                    </div>
                  </div> 
                  <div class="form-group">
                    
                    <label class="control-label col-lg-2" for="inputSuccess">Filiais:<br /><span class="minusculo"> (Com permissão)</span></label>
                    <div class="col-lg-10" style="margin-left: -79px;">
                      <ul class="list-group list-group-flush">                                        
                      <?php
                              $idC = 1;

                              while($rowConcessionaria = mysqli_fetch_assoc($resultConMeu)){
                                  echo '
                                      <li class="concessionaria">
                                        <div class="checkbox">
                                          <label class="blue">              
                                            <input name="concessionariaC'.$idC.'" value="'.$rowConcessionaria['id_com'].'" type="checkbox" class="btn btn-sm btn-2" checked>                                                            
                                            '.$rowConcessionaria['nome_com'].'
                                          </label>
                                        </div>
                                          <div id="'.$idC.'" class="filial">';

                                            //SELECIONADO AS FILIAIS QUE JÁ TENHO
                                              $queryFiliaisMeus = "SELECT 
                                              PF.tv_filial AS id,
                                              TF.tv_nomeFilial,
                                              PF.tv_concessionaria AS id_con,
                                              TC.tv_nomefilial AS concessionaria,
                                              PF.tv_usuario
                                          FROM
                                              tv_permissoes_filial PF
                                                  LEFT JOIN
                                              tv_filiais TF ON PF.tv_filial = TF.id
                                                  LEFT JOIN
                                              tv_concessionarias TC ON PF.tv_concessionaria = TC.id
                                          WHERE
                                              PF.tv_usuario = ".$_GET['id']." AND TC.id = ".$rowConcessionaria['id_com']."" ;

                                            $resultFiliaisMeus = mysqli_query($conn, $queryFiliaisMeus);

                                          while($rowFilialCom = mysqli_fetch_assoc($resultFiliaisMeus)){
                                            echo '
                                            <div class="checkbox left">
                                                <label>
                                                  <input name="filialC'.$idC.'[]" type="checkbox" value="'.$rowFilialCom['id'].'" checked>'.$rowFilialCom['tv_nomeFilial'].'
                                                </label>
                                            </div>';
                                          }
                                  echo '            
                                          </div>
                                      </li>
                                  ';
                                
                                  $idC++;
                              }
                          ?>
                          <li class="concessionaria">
                            <div class="checkbox">
                              <label class="blue">              
                                -------------------------------
                              </label>
                            </div>
                          </li>
                        </ul>
                    </div>
                  </div>   
                  <div class="form-group">
                    <div class="col-sm-10">
                      <button type="submit" class="btn btn-primary" style="float: right">Salvar</button>
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
</body>
</html>