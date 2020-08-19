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
            <li <?php if($_GET['pagina'] == 2){echo "class='active'";}?>>
                <a class="" href="postagens.php?pagina=2">
                    <i class="far fa-comments"></i>
                    <span>Comentários</span>
                </a>
            </li>            
            <li <?php if($_GET['pagina'] == 4 || $_GET['pagina'] == 5 || $_GET['pagina'] == 6){echo "class='active'";}?>>
                <a class="" href="tipo_postagem.php?pagina=5">
                    <i class="fas fa-plus-square"></i>
                    <span>Nova Postagem</span>
                </a>
            </li>
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->