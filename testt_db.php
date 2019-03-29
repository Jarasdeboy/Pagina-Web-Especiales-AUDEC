<?php
include("class_registro_dal.php");
//se guardan los datos del formulario en variables con el emtodo $_POST
$matricula=$_POST["imatricula"];
$nombre=$_POST["inombre"];
$correo=$_POST["icorreo"];
$telefono=$_POST["itelefono"];
$grado=$_POST["sgrado"];
$carrera=$_POST["scarrera"];
$materias=$_POST["smaterias"];
$estatus=$_POST["sestatus"];

//echo "Los datos $matricula ";

//Se crea un objeto con el constructor de class_registro mandando los datos del formulario como parametros
$obj=new registro($matricula,$nombre,$correo,$telefono,$grado,$carrera,$materias,$estatus);
//Se manda ese objeto creado($obj) mandando llamar a la funcion insertar
$obj2=new registro_dal();

$metodo = $obj2 -> existeMatricula($matricula);
$metodo2 = $obj2 -> ValidarRegistroEspeciales($matricula);

if ($metodo > 0 && $metodo2 <= 2){

	echo "<script type='text/javascript'>alert('Formulario Aceptado...')</script>";
	$resultado2=$obj2-> insertar($obj);
	echo '<script>setTimeout("window.history.go(-1)",1000);</script>';

}
else{
	echo "<script type='text/javascript'>alert('No puedes hacer mas de 2 Registros')</script>";
	echo '<script>setTimeout("window.history.go(-1)",1000)</script>';
}


/*//trae un campo por matricula
$obj3=new registro_dal();
$resultado3=$obj3->  get_datos_by_matricula(13214207);
print_r($resultado3);
*/


/*//trae la tabla alumnos
$obj4=new registro_dal();
$resultado4=$obj4-> get_datos_lista_alumnos();
print_r($resultado4);
*/



//actualiza la tabla alumnos
/*
$obj=new registro($matricula,$nombre,$correo,$telefono,$grado,$carrera,$materias,$estatus);
$resultado5 = $obj->actualizar($obj);
print_r($resultado5);

*/
?>
