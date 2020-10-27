<?php 
	
	class MySql{

		private static $pdo;

		public static function connect(){
			if(self::$pdo == null){
				try{
					self::$pdo = new PDO('mysql:host=localhost;dbname=owinteractive','root','',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
				}catch(Exception $e){
					echo "<h2>Erro ao conectar</h2>";
				}
			}

			return self::$pdo;
		}

	}

 ?>