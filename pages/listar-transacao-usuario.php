<?php
	$pagina_atual = 1;
	$informacoes_por_pagina = 2;
	$inicio_das_informacoes = ($pagina_atual - 1)*$informacoes_por_pagina;
	$fim_das_informacoes = $informacoes_por_pagina;
	if (isset($_POST['acao'])) {
		$id_escolhido = $_POST['id'];
		$filtro = $_POST['filtro'];
		$respostaDaRequisicao = requisicaoParaApi('listar_um_usuario', array('id'=>$_POST['id']));

		if($filtro == '30dias'){
			$transacoes_do_usuario = requisicaoParaApi('transacoesUltimos30Dias', array('id'=>$_POST['id'],'inicio'=>$inicio_das_informacoes,'fim'=>$fim_das_informacoes));
		}else if($filtro == 'todas'){
			$transacoes_do_usuario = requisicaoParaApi('transacoesDoUsuario', array('id'=>$_POST['id'],'inicio'=>$inicio_das_informacoes,'fim'=>$fim_das_informacoes));
		}else{
			$transacoes_do_usuario = requisicaoParaApi('transacaoDoMes', array('id'=>$_POST['id'],'inicio'=>$inicio_das_informacoes,'fim'=>$fim_das_informacoes,'mes'=>$filtro));
		}
	}
	else if (isset($_GET['paginacao'])) {
		$array_de_informações = explode('*', $_GET['paginacao']);
		$pagina_atual = $array_de_informações[0];
		$id_escolhido = $array_de_informações[1];
		$filtro = $array_de_informações[2];
		$inicio_das_informacoes = ($pagina_atual - 1)*$informacoes_por_pagina;
		$respostaDaRequisicao = requisicaoParaApi('listar_um_usuario', array('id'=>$id_escolhido));
		if($filtro == '30dias'){
			$transacoes_do_usuario = requisicaoParaApi('transacoesUltimos30Dias', array('id'=>$id_escolhido,'inicio'=>$inicio_das_informacoes,'fim'=>$fim_das_informacoes));
		}else if($filtro == 'todas'){
			$transacoes_do_usuario = requisicaoParaApi('transacoesDoUsuario', array('id'=>$id_escolhido,'inicio'=>$inicio_das_informacoes,'fim'=>$fim_das_informacoes));
		}else{
			$transacoes_do_usuario = requisicaoParaApi('transacaoDoMes', array('id'=>$id_escolhido,'inicio'=>$inicio_das_informacoes,'fim'=>$fim_das_informacoes,'mes'=>$filtro));
		}
	}else if (isset($_GET['excluir'])) {
		$array_de_informações = explode('*', $_GET['excluir']);
		$pagina_atual = $array_de_informações[0];
		$id_escolhido = $array_de_informações[1];
		$filtro = $array_de_informações[2];
		$id_a_excluir = $array_de_informações[3];
		$inicio_das_informacoes = ($pagina_atual - 1)*$informacoes_por_pagina;
		$respostaDaRequisicao = requisicaoParaApi('listar_um_usuario', array('id'=>$id_escolhido));
		$excluir = requisicaoParaApi('excluirTransacao', array('id'=>$id_a_excluir));
		if($filtro == '30dias'){
			$transacoes_do_usuario = requisicaoParaApi('transacoesUltimos30Dias', array('id'=>$id_escolhido,'inicio'=>$inicio_das_informacoes,'fim'=>$fim_das_informacoes));
		}else if($filtro == 'todas'){
			$transacoes_do_usuario = requisicaoParaApi('transacoesDoUsuario', array('id'=>$id_escolhido,'inicio'=>$inicio_das_informacoes,'fim'=>$fim_das_informacoes));
		}else{
			$transacoes_do_usuario = requisicaoParaApi('transacaoDoMes', array('id'=>$id_escolhido,'inicio'=>$inicio_das_informacoes,'fim'=>$fim_das_informacoes,'mes'=>$filtro));
		}
	}else if(isset($_GET['gerar-csv'])){
		$array_de_informações = explode('*', $_GET['gerar-csv']);
		$pagina_atual = $array_de_informações[0];
		$id_escolhido = $array_de_informações[1];
		$filtro = $array_de_informações[2];
		$inicio_das_informacoes = ($pagina_atual - 1)*$informacoes_por_pagina;
		$respostaDaRequisicao = requisicaoParaApi('listar_um_usuario', array('id'=>$id_escolhido));
		if($filtro == '30dias'){
			$transacoes_do_usuario = requisicaoParaApi('transacoesUltimos30Dias', array('id'=>$id_escolhido,'inicio'=>$inicio_das_informacoes,'fim'=>$fim_das_informacoes));
		}else if($filtro == 'todas'){
			$transacoes_do_usuario = requisicaoParaApi('transacoesDoUsuario', array('id'=>$id_escolhido,'inicio'=>$inicio_das_informacoes,'fim'=>$fim_das_informacoes));
		}else{
			$transacoes_do_usuario = requisicaoParaApi('transacaoDoMes', array('id'=>$id_escolhido,'inicio'=>$inicio_das_informacoes,'fim'=>$fim_das_informacoes,'mes'=>$filtro));
		}
		$arquivoCSV = requisicaoParaApi('gerarCSV',array('id'=>$id_escolhido,'valores'=>$transacoes_do_usuario,'filtro'=>$filtro));
	}
?>
<div class="w-75 right">
	<form method="post" action="listar-transacao-usuario">
		<div class="box-formulario">
			<label>ID do usuario</label>
			<input type="text" name="id" placeholder=" ID..." required>
		</div>
		<div class="box-formulario">
			<label>Filtros</label>
			<select name="filtro" required>
				<option value="">Nenhuma selecionada...</option>
				<option value="30dias">Últimos 30 dias</option>
				<option value="todas">Todas as moviementações</option>
				<?php for($mes = 1; $mes <= 12; $mes++){ ?>
					<option value="2020-<?php if($mes < 10) echo('0'.$mes); else echo($mes); ?>">
						<?php if($mes < 10) echo('0'.$mes.'/20'); else echo($mes.'/20'); ?>		
					</option>
				<?php } ?>
			</select>
		</div>
		<div class="submit-button">
			<input type="submit" name="acao" value="Enviar!" >
		</div>	
	</form>
	<?php 
		if(isset($_POST['acao']) && !isset($respostaDaRequisicao['resultado']) || isset($_GET['paginacao']) || isset($_GET['gerar-csv']) || isset($_GET['excluir'])){
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
			</tr>
			<?php 
				foreach ($respostaDaRequisicao as $key => $value) {
			?>
			<tr>
				<td><?php echo $value['id']; ?></td>
				<td><?php echo $value['name']; ?></td>
				<td><?php echo $value['email']; ?></td>
				<td><?php echo $value['birthday']; ?></td>
				<td><?php echo $value['created_at']; ?></td>
				<td><?php echo $value['updated_at']; ?></td>
				<td><?php echo $value['saldo_inicial']; ?></td>
			</tr>
			<?php } ?>
		</table>
		<!-- todas as transações paginadas abaixo -->
		<table>
			<?php if(count($transacoes_do_usuario) > 0){  ?>
			<tr>
				<td>Operação</td>
				<td>Valor</td>
				<td>Created_at</td>
				<td>Updated_at</td>
				<td>#</td>
			</tr>
			<?php
				foreach ($transacoes_do_usuario as $key => $value) {
			?>
			<tr>
				<td><?php echo $value['operacao']; ?></td>
				<td><?php echo $value['valor']; ?></td>
				<td><?php echo $value['created_at']; ?></td>
				<td><?php echo $value['updated_at']; ?></td>
				<td><a class="excludeHere" href="<?php echo INCLUDE_PATH ?>listar-transacao-usuario?excluir=<?php echo $pagina_atual.'*'.$id_escolhido.'*'.$filtro.'*'.$value['id']; ?>">Excluir</a></td>
			</tr>
			<?php }
				}else{ ?>
				<div class="Falha">
					<h1>Não existe operações nesse mês</h1>
				</div>
			<?php } ?>
		</table>
		<?php if(count($transacoes_do_usuario) > 0){  ?>
		<div class="box-paginacao">
			<?php
				$total_de_paginas=ceil(count(requisicaoParaApi('todasTransacoes',array('id'=>$id_escolhido))) / $informacoes_por_pagina);
				for ($pagina= 1; $pagina <= $total_de_paginas; $pagina++) {
					if($pagina == $pagina_atual){
						echo '<a class="pagina-selecionada" href="'.INCLUDE_PATH.'listar-transacao-usuario?paginacao='.$pagina.'*'.$id_escolhido.'*'.$filtro.'">'.$pagina.'</a>';
					}else{
						echo '<a href="'.INCLUDE_PATH.'listar-transacao-usuario?paginacao='.$pagina.'*'.$id_escolhido.'*'.$filtro.'">'.$pagina.'</a>';
					}
				}
			?>
		</div>
		<div class="gerar-csv">
			<a href="listar-transacao-usuario?gerar-csv=<?php echo $pagina_atual.'*'.$id_escolhido.'*'.$filtro ?>">Gerar csv</a>
		</div>
		<?php if(isset($arquivoCSV) && $arquivoCSV['resultado'] == 'verdadeiro'){ ?>
			<div class="Sucesso">
				<h1>Arquivo criado com sucesso</h1>
			</div>
		<?php }else if(isset($arquivoCSV) && $arquivoCSV['resultado'] == 'falso'){ ?>
			<div class="Falha">
				<h1>Falha ao criar arquivo, tente novamente</h1>
			</div>
		<?php } ?>
		<?php if(isset($excluir) && $excluir['resultado'] == 'verdadeiro'){ ?>
			<div class="Sucesso">
				<h1>Transação excluida com sucesso</h1>
			</div>
		<?php }else if(isset($excluir) && $excluir['resultado'] == 'falso'){ ?>
			<div class="Falha">
				<h1>Falha ao excluir transação, tente novamente</h1>
			</div>
		<?php } ?>
		<?php } ?>
	<?php }else if(isset($respostaDaRequisicao['resultado'])){ ?>
		<div class="Falha">
			<h1>Não existe um usuário com esse id</h1>
		</div>
	<?php }?>
</div>