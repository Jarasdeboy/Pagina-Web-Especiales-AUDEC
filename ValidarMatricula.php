<?php 
include("class_Db.php");

	class validaciones extends class_Db{

		function __construct()
		{
			parent::__construct();
		}

		function __destruct()
		{
        	parent::__destruct();

		}


		public function ValidarMatricula($mat){
			$sql = "SELECT count(matricula) FROM alumnos WHERE matricula = '$mat'";
    		$response = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn).$sql);
    		$resultado = mysqli_fetch_assoc($response);
    		return $resultado;
		}


}

$dame = new validaciones();
$final = $dame->ValidarMatricula(21842);
echo($final);


?>