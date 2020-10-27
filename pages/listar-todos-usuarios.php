<?php
	if (isset($_GET['excluir'])) {
		$excluir = requisicaoParaApi('excluirUsuario', array('id'=>$_GET['excluir']));
	}
	$resposta = requisicaoParaApi('selecionarTodosUsuario');
?>
<div class="informacao-usuario">
	<?php if (isset($_GET['excluir']) && $excluir['resultado'] == 'verdadeiro') { ?>
		<div class="Sucesso">
			<h1>Usuario excluido com sucesso!!!</h1>
		</div>
	<?php }else if (isset($_GET['excluir']) && $excluir['resultado'] == 'falso') { ?>
		<div class="Falha">
			<h1>Usuario não foi excluido pois já possui movimentação de conta</h1>
		</div>
	<?php } ?>
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
			foreach ($resposta as $key => $value) {
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
			<td><a class="excludeHere" href="<?php echo INCLUDE_PATH ?>listar-todos-usuarios?excluir=<?php echo $value['id']; ?>">Excluir</a></td>
		</tr>
		<?php } ?>
	</table>
</div>