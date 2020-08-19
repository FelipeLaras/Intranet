<?php
//validando
if ($_GET['pagina'] != 6) {
    header('location: 404.php');
}
require 'header.php';

require 'menu_lateral.php';

//selecionando as concessionaria que o usuario logado possui permissão
$queryConcessionaria = "SELECT DISTINCT
                            TPF.tv_concessionaria, TC.tv_nomeFilial
                        FROM
                            tv_permissoes_filial TPF
                        LEFT JOIN
                            tv_concessionarias TC ON TPF.tv_concessionaria = TC.id
                        WHERE
                            tv_usuario = '".$_SESSION["id"]."'";

$resultConcessionaria = mysqli_query($conn, $queryConcessionaria);


?>
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header"><i class="fas fa-plus-square"></i>Nova postagem</h3>
                <ol class="breadcrumb">
                    <li><i class="fa fa-home"></i><a href="dashboard.php?pagina=1">Dashboard</a></li>
                    <li><i class="fa fa-plus-square"></i>Nova Postagem</li>
                </ol>
            </div>
        </div>
        <!-- page start-->
        <div class="row">
            <div class="col-lg-6" style="width: 86%;">
                <section class="panel">
                    <div class="panel-body">
                        <form class="form-validate form-horizontal" id="feedback_form" method="POST" action="salvar_postagem.php" enctype="multipart/form-data" autocomplete="off">
                            <div class="form-group ">
                                <label for="cname" class="control-label col-lg-2">Tempo de execusão:</label>
                                <div class="col-lg-10">
                                    <input class="form-control" id="cname" name="tempo" type="number" required>
                                    <span class="help-block" style="margin-top: -21px; margin-left: 67px;">Segundos</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-2" for="inputSuccess">Filiais:</label>
                                <div class="col-lg-5">
                                    <ul class="list-group list-group-flush">                                        
                                        <?php
                                            $id = 1;

                                            while($rowConcessionaria = mysqli_fetch_assoc($resultConcessionaria)){
                                                echo '
                                                    <li class="concessionaria">              
                                                        <a href="javascript:" onclick="plus'.$id.'()" class="btn btn-sm btn-2 glyphicon" data-toggle="collapse" data-target="#'.$id.'">                                                            
                                                            <i id="mais'.$id.'" class="fas fa-plus-square" style="display: block"></i>
                                                            <i id="menos'.$id.'" class="fas fa-minus-square" style="display: none"></i>
                                                        </a>
                                                        '.$rowConcessionaria['tv_nomeFilial'].'
                                                            <div id="'.$id.'" class="collapse filial">';

                                                        //chamando as filiais que são dessa concessionaria
                                                        $queryFilial = "SELECT DISTINCT
                                                                            TPF.tv_filial,
                                                                            TF.tv_nomeFilial
                                                                        FROM
                                                                            tv_permissoes_filial TPF
                                                                                LEFT JOIN
                                                                            tv_filiais TF ON TPF.tv_filial = TF.id
                                                                        WHERE
                                                                            TPF.tv_usuario = ".$_SESSION["id"]." AND TPF.tv_concessionaria = ".$rowConcessionaria['tv_concessionaria']."";
                                                        $resultFilial = mysqli_query($conn, $queryFilial);

                                                        while($rowFilial = mysqli_fetch_assoc($resultFilial)){
                                                            echo '                                                            
                                                                <div class="checkbox">                                                                
                                                                    <label><input type="checkbox" value="'.$rowFilial['tv_filial'].'" name="filial[]">'.$rowFilial['tv_nomeFilial'].'</label>
                                                                </div>
                                                            ';
                                                        }                                                        
                                                echo '
                                                        </div>
                                                    </li>

                                                    <script>
                                                        function plus'.$id.'(){
                                                            var display = document.getElementById("mais'.$id.'").style.display

                                                            if(display == "block"){
                                                                document.getElementById("mais'.$id.'").style.display = "none"
                                                                document.getElementById("menos'.$id.'").style.display = "block"
                                                            }else{
                                                                document.getElementById("mais'.$id.'").style.display = "block"
                                                                document.getElementById("menos'.$id.'").style.display = "none"
                                                            }
                                                        }
                                                    </script>
                                                ';

                                                $id++;
                                            }
                                        ?>
                                        
                                    </ul>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="agree" class="control-label col-lg-2 col-sm-3">Data para desativar:</label>
                                <select class="form-control m-bot15 fimDate" id="dataFim" required>
                                    <option value="">Selecione...</option>
                                    <option value="0">Sim</option>
                                    <option value="1">Não</option>
                                </select>
                            </div>
                            <div class="form-group" style="display: none;" id="dataDiv">
                                <label for="agree" class="control-label col-lg-2 col-sm-3">Inativar postagem:</label>
                                <input type="text" class="form-control col-4 inativarDate" id="dataInput" placeholder="DD / MM / AAAA" name="dataFim">
                            </div>
                            <div class="form-group">
                                <label for="agree" class="control-label col-lg-2 col-sm-3" style="width: 17%;">Cor de Fundo:</label>
                                <input class="form-control" id="corfundo" name="corfundo" type="color" style="width: 10%;" oninput='mostrarValor()' required>
                                <input class="form-control" id="corfundoHex" name="corfundoHex" type="colorHex" style="width: 10%;  margin-left: 17%; margin-top: 4px;" oninput='inserirValor()'>
                            </div>
                            <div class="form-group">
                                <label for="agree" class="control-label col-lg-2 col-sm-3">Imagem:</label>
                                <table class="table table-bordered table-hover" id="tab_logic_R">
                                    <tr id='addrR0'><input type="file" class="form-control-file" id="file" name="file0" required></tr>
                                    <tr id='addrR1'></tr>
                                </table>
                                <a id="ramal_row" class="btn btn-success"><i class="fas fa-plus-square"></i></a>
                                <a id='ramal_remover' class="btn btn-danger excluir"><i class="fas fa-minus-square"></i></a>
                            </div>
                            <button type="submit" class="btn btn-success postar" name="postar" value="1">Realizar a postagem</button>
                            <button type="submit" class="btn btn-primary veja" name="veja" value="1" formtarget="_blank">Veja como Ficou</button>
                        </form>
                    </div>
                </section>
            </div>
        </div>
        <!-- page end-->
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
<script>
    //RAMAL - equip_add.php
    $(document).ready(function() {
        var i = 1;
        $("#ramal_row").click(function() {
            $('#addrR' + i).html("<label for='agree' class='control-label col-lg-2 col-sm-3'>" + (i + 1) + ":</label><input type='file' class='form-control-file' id='file' name='file" + i + "'>");
            $('#tab_logic_R').append('<tr id="addrR' + (i + 1) + '"></tr>');
            i++;
        });
        $("#ramal_remover").click(function() {
            if (i > 1) {
                $("#addrR" + (i - 1)).html('');
                i--;
            }
        });
    });
</script>

<!--TEXTAREA EDIÇÃO-->
<script src="https://cdn.tiny.cloud/1/dqzhgrnm6i4pdh6dtzylwat5bntthf86t9852obx0fvy58ei/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea'
    });
</script>
</body>

</html>