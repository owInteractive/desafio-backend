<?php
	if (isset($_POST['acao'])) {
		$respostaDaRequisicao = requisicaoParaApi('listar_um_usuario', array('id'=>$_POST['id']));
	}
	if (isset($_POST['alterar_valor'])) {
		$respostaDaRequisicao = requisicaoParaApi('alterarSaldoInicial', array('id'=>$_POST['id'],'novo_valor'=>$_POST['novo_valor']));
	}
?>
<div class="w-75 right">
	<?php if(!isset($_POST['acao']) || isset($_POST['novo_valor'])){ ?>
		<form method="post">
			<div class="box-formulario">
				<label>Digite o ID </label>
				<input type="text" name="id" placeholder=" ID que deseja alterar o saldo..." required>
			</div>
			<div class="submit-button">
				<input type="submit" name="acao" value="Enviar!" >
			</div>
		</form>
	<?php } if(isset($_POST['novo_valor']) && $respostaDaRequisicao['resultado'] == 'verdadeiro'){ ?>
		<div class="Sucesso"><h1>Valor alterado com sucesso</h1></div>
	<?php }else if(isset($_POST['novo_valor']) && $respostaDaRequisicao['resultado'] == 'falso'){ ?>
		<div class="Falha"><h1>Falha ao alterar o valor, tente novamente</h1></div>
	<?php } ?>
	<?php if(isset($_POST['acao']) && !isset($respostaDaRequisicao['resultado'])){ ?>
		<form method="post">
			<?php foreach($respostaDaRequisicao as $key => $value){ ?>
				<div class="box-formulario">
					<input type="hidden" name="id" value="<?php echo($_POST['id']); ?>">
					<label>Valor atual:</label>
					<input type="text" name="novo_valor" value="<?php echo mostrarValor($value['saldo_inicial']); ?>" required>
				</div>
			<?php } ?>
			<div class="submit-button">
				<input type="submit" name="alterar_valor" value="Enviar!" >
			</div>
		</form>
	<?php }else if(isset($_POST['acao']) && $respostaDaRequisicao['resultado'] == 'falso'){ ?>
		<div class="Falha">
			<h1>Este usuario não existe em nosso banco de dados...</h1>
		</div>
	<?php } ?>
</div>