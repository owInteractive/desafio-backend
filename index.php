<?php include('config.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Aota</title>
	<meta charset="utf-8">
	<meta name="keywords" content="aota,desenvolvimento,aplicativo,criação,consultoria">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<section class="container">
	<div class="w-25 left etapas">
		<h1>OW Interactive</h1>
		<h2>Usuarios</h2>
		<a <?php menuAtual('adcionar-usuario'); ?> 
			href="<?php echo INCLUDE_PATH.'adcionar-usuario' ?>">Cadastrar usuario</a>
		<a <?php menuAtual('listar-todos-usuarios'); ?> 
			href="<?php echo INCLUDE_PATH.'listar-todos-usuarios' ?>">Listar todos os usuarios</a>
		<a <?php menuAtual('listar-usuario'); ?>
			href="<?php echo INCLUDE_PATH.'listar-usuario' ?>">Listar um usuario</a>
		<h2>Financeiro</h2>
		<a <?php menuAtual('adcionar-transacao'); ?>
			href="<?php echo INCLUDE_PATH.'adcionar-transacao' ?>">Adcionar uma transação</a>
		<a <?php menuAtual('listar-transacao-usuario'); ?>
			href="<?php echo INCLUDE_PATH.'listar-transacao-usuario' ?>">Transações de um usuario</a>
		<a <?php menuAtual('mudar-saldo-inicial'); ?>
			href="<?php echo INCLUDE_PATH.'mudar-saldo-inicial' ?>">Alterar saldo inicial</a>
		<h2></h2>
		<a <?php menuAtual('home'); ?>
			href="<?php echo INCLUDE_PATH.'home' ?>">Home</a>
		<a <?php menuAtual('listar-arquivos-csv'); ?>
			href="<?php echo INCLUDE_PATH.'listar-arquivos-csv' ?>">Arquivos csv</a>
	</div>
	<?php 
		$url = isset($_GET['url']) ? $_GET['url'] : 'home';
		if(file_exists('pages/'.$url.'.php')){
			include('pages/'.$url.'.php');
		}else{
			//podemos fazer oq quiser pq a pagina não existe
			include('pages/404.php');
		}
	?>
	<div class="clear"></div>
</section>
</body>
</html>