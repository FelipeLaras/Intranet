<?php
//sessão
session_start();
//chamando banco de dados
include 'conexao.php';
/* ----------------------- BUSCANDO INFORMAÇÕES DO USUÁRIO  ----------------------- */

//variaveis de conf. envio
$smtp = "smtp.gmail.com";//servidor usado para envio
$porta = "465"; //porta padrão SSL
$login_email = "glpi@servopa.com.br"; //usuario para o login do SMTP
$senha_email = "cpdtec05"; //senha para o login ao SMTP
$titulo_email = "Comentario do Blog";


/* ----------------------- BUSCANDO AS INFORMAÇÕES DO COMENTÁRIO  ----------------------- */
$comentario_query = "SELECT 
                        BP.titulo,
                        BC.data,
                        BC.nome,
                        BD.nome AS departamento,
                        BE.nome AS empresa,
                        BC.comentario,
                        BU.email
                    FROM
                        blog_comentarios BC
                    LEFT JOIN
                        blog_post BP ON BC.id_postagem = BP.id_postagem
                    LEFT JOIN
                        blog_departamento BD ON BC.departamento = BD.id_departamento
                    LEFT JOIN
                        blog_empresa BE ON BC.empresa = BE.id_empresa
                    LEFT JOIN
                        blog_user BU ON BP.id_post_user = BU.id_user
                    WHERE
                        BC.id_postagem = ".$_GET['id_post']." AND
                        BC.avisado_responsavel != 1";
$result_comentario = mysqli_query($conn, $comentario_query);

//chamando o PHPMailer
require 'PHPMailer/PHPMailerAutoload.php';

/* ----------------------- MONTANDO O CORBO DA MENSAGEM ----------------------- */
$msn = "
<html>
    <body>
";

while($comentario = mysqli_fetch_assoc($result_comentario)){

    $destinatario = $comentario['email'];//O mail que receberá as msn

    $msn.= "
        <div class='container' style='padding-left: 11px;width: 90%;'>
            <div class='titulo' style='font-weight: bold;font-size: 14px'>
                <h2 style='border-left: 3px solid orange; border-bottom: 1px solid red; font-size: 17px;'>Titulo: ".$comentario['titulo']."</h2>
            </div>
            <div class='conteudo' style='padding-bottom: 1px;padding-top: 1px;background-color: #a9a9a933;border-radius: 7px;'>
                <ul style='list-style-type: none;'>
                    <li style='font-size: 12px;'><span class='sub_titulo' style='font-weight: bold;font-size: 14px'>Data do comentário</span>: ".$comentario['data']."</li>
                    <li style='font-size: 12px;'><span class='sub_titulo' style='font-weight: bold;font-size: 14px'>Nome</span>: ".$comentario['nome']."</li>
                    <li style='font-size: 12px;'><span class='sub_titulo' style='font-weight: bold;font-size: 14px'>Departamento</span>: ".$comentario['departamento']."</li>
                    <li style='font-size: 12px;'><span class='sub_titulo' style='font-weight: bold;font-size: 14px'>Empresa</span>: ".$comentario['empresa']."</li>
                    <li style='font-size: 12px;'><span class='sub_titulo' style='font-weight: bold;font-size: 14px'>Mensagem</span>: ".$comentario['comentario']."</li>                    
                </ul>
            </div>
        </div> ";
}

$msn .= "
    <div class='botao' style='background-color: blue;

    width: 10%;
    
    padding-left: 15px;
    
    padding-bottom: 5px;
    
    padding-top: 5px;
    
    border-radius: 9px;
    
    margin-top: 12px;'>
        <a href='http://rede.paranapart.com.br/blog/postagem.php?id_post=".$_GET['id_post']."' target='_blank' style='text-decoration: none;color: #fff'>
            Ver na publicação
        </a>
    </div>
    </body>
    </html>";
//Definando o PHPMailer
$Mailer = new PHPMailer();
			
//Define que será usado SMTP
$Mailer->IsSMTP();

//Enviar e-mail em HTML
$Mailer->isHTML(true);

//Aceitar carasteres especiais
$Mailer->Charset = 'UTF-8';

//Configurações
$Mailer->SMTPAuth = true;
$Mailer->SMTPSecure = 'ssl';

//nome do servidor
$Mailer->Host = $smtp;
//Porta de saida de e-mail 
$Mailer->Port = $porta;

#Montando o e-mail

//Dados do e-mail de saida - autenticação
$Mailer->Username = $login_email;
$Mailer->Password = $senha_email;

//E-mail remetente (deve ser o mesmo de quem fez a autenticação)
$Mailer->From = $login_email;

//Nome do Remetente
$Mailer->FromName = $nome;

//Assunto da mensagem
$Mailer->Subject = $titulo_email;

//Corpo da Mensagem
$Mailer->Body = $msn;

//Corpo da mensagem em texto
$Mailer->AltBody = '';

//Destinatario 
$Mailer->AddAddress($destinatario);

if($Mailer->Send()){
    echo "Email enviado para: ".$destinatario."<br>";
}else{
    echo "Erro no envio do e-mail: " . $Mailer->ErrorInfo;
}

//voltando para informar que foi salvo com sucesso!
header('location: postagem.php?id_post='.$_GET['id_post'].'&msn=1');

//fecha conexao com o banco de dados
mysqli_close($conn);

?>