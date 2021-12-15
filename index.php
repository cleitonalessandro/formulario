<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title> Desafio CPT</title>
		<style>
			.titulo{
				text-align: center;
				font-family: sans-serif;
			}
			.formulario{
				margin:auto;
				width:50%;
				border:3px solid black;
				border-radius: 10px;
				padding:10px;
				background-color: #DCDCDC;
			}
			.form{
				margin:10px;
			}
			input, textarea {
				display: block;
				width:98%;
				padding:8px;
			}
			.enviar{
				width:45%;
				background-color:#228B22;
				border-radius:10px;
				font-family:bold;
				font-color:yellow;
				border: 1px solid transparent;
				font-size: 20px;
				cursor:pointer;
				color:#F8F8FF;
				float: left;
				margin:10px;
			}
			.reset{
				width:45%;
				background-color:#B22222;
				border-radius:10px;
				font-family:bold;
				font-color:yellow;
				border: 1px solid transparent;
				font-size: 20px;
				cursor:pointer;
				color:#F8F8FF;
				float: center;
				margin:10px;
			}
		</style>
		<script>
			//Mascara de telefone
			function mascara(o,f){
				v_obj=o
				v_fun=f
				setTimeout("execmascara()",1)
			}
			function execmascara(){
				v_obj.value=v_fun(v_obj.value)
			}
			function mtel(v){
				v=v.replace(/\D/g,""); //Remove tudo o que não é dígito
				v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
				v=v.replace(/(\d)(\d{4})$/,"$1-$2"); //Coloca hífen entre o quarto e o quinto dígitos
				return v;
			}
			function id( el ){
				return document.getElementById( el );
			}
			window.onload = function(){
				id('telefone').onkeyup = function(){
					mascara( this, mtel );
				}
			}
		</script>
	</head>
	<body>
		<div>
			<h2 class="titulo"> Fomulário de Cadastro</h2>
		</div>
		<div class="formulario">
			<form method="post" action="">
				<div class="form">
					<label> Nome</label>
					<input type="text" name="nome" required>
				</div>
				<div class="form">	
					<label> E-mail </label>
					<input type="email" name="email" required>
				</div>
				<div class="form">
					<label>Telefone</label>
					<input type="text" name="telefone" placeholder="Insira o numero com o ddd" id="telefone" maxlength="15" required>
				</div>
				<div class="form">
					<label> Assunto</label>
					<input type="text" name="assunto" required>
				</div>
				<div class="form">
					<label> Mensagem</label>
					<textarea name="mensagem"></textarea>
				</div>
				<div class="form">
					<button type="submit" name="enviar" class="enviar">Enviar Dados</button>
					<button type="reset" class="reset"> Apagar Dados</button>
				</div>
			</form>
		</div>	
	</body>
</html>
<?php
	if(isset($_POST['enviar'])){
		//conexão com o banco de dados
		$username="root";
		$password="";
		try {
			$conn = new PDO('mysql:host=localhost;dbname=cpt', $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e) {
			echo 'ERROR: ' . $e->getMessage();
		}
		//pegando os dados do formulario
		$nome  = $_POST['nome'];
		$email = $_POST['email'];
		$telefone = $_POST['telefone'];
		$assunto  = $_POST['assunto'];
		$mensagem = $_POST['mensagem'];
		//inserindo no banco de dados 
		$sql= $conn->prepare("INSERT INTO `tbl_contato`( `nome`, `email`, `telefone`, `assunto`, `mensagem`) VALUES(:nome,:email,:telefone, :assunto,:mensagem)");
		$sql->bindParam('nome', $nome, PDO::PARAM_STR);
		$sql->bindParam('email', $email, PDO::PARAM_STR);
		$sql->bindParam('telefone', $telefone, PDO::PARAM_STR);
		$sql->bindParam('assunto', $assunto, PDO::PARAM_STR);
		$sql->bindParam('mensagem', $mensagem, PDO::PARAM_STR);
		$sql->execute();
		
		if($sql->rowCount()){
			echo "<script language='javascript'>";
			echo 'alert("Cadastro realizado com sucesso!!");';
			echo 'window.location.replace("index.php");';
			echo "</script>";
		}else{
			echo "<script language='javascript'>";
			echo 'alert("Cadastro não realizado!!");';
			echo 'window.location.replace("index.php");';
			echo "</script>";
		}
	}
?>