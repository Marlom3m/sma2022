<script>
function desativar(el1,el2) {
  document.getElementById(el1).style.display = 'none';
  document.getElementById(el2).value = '';
  document.getElementById(el2).required = false;
}
function ativar(el1,el2) {
  document.getElementById(el1).style.display = 'block';
  document.getElementById(el2).required = true;
}
function mudarEstado(el1,el2) {
  var display = document.getElementById(el1).style.display;
  if(display == "none"){
    document.getElementById(el1).style.display = 'block';
    document.getElementById(el2).required = true;
  }else{
   document.getElementById(el1).style.display = 'none';
   document.getElementById(el2).value = '';
   document.getElementById(el2).required = false;
	}
}
window.onload=function(){
  desativar("estudante","ra");
  desativar("externo","inst");
}
</script>

<div class="container text-dark font-weight-bold" >
  <br>
	<div class="container">
		<?php
			if (!empty($_SESSION['type'])) {
		?>
		<div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<?php
				if(!empty($_SESSION['msgId']))
					echo $_SESSION['msgId'].'<br>';
				if(!empty($_SESSION['msgNome']))
					echo $_SESSION['msgNome'].'<br>';
				if(!empty($_SESSION['message']))
					echo $_SESSION['message'].'<br>';
			?>
		</div>

		<?php
			unset($_SESSION['type']);
			unset($_SESSION['msgId']);
			unset($_SESSION['msgNome']);
			unset($_SESSION['message']);
		?>

		<?php } ?>
	</div>
<h2>Novo Usuario</h2>
	<form action="?page=usuario_save" method="post">

	<!-- area de campos do form -->
	<hr/>	<!-- linha de separação -->
		<div class="row">
			<div class="form-group col-md-10">
				<label for="nome">Nome:</label>
				<input type="text" class="form-control" name="nome" required>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-3">
				<label for="nome">CPF (apenas números):</label>
				<input type="text" inputmode="numeric" onkeypress="if (!isNaN(String.fromCharCode(window.event.keyCode))) return true; else return false;" class="form-control" name="cpf" maxlength="11" required>
			</div>
			<div class="form-group col-md-7">
				<label for="nome">E-mail:</label>
				<input type="email" class="form-control"  name="email" required>
			</div>
		</div>
		<div class="form-check-inline">
			<label class="form-check-label">
				<input type="radio" class="form-check-input" name="externo" onclick="ativar('estudante','ra'); desativar('externo','inst')" required > Estudante IFMS
			</label>
		</div>
    <div class="form-check-inline">
			<label class="form-check-label">
				<input type="radio" class="form-check-input" name="externo" onclick="desativar('estudante','ra'); ativar('externo','inst')"> Servidores ou Público Externo
			</label>
		</div>
		<div class="row">
			<div id="estudante" class="form-group col-md-8">
				<label for="nome">RA:</label>
				<input type="text" class="form-control" inputmode="numeric" onkeypress="if (!isNaN(String.fromCharCode(window.event.keyCode))) return true; else return false;" id="ra" name="ra">
			</div>
		</div>
    <div class="row">
			<div id="externo" class="form-group col-md-8">
				<label for="nome">Instituição:</label>
				<input type="text" class="form-control" id="inst" name="externo">
			</div>
		</div>
    <br>
		<div id="actions" class="row">
			<div class="col-md-12">
				<button type="submit" class="btn btn-primary">Salvar</button>
				<a href="index.php" class="btn btn-default">Voltar</a>
			</div>
		</div>
	</form>

</div>
