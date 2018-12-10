<?php
namespace controllers{
	class SubCategoria{
		//Atributo para banco de dados
		private $PDO;

		/*
		__construct
		Conectando ao banco de dados
		*/
		function __construct(){
			$this->PDO = new \PDO('mysql:host=dtweb.com.br;dbname=dtweb289_componentes; charset=UTF8', 'dtweb289_compone', 'componentes123'); //Conexão
			$this->PDO->setAttribute( \PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION ); //habilitando erros do PDO
		}
		public function lista(){
			global $app;
			$sth = $this->PDO->prepare("SELECT * FROM dtweb289_componentes.sub_categoria;");
			$sth->execute();
			$result = $sth->fetchAll(\PDO::FETCH_ASSOC);
			$app->render('default.php',["data"=>$result],200); 
		}
		
		public function editar($id){
			global $app;
			$dados = json_decode($app->request->getBody(), true);
			$dados = (sizeof($dados)==0)? $_POST : $dados;
			$sets = [];
			foreach ($dados as $key => $VALUES) {
				$sets[] = $key." = :".$key;
			}
 
			$sth = $this->PDO->prepare("UPDATE dtweb289_componentes.sub_categoria SET ".implode(',', $sets)." WHERE id = :id");
			$sth ->bindValue(':id',$id);
			foreach ($dados as $key => $value) {
				$sth ->bindValue(':'.$key,$value);
			}
			//Retorna status da edição
			$app->render('default.php',["data"=>['status'=>$sth->execute()==1]],200); 
		}

		public function nova(){
			global $app;
			$dados = json_decode($app->request->getBody(), true);
			$dados = (sizeof($dados)==0)? $_POST : $dados;
			$keys = array_keys($dados); //Paga as chaves do array
			/*
			O uso de prepare e bindValue é importante para se evitar SQL Injection
			*/
			$sth = $this->PDO->prepare("INSERT INTO dtweb289_componentes.sub_categoria (".implode(',', $keys).") VALUES (:".implode(",:", $keys).")");
			foreach ($dados as $key => $value) {
				$sth ->bindValue(':'.$key,$value);
			}
			$sth->execute();
			//Retorna o id inserido
			$app->render('default.php',["data"=>['id'=>$this->PDO->lastInsertId()]],200); 
		}

		/*
		get
		Pega receita pelo id
		*/
		public function get($id){
			global $app;
			$sth = $this->PDO->prepare("SELECT * FROM dtweb289_componentes.sub_categoria where id = :id");
			$sth ->bindValue(':id',$id);
			$sth->execute();
			$result = $sth->fetch(\PDO::FETCH_ASSOC);
			$app->render('default.php',["data"=>$result],200); 
		}
		
		public function excluir($id){
			global $app;
			$sth = $this->PDO->prepare("DELETE FROM dtweb289_componentes.sub_categoria where id = :id");
			$sth ->bindValue(':id',$id);
			$app->render('default.php',["data"=>['status'=>$sth->execute()==1]],200); 
		}



	}
}