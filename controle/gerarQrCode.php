
<script type="text/javascript" src="controle/qrcode.js"></script>

<?php
require_once ABSPATH.'model/atividade.php';
require_once ABSPATH.'model/evento.php';

$atividade = new Atividade();
$projeto = $atividade->buscaAtividade($_GET['id']);
echo "<script type='text/javascript' src='qrcode.js'></script>";
?>
<link rel="stylesheet" href="<?php echo BASEURL; ?>cdn/css/bootstrap.css">
<link rel="stylesheet" href="<?php echo BASEURL; ?>cdn/css/jquery-ui.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">
  <input type="hidden" size="100%" id="<?php echo $projeto[0]->id_atividade;?>" value="https://projetosifms.com.br/seagro/index.php?page=participante_save&presenca=<?php echo $projeto[0]->id_atividade;?>">
  <center><div id="<?php echo $projeto[0]->nome;?>"></div>
  <h2>
	<?php
  echo "<br>".$projeto[0]->nome;
	?>
  </h2>
  <br>
  <a href="" id="botao1" onclick="esconder()"><button class="btn btn-info"><i class="fa fa-print"></i> Imprimir</button></a>
  <a href="?page=Atividades" id="botao2" ><button class="btn btn-secondary">Voltar</button></a>
  </center>

  <script>
  window.onload = createQrCode('<?php echo $projeto[0]->nome;?>', '<?php echo $projeto[0]->id_atividade;?>');
  function createQrCode(nome,nome2)
  {
      var userInput = document.getElementById(nome2).value;

      var qrcode = new QRCode(nome, {
          text: userInput,
          width: 512,
          height: 512,
          colorDark: "black",
          colorLight: "white",
          correctLevel : QRCode.CorrectLevel.H
      });
  }
  function esconder(){
    document.getElementById("botao1").style.display = 'none';
    document.getElementById("botao2").style.display = 'none';
    window.print();
  }

  </script>
</html>
