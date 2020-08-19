<?php 
//validando
if($_GET['pagina'] != 1){
  header('location: 404.php');
}
require 'header.php';

require 'menu_lateral.php'; 

//pegando todas as postagens

$postagens_query = "SELECT 
                      TP.*, TL.tv_nome
                    FROM
                      tv_postagem TP

                    LEFT JOIN tv_login TL ON TP.tv_usuario = TL.id";


($_SESSION["perfil"] == 1 OR $_SESSION["perfil"] == 2) ?: $postagens_query .= " WHERE TP.tv_usuario = ".$_SESSION['id']."";


$postagens_query .= " ORDER BY id DESC";


echo "<prev>".$postagens_query."</prev>";

$result_postagem = mysqli_query($conn, $postagens_query);

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
                  <strong>Cadastrado realizado com sucesso!. SAIA E ENTRE NOVAMENTE PARA APLICAR A ATUALIZAÇÃO</strong>
                </div>";
              }

              if($_GET['msn'] == 2){
                echo "<div class='alert alert-info fade in'>
                <button data-dismiss='alert' class='close close-sm' type='button'>
                  <i class='far fa-times-circle' style='color: red;'></i>
                </button>
                <strong>Postagem reativada com sucesso!.</strong> 
              </div>";
              }

              if($_GET['msn'] == 3){
                echo "<div class='alert alert-block alert-danger fade in'>
                <button data-dismiss='alert' class='close close-sm' type='button'>
                  <i class='far fa-times-circle' style='color: blue;'></i>
                </button>
                <strong>Publicação desativada com sucesso!.</strong> 
              </div>";
              }

              if($_GET['msn'] == 4){
                echo "<div class='alert alert-info fade in'>
                <button data-dismiss='alert' class='close close-sm' type='button'>
                  <i class='far fa-times-circle' style='color: red;'></i>
                </button>
                <strong> Postagem editada com sucesso!.</strong>
              </div>";
              }

              if($_GET['msn'] == 5){
                echo "<div class='alert alert-success fade in'>
                <button data-dismiss='alert' class='close close-sm' type='button'>
                  <i class='far fa-times-circle' style='color: red;'></i>
                </button>
              <strong>Postagem realizada com sucesso!</strong>
            </div>";
              }
            ?>
        <!--overview start-->
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fas fa-book-open"></i> Minhas publicações</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php?pagina=1">Dashboard</a></li>
            </ol>
            <div id="new">
              <a class="btn btn-danger" href="nova_publicacao.php?pagina=6">
                <i class="fas fa-plus"></i> Nova Postagem
              </a>
            </div>
          </div>
        </div>

        <div class="row"></div>
          <div class="col-lg-12">
            <section class="panel">
              <table class="table table-striped table-advance table-hover">
                <tbody>
                  <tr>
                    <th>Usuário</th>
                    <th>Imagem</th>
                    <th>Filiais</th>                    
                    <th>Data postagem</th>                                        
                    <th>Data exclusão</th>
                    <th>Tempo execução</th>
                    <th>Cor de fundo</th>
                    <th>Ação</th>
                  </tr>

                  <?php

                  while($postagens = mysqli_fetch_assoc($result_postagem)){

                    echo "
                    <tr>
                      <td>".$postagens['tv_nome']."</td>
                      <td><a href=".$postagens['tv_caminhoImg']." target='_blank' title='Clique para ver o arquivo'>Arquivo</a></td>";
                      echo "<td style='text-transform: capitalize;'>";
                      $query_filial = "SELECT 
                                          TF.tv_nomeFilial
                                      FROM
                                          tv_postagem TP
                                              LEFT JOIN
                                          tv_filiais TF ON TP.tv_filial = TF.id
                                      WHERE
                                          TP.id = ".$postagens['id']."";
                      $resultFilial = mysqli_query($conn, $query_filial);

                      while($rowFilial = mysqli_fetch_assoc($resultFilial)){
                        echo $rowFilial['tv_nomeFilial'] . "<br />";
                      }

                     echo "</td>
                      <td>".$postagens['tv_dataPostagem']."</td>";

                      if($postagens['tv_dataDesativar'] == "noDate"){
                        echo "<td>---</td>";
                      }else{
                        echo "<td>".$postagens['tv_dataDesativar']."</td>";
                      }

                      echo "
                      <td>".$postagens['tv_tempoExecucao']." Segundos</td>
                      <td><div class='corFundo' style='background-color: ".$postagens['tv_corFundo'].";border: 1px solid;'></div></td>
                      <td>
                        <div class='btn-group'>";
                          
                          if($postagens['tv_desativar'] == 0){                         
                                echo "
                                    <a class='btn btn-primary' href='../postagens/index.php?id=".$postagens['tv_filial']."' title='Ver a publicação' target='_blank'><i class='fas fa-eye'></i></a>
                                    <a class='btn btn-danger' href='ativa_desativa.php?id_post=".$postagens['id']."&ativa=nao' title='desativar'><i class='icon_close_alt2'></i></a>";
                            }else{
                              echo "<a class='btn btn-success' href='ativa_desativa.php?id_post=".$postagens['id']."&ativa=sim' title='ativar'><i class='icon_check_alt2'></i></a>";
                            }                      
                            echo "
                          <a class='btn btn-warning' href='editar_postagem.php?pagina=3&id_post=".$postagens['id']."' title='editar'><i class='fas fa-edit'></i></a>
                        </div>
                      </td>
                  </tr>";
                  }//fim While postagem
                  ?>
                </tbody>
              </table>
            </section>
          </div>
        </div>
        <!-- page end-->
      </section>
    </section>
    <!--main content end-->
</body>

</html>
