<?php
	if (isset($_GET['excluir'])) {
		$excluir = requisicaoParaApi('excluirUsuario', array('id'=>$_GET['excluir']));
	}
	if (isset($_POST['acao'])) {
		$respostaDaRequeisicao = requisicaoParaApi('listar_um_usuario', array('id'=>$_POST['id']));
	}
?>
<div class="informacao-usuario">
	<form method="post" action="listar-usuario">
		<div class="box-formulario">
			<label>Digite o ID do usuario que deseja ver</label>
			<input type="text" name="id" placeholder=" ID..." required>
		</div>
		<div class="submit-button">
			<input type="submit" name="acao" value="Enviar!" >
		</div>
	</form>

	<?php 
		if(isset($_POST['acao']) && !isset($respostaDaRequeisicao['resultado'])){
	?>
		<table>
			<tr>
				<td>Id</td>
				<td>Nome</td>
				<td>Email</td>
				<td>Anniversário</td>
				<td>Criação</td>
				<td>Ultima atualizacao</td>
				<td>Saldo inicial</td>
				<td>Saldo atual</td>
				<td>#</td>
			</tr>
			<?php 
				foreach ($respostaDaRequeisicao as $key => $value) {
					$saldo_atual = retornar_saldo_atual($value['id']);
			?>
			<tr>
				<td><?php echo $value['id']; ?></td>
				<td><?php echo $value['name']; ?></td>
				<td><?php echo $value['email']; ?></td>
				<td><?php echo $value['birthday']; ?></td>
				<td><?php echo $value['created_at']; ?></td>
				<td><?php echo $value['updated_at']; ?></td>
				<td><?php echo mostrarValor($value['saldo_inicial']); ?></td>
				<td><?php echo mostrarValor($saldo_atual); ?></td>
				<td><a class="excludeHere" href="<?php echo INCLUDE_PATH ?>listar-usuario?excluir=<?php echo $value['id']; ?>">Excluir</a></td>
			</tr>
			<?php } ?>
		</table>
	<?php }else if(isset($respostaDaRequeisicao['resultado'])){ ?>
		<div class="Falha">
			<h1>Não existe um usuário com esse id</h1>
		</div>
	<?php }if (isset($_GET['excluir']) && $excluir['resultado'] == 'verdadeiro') { ?>
		<div class="Sucesso">
			<h1>Usuario excluido com sucesso!!!</h1>
		</div>
	<?php }else if (isset($_GET['excluir']) && $excluir['resultado'] == 'falso') { ?>
		<div class="Falha">
			<h1>Usuario não foi excluido pois já possui movimentação de conta</h1>
		</div>
	<?php } ?>
</div>