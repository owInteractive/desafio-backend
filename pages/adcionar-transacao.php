<?php 
	if (isset($_POST['acao'])) {
		$data_hora_atual = retornarDataHoraAtuais();
		$valor_corrigido = retornarValorCorrigido($_POST['valor']);
		$array = array('id'=>$_POST['id'],'operacao'=>$_POST['operacao'],'valor'=>$valor_corrigido,'created_at'=>$data_hora_atual,'updated_at'=>$data_hora_atual);
		$resposta_da_requisicao = requisicaoParaApi('cadastrarOperacao',$array);
	}
?>
<div class="w-75 right">
	<form method="post">
		<div class="box-formulario">
			<label>ID do usuario</label>
			<input type="text" name="id" placeholder=" ID..." required>
		</div>
		<div class="box-formulario">
			<label>Tipo da operação</label>	
			<select name="operacao" required>
				<option value="">Nenhuma selecionada...</option>
				<option value="credito">Crédito</option>
				<option value="debito">Débito</option>
				<option value="estorno">Estorno</option>
			</select>
		</div>
		<div class="box-formulario">
			<label>Valor da operação</label>
			<input type="text" name="valor" placeholder="xxxxx,xx" required>
		</div>
		<div class="submit-button">
			<input type="submit" name="acao" value="Enviar!" >
		</div>	
	</form>
	<?php if(isset($resposta_da_requisicao) && $resposta_da_requisicao['resultado'] == 'verdadeiro'){ ?>
		<div class="Sucesso">
			<h1>Transação cadastrada com sucesso!!!</h1>
		</div>
	<?php }else if(isset($resposta_da_requisicao) && $resposta_da_requisicao['resultado'] == 'falso'){ ?>
		<div class="Falha">
			<h1>Transação não cadastrada usuario não existe!!!</h1>
		</div>
	<?php } ?>
</div>