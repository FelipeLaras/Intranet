<?php 
//validando
if($_GET['pagina'] != 4){
  header('location: 404.php');
}
require 'header.php';

require 'menu_lateral.php'; 

//pegando todos os usuários
$postagens_query = "SELECT TL.id, TL.tv_nome,TL.tv_usuario,TP.tv_nome as perfil, TL.tv_deletado FROM tv_login TL LEFT JOIN tv_perfil TP ON TL.tv_perfil = TP.id";
$result_postagem = mysqli_query($conn, $postagens_query);

?>

    <!--main content start-->
  <section id="main-content">
    <section class="wrapper">
      <?php
        if($_GET['msn'] == 1){
          echo "
            <div class='alert alert-warning fade in'>
              <button data-dismiss='alert' class='close close-sm' type='button'>
                <i class='far fa-times-circle' style='color: red;'></i>
              </button>
              <strong>Atenção</strong> Usuário editado com sucesso!
            </div>
          ";
        }

        if($_GET['msn'] == 2){
          echo "
          <div class='alert alert-info fade in'>
            <button data-dismiss='alert' class='close close-sm' type='button'>
              <i class='far fa-times-circle' style='color: red;'></i>
            </button>
            <strong>Atenção</strong> Usuário reativado com sucesso!.
          </div>
          ";
        }

        if($_GET['msn'] == 3){
          echo "
          <div class='alert alert-block alert-danger fade in'>
            <button data-dismiss='alert' class='close close-sm' type='button'>
              <i class='far fa-times-circle' style='color: blue;'></i>
            </button>
            <strong>Atenção</strong> Usuário desativado com sucesso!.
          </div>
          ";
        }

        if($_GET['msn'] == 4){
        echo "
        <div class='alert alert-success fade in'>
          <button data-dismiss='alert' class='close close-sm' type='button'>
            <i class='far fa-times-circle' style='color: red;'></i>
          </button>
          <strong>Atenção</strong> Usuário criado com sucesso!
        </div>
        ";
        }

        if($_GET['msn'] == 5){
          echo "
          <div class='alert alert-block alert-danger fade in'>
            <button data-dismiss='alert' class='close close-sm' type='button'>
              <i class='far fa-times-circle' style='color: blue;'></i>
            </button>
            <strong>Atenção</strong> Login já cadastrado no sistema, edite ou crie com um novo login!.
          </div>
          ";
        }
      ?>
        <!--overview start-->
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fas fa-book-open"></i> Lista de usuários</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="dashboard.php?pagina=1">Dashboard</a></li>
              <li><i class="icon_group"></i>Lista usuário</li>
            </ol>
            <div id="new">
              <a class="btn btn-danger" href="new_user.php?pagina=7">
                <i class="fas fa-plus"></i> Novo usuário
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
                    <th>ID</th>
                    <th>Login</th>
                    <th>Perfil</th>                   
                    <th>Usuário</th>                                        
                    <th>Ativo / Inativo</th>
                    <th>Ação</th>
                  </tr>
                  <?php
                  while($postagens = mysqli_fetch_assoc($result_postagem)){
                    echo "
                    <tr>
                      <td>".$postagens['id']."</td>
                      <td>".$postagens['tv_usuario']."</td>
                      <td style='text-transform: capitalize;'>".$postagens['perfil']."</td>                      
                      <td>".$postagens['tv_nome']."</td>
                      <td>";
                        echo ($postagens['tv_deletado'] == 0) ? "Ativo" : "Inativo";                      
                        echo "
                      </td>
                      <td>
                        <div class='btn-group'>";
                          
                          if($postagens['tv_deletado'] == 0){                            
                                echo "<a class='btn btn-danger' href='ativa_desativa.php?id=".$postagens['id']."&ativa=nao' title='desativar'><i class='icon_close_alt2'></i></a>";
                            }else{
                              echo "<a class='btn btn-success' href='ativa_desativa.php?id=".$postagens['id']."&ativa=sim' title='ativar'><i class='icon_check_alt2'></i></a>";
                            }                      
                            echo "
                          <a class='btn btn-warning' href='edit_user.php?pagina=4&id=".$postagens['id']."' title='editar'><i class='fas fa-edit'></i></a>
                        </div>
                      </td>
                  </tr>";
                  }
                  ?>
                </tbody>
              </table>
            </section>
          </div>
        </div>
        <!-- page end-->
      </section>
    </section>  
</body>
</html>