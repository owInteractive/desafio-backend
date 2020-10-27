<?php
	if (isset($_POST['acao'])) {
		$data_atual = retornarDataHoraAtuais();
		$array = array('name'=>$_POST['name'],'email'=>$_POST['email'],'birthday'=>$_POST['birthday'],
						'created_at'=>$data_atual,'updated_at'=>$data_atual,'saldo_inicial'=>$_POST['saldo_inicial']);
		$resposta = requisicaoParaApi('cadastrarUsuario', $array);
	}
?>
<div class="w-75 right">
	<form method="post">
		<div class="box-formulario">
			<label>Nome do usuario</label>
			<input type="text" name="name" placeholder="Nome..." required>
		</div>
		<div class="box-formulario">
			<label>Email do usuario</label>
			<input type="text" name="email" placeholder="Email..." required>
		</div>
		<div class="box-formulario">
			<label>Aniversário do usuario</label>
			<input type="date" name="birthday" required>
		</div>
		<div class="box-formulario">
			<label>Saldo inicial</label>
			<input type="text" name="saldo_inicial" placeholder="por padrão é 0">
		</div>
		<div class="submit-button">
			<input type="submit" name="acao" value="Enviar!" >
		</div>
	</form>
	<?php
		if (isset($resposta) && $resposta['resultado'] == 'verdadeiro') {
	?>
		<div class="Sucesso">
			<h1>Usuario cadastrado com sucesso!!!</h1>
		</div>
	<?php
		}else if (isset($resposta) && $resposta['resultado'] == 'falso') {
	?>
		<div class="Falha">
			<h1>Usuario não foi cadastrado, verifique os dados e tente novamente</h1>
		</div>
	<?php }else if (isset($resposta) && $resposta['resultado'] == 'menor_idade'){ ?>
		<div class="Falha">
			<h1>Usuario não foi cadastrado pois é menor de idade</h1>
		</div>
	<?php } ?>
</div>