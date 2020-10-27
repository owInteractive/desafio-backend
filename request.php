<?php
	include('classes/MySql.php');
	include('config.php');
	if (isset($_POST['request'])) {
		if ($_POST['request'] == 'retornar_todos') {
			$sql = MySql::connect()->prepare("SELECT * FROM `usuarios` ORDER BY created_at ASC");
			$sql->execute();
			$sql = $sql->fetchAll();
			die(json_encode($sql));
		}
		else if($_POST['request'] == 'retornar_um_usuario'){
			$sql = MySql::connect()->prepare("SELECT * FROM `usuarios` WHERE id = ?");
			$sql->execute(array($_POST['id']));
			$sql = $sql->fetchAll();
			$numero_linhas = 0;
			foreach ($sql as $key => $value) {
				$numero_linhas = $numero_linhas + 1;
			}
			if ($numero_linhas > 0) {
				die(json_encode($sql));
			}else{
				die(json_encode(array('resultado' => 'falso')));
			}
		}
		else if($_POST['request'] == 'cadastrar_usuario'){
			$mail = $_POST['email'];
			$mail = str_replace('%40', '@', $mail);
			$maior_de_idade = retornarIdade($_POST['birthday']);
			if($maior_de_idade == 'verdadeiro'){
				$sql = MySql::connect()->prepare("INSERT INTO `usuarios` VALUES (DEFAULT,?,?,?,?,?,?)");
				if($sql->execute(array($_POST['name'],$mail,$_POST['birthday'],$_POST['created_at'],
					$_POST['updated_at'],$_POST['saldo_inicial'])))
				{
					die(json_encode(array('resultado' => 'verdadeiro')));
				}else{
					die(json_encode(array('resultado' => 'falso')));
				}
			}else{
				die(json_encode(array('resultado' => 'menor_idade')));
			}
			
		}
		else if($_POST['request'] == 'excluir_um_usuario'){
			$sql = MySql::connect()->prepare("SELECT * FROM operacoes WHERE id_usuario = ?");
			$sql->execute(array($_POST['id']));
			$sql = $sql->fetchAll();
			if (count($sql) == 0){
				$sql = MySql::connect()->prepare("DELETE FROM `usuarios` WHERE id = ?");
				$sql->execute(array($_POST['id']));
				die(json_encode(array('resultado' => 'verdadeiro')));
			}else{
				die(json_encode(array('resultado' => 'falso')));
			}
		}
		else if($_POST['request'] == 'cadastrar_operacao'){
			$sql = MySql::connect()->prepare("SELECT * FROM `usuarios` WHERE id = ?");
			$sql->execute(array($_POST['id']));
			$sql = $sql->fetchAll();
			$numero_linhas = 0;
			foreach ($sql as $key => $value) {
				$numero_linhas = $numero_linhas + 1;
			}
			if ($numero_linhas > 0) {
				//caso exista o usuario, cadastre a operacao
				$sql = MySql::connect()->prepare("INSERT INTO `operacoes` VALUES(DEFAULT,?,?,?,?,?)");
				$sql->execute(array($_POST['id'],$_POST['operacao'],$_POST['valor'],$_POST['created_at'],$_POST['updated_at']));
				die(json_encode(array('resultado' => 'verdadeiro')));
			}else{
				die(json_encode(array('resultado' => 'falso')));
			}
		}
		else if($_POST['request'] == 'todas_transacoes'){
			$sql = MySql::connect()->prepare("SELECT * FROM `operacoes` WHERE id_usuario = ?");
			if ($sql->execute(array($_POST['id']))) {
				$sql = $sql->fetchAll();
				die(json_encode($sql));
			}else{
				die(json_encode(array('resultado' => 'falso')));
			}
		}
		else if($_POST['request'] == 'transacoes_do_usuario'){
			$inicio = $_POST['inicio'];
			$fim = $_POST['fim'];
			$sql = MySql::connect()->prepare("SELECT * FROM `operacoes` WHERE id_usuario = ? ORDER BY created_at ASC LIMIT $inicio,$fim");
			if ($sql->execute(array($_POST['id']))) {
				$sql = $sql->fetchAll();
				die(json_encode($sql));
			}else{
				die(json_encode(array('resultado' => 'falso')));
			}
		}
		else if($_POST['request'] == 'transacoes_ultimos_30_dias'){
			$inicio = $_POST['inicio'];
			$fim = $_POST['fim'];
			$sql = MySql::connect()->prepare("SELECT * FROM `operacoes` WHERE id_usuario = ? and updated_at BETWEEN DATE_ADD(CURRENT_DATE(), INTERVAL -30 DAY) AND CURRENT_DATE() ORDER BY created_at ASC LIMIT $inicio,$fim");
			if ($sql->execute(array($_POST['id']))) {
				$sql = $sql->fetchAll();
				die(json_encode($sql));
			}else{
				die(json_encode(array('resultado' => 'falso')));
			}
		}
		else if($_POST['request'] == 'transacao_do_mes'){
			$inicio = $_POST['inicio'];
			$fim = $_POST['fim'];
			$data = explode('-', $_POST['mes']);
			$month = $data[1];
			$year = $data[0];
			$sql = MySql::connect()->prepare("SELECT * FROM `operacoes` WHERE id_usuario = ? AND MONTH(created_at) = $month  AND YEAR(created_at) = $year ORDER BY created_at ASC LIMIT $inicio,$fim");
			if ($sql->execute(array($_POST['id']))) {
				$sql = $sql->fetchAll();
				die(json_encode($sql));
			}else{
				die(json_encode(array('resultado' => 'falso','mes'=>$month,'year'=>$year,'data'=>$_POST['mes'])));
			}
		}
		else if($_POST['request'] == 'excluir_transacao'){
			$sql = MySql::connect()->prepare("DELETE FROM `operacoes` WHERE id = ?");
			if ($sql->execute(array($_POST['id']))) {
				die(json_encode(array('resultado' => 'verdadeiro')));
			}else{
				die(json_encode(array('resultado' => 'falso')));
			}
		}
		else if($_POST['request'] == 'alterar_saldo_inicial'){
			$novo_valor = $_POST['novo_valor'];
			if(is_numeric($novo_valor)){
				$sql = MySql::connect()->prepare("UPDATE `usuarios` SET `saldo_inicial` = ? WHERE id = ?");
				if ($sql->execute(array($novo_valor, $_POST['id']))) {
					die(json_encode(array('resultado' => 'verdadeiro')));
				}else{
					die(json_encode(array('resultado' => 'falso')));
				}
			}else{
				die(json_encode(array('resultado' => 'falso')));
			}
		}
		else if($_POST['request'] == 'saldo_atual'){
			$sql = MySql::connect()->prepare("SELECT SUM(operacoes.valor) + usuarios.saldo_inicial AS soma FROM `usuarios` INNER JOIN `operacoes` WHERE usuarios.id = ? AND operacoes.id_usuario = ?");
			$sql->execute(array($_POST['id'], $_POST['id']));
			$sql = $sql->fetchAll();
			die(json_encode($sql));
		}
		else if($_POST['request'] == 'gerar_csv'){
			$data = retornarDataCsv();
			$nome = 'csv/arquivo.csv';
			$arquivo = fopen($nome, 'w');
			$dados_cliente = requisicaoParaApi('listar_um_usuario', array('id'=>$_POST['id']));
			$saldo_atual = retornar_saldo_atual($_POST['id']);
			$cabecalho = array('id','name','email','birthday','created_at','update_at','saldo_atual');
			fputcsv($arquivo, $cabecalho);
			foreach ($dados_cliente as $key) {
				$line = array('id'=>$key['id'],'name'=>$key['name'],'email'=>$key['email'],'birthday'=>$key['birthday'],'created_at'=>$key['created_at'],'updated_at'=>$key['updated_at'],'saldo_atual'=>$saldo_atual);
				fputcsv($arquivo, $line);
			}
			$cabecalho = array('id','id_usuario','operacao','valor','created_at','update_at');
			fputcsv($arquivo, $cabecalho);
			foreach ($_POST['respostaDaRequisicao'] as $key) {
				$line = array('id'=>$key['id'],'id_usuario'=>$key['id_usuario'],'operacao'=>$key['operacao'],'valor'=>$key['valor'],'created_at'=>$key['created_at'],'updated_at'=>$key['updated_at']);
				fputcsv($arquivo, $line);
			}
			fclose($arquivo);
			die(json_encode(array('resultado'=>'verdadeiro')));
		}
	}
?>