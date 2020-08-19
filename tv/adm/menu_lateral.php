<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu">
            <li <?php if($_GET['pagina'] == 1){echo "class='active'";}?>>
                <a class="" href="dashboard.php?pagina=1">
                    <i class="fas fa-book-open"></i>
                    <span>Minhas Publicações</span>
                </a>
            </li>
            <?php
                if($_SESSION["perfil"] == 1 || $_SESSION["perfil"] == 2){//administrador OU supervisor

                    echo "<li"; if($_GET['pagina'] == 4){echo " class='active'" ;} echo ">
                                <a class='' href='list_user.php?pagina=4'>
                                    <i class='icon_group'></i>
                                    <span>Listar usuário</span>
                                </a>
                            </li>";

                    echo "<li"; if($_GET['pagina'] == 7){echo " class='active'" ;} echo ">
                            <a class='' href='new_user.php?pagina=7'>
                                <i class='fas fa-user-plus'></i>
                                <span>Novo usuário</span>
                            </a>
                        </li>";
                }
            ?>            
            <li <?php if($_GET['pagina'] == 6){echo "class='active'";}?>>
                <a class="" href="nova_publicacao.php?pagina=6">
                    <i class="fas fa-plus-square"></i>
                    <span>Nova Postagem</span>
                </a>
            </li>
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->