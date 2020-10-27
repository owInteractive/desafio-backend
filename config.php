<?php 
	
	session_start();

	define('INCLUDE_PATH', 'http://localhost/OWInteractive/');

	function menuAtual($menuAtual){
		$url = explode('/', @$_GET['url'])[0];
		if($url == $menuAtual){
			echo 'class="menu-atual"';
		}
	}

	function retornarDataHoraAtuais(){
		date_default_timezone_set('America/Sao_Paulo');
		return date('Y-m-d H:i:s');
	}

	function retornarDataCsv(){
		date_default_timezone_set('America/Sao_Paulo');
		return date('Y;m;d');
	}

	function retornarIdade($aniversario){
		date_default_timezone_set('America/Sao_Paulo');
		$data_atual = date_create(date('Y-m-d'));
		$data_aniversario = date_create($aniversario);
		$diferenca = date_diff($data_atual, $data_aniversario);
		$diferenca = $diferenca->format('%a');
		if($diferenca > 6575){
			return 'verdadeiro';
		}else{
			return 'falso';
		}
	}

	function retornarValorCorrigido($valorNaoCorrigido){
		$valorExplode = explode(',', $valorNaoCorrigido);
		if (isset($valorExplode[1])) {
			return ($valorExplode[0].'.'.$valorExplode[1]);
		}else{
			return $valorNaoCorrigido;
		}
	}

	function mostrarValor($valorDoBanco){
		$valorExplode = explode('.', $valorDoBanco);
		if (isset($valorExplode[1])) {
			return ($valorExplode[0].','.$valorExplode[1]);
		}else{
			return $valorDoBanco;
		}
	}

	function retornar_saldo_atual($id){
		$respostaDaRequisicao = requisicaoParaApi('saldoAtual', array('id'=>$id));
		$saldo_para_retornar = 0;
		foreach ($respostaDaRequisicao as $key => $value) {
			if($value['soma'] == null)
				$saldo_para_retornar = 0;
			else
				$saldo_para_retornar = $value['soma'];
		}
		return $saldo_para_retornar;
	}

	function gerarArquivoCsv($id, $respostaDaRequisicao, $filtro){
		
		return array('resultado'=>'verdadeiro');
	}

	function requisicaoParaApi($requisicaoEscolhida, $array = ''){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, "http://localhost/OWInteractive/request.php");
		curl_setopt($curl, CURLOPT_POST, 1);


		if($requisicaoEscolhida == 'selecionarTodosUsuario'){
			curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array('request' => 'retornar_todos')));
		}
		else if($requisicaoEscolhida == 'listar_um_usuario'){
			curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array('request' => 'retornar_um_usuario','id'=>$array['id'])));
		}
		else if($requisicaoEscolhida == 'cadastrarUsuario'){
			curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array('request' => 'cadastrar_usuario',
			'name'=>$array['name'],'email'=>$array['email'],'birthday'=>$array['birthday'],
			'created_at'=>$array['created_at'],'updated_at'=>$array['updated_at'],'saldo_inicial'=>$array['saldo_inicial'])));
		}
		else if($requisicaoEscolhida == 'excluirUsuario'){
			curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array('request' => 'excluir_um_usuario','id'=>$array['id'])));
		}
		else if($requisicaoEscolhida == 'cadastrarOperacao'){
			curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array('request' => 'cadastrar_operacao','id'=>$array['id'],'operacao'=>$array['operacao'],'valor'=>$array['valor'],'created_at'=>$array['created_at'],'updated_at'=>$array['updated_at'])));
		}
		else if($requisicaoEscolhida == 'todasTransacoes'){
			curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array('request' => 'todas_transacoes','id'=>$array['id'])));
		}
		else if($requisicaoEscolhida == 'transacoesDoUsuario'){
			curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array('request' => 'transacoes_do_usuario','id'=>$array['id'],'inicio'=>$array['inicio'],'fim'=>$array['fim'])));
		}
		else if($requisicaoEscolhida == 'transacoesUltimos30Dias'){
			curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array('request' => 'transacoes_ultimos_30_dias','id'=>$array['id'],'inicio'=>$array['inicio'],'fim'=>$array['fim'])));
		}
		else if($requisicaoEscolhida == 'transacaoDoMes'){
			curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array('request' => 'transacao_do_mes','id'=>$array['id'],'inicio'=>$array['inicio'],'fim'=>$array['fim'],'mes'=>$array['mes'])));
		}
		else if($requisicaoEscolhida == 'excluirTransacao'){
			curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array('request' => 'excluir_transacao','id'=>$array['id'])));
		}
		else if($requisicaoEscolhida == 'alterarSaldoInicial'){
			curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array('request' => 'alterar_saldo_inicial','id'=>$array['id'],'novo_valor'=>$array['novo_valor'])));
		}
		else if($requisicaoEscolhida == 'saldoAtual'){
			curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array('request' => 'saldo_atual','id'=>$array['id'])));
		}
		else if($requisicaoEscolhida == 'gerarCSV'){
			curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array('request' => 'gerar_csv','id'=>$array['id'],'respostaDaRequisicao'=>$array['valores'],'filtro'=>$array['filtro'])));
		}

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$resposta_da_requisicao = curl_exec($curl);
		curl_close($curl);
		//print_r($resposta_da_requisicao);
		$resultado_json = json_decode($resposta_da_requisicao, true);
		return $resultado_json;
	}
	
 ?>