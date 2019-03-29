<?php
include("class_registro.php");
include("class_Db.php");
class registro_dal extends class_Db{

	function __construct()
	{
		parent::__construct();
	}

	function __destruct()
	{
        parent::__destruct();

	}
	//Muestra la tabla alumnos
  function get_datos_lista_alumnos(){

  $elsql = "select Matricula,Nombre,Correo,Telefono,Grado,Id_carrera,Id_materia,Estatus from Especiales order by Matricula";

  //print $elsql;exit;

  $this->set_sql($elsql);
  $lista=NULL;
  $rs=mysqli_query($this->db_conn,$this->db_query) or die (mysqli_error($this->db_conn));
  $total_de_registro=mysqli_num_rows($rs);
  $i=0;
  while($renglon=mysqli_fetch_assoc($rs)) {
    $obj_det = new registro(
    $renglon["Matricula"],
    utf8_encode($renglon["Nombre"]),
    utf8_encode($renglon["Correo"]),
    utf8_encode($renglon["Telefono"]),
    utf8_encode($renglon["Grado"]),
    $renglon["Id_carrera"],
    $renglon["Id_materia"],
    $renglon["Estatus"]
    );

    $i++;
    $lista[$i]=$obj_det;
    unset($obj_det);
  }
  mysqli_free_result($rs);
  return $lista;
}

    function existeMatricula($Matricula){
     $Matricula=$this->db_conn->real_escape_string($Matricula);

       $sql = "select count(*) as counter from Alumnos";
       $sql .= " where Matricula='$Matricula'";

       //print $sql;
       $this->set_sql($sql);
       $rs = mysqli_query($this->db_conn,$this->db_query) or die(mysqli_error($this->db_conn));
       //$total_de_registro = mysqli_num_rows($rs);
       $renglon= mysqli_fetch_assoc($rs);

       return $renglon['counter'];
     }
    function ValidarRegistroEspeciales($Matricula){
      $Matricula=$this->db_conn->real_escape_string($Matricula);

       $sql = "select count(*) as counter from especiales";
       $sql .= " where Matricula='$Matricula'";

       //print $sql;
       $this->set_sql($sql);
       $rs = mysqli_query($this->db_conn,$this->db_query) or die(mysqli_error($this->db_conn));
       //$total_de_registro = mysqli_num_rows($rs);
       $renglon= mysqli_fetch_assoc($rs);

       return $renglon['counter'];
     }



function get_datos_lista_materias(){

  $elsql = "select cve_plan, materia from alumnos GROUP BY materia;";

  //print $elsql;exit;

  $this->set_sql($elsql);
  $lista=NULL;
  $rs=mysqli_query($this->db_conn,$this->db_query) or die (mysqli_error($this->db_conn));
  $lista=mysqli_fetch_all($rs);

  //$i=0;
/*  while($renglon=mysqli_fetch_assoc($rs)) {
    $obj_det = new registro(
    $renglon["Matricula"],
    utf8_encode($renglon["Nombre"]),
    utf8_encode($renglon["Correo"]),
    utf8_encode($renglon["Telefono"]),
    utf8_encode($renglon["Grado"]),
    $renglon["Id_carrera"],
    $renglon["Id_materia"],
    $renglon["Estatus"]
    );*/
/*
    $i++;
    $lista[$i]=$obj_det;
    unset($obj_det);*/
/*  }
  mysqli_free_result($rs);*/
  return $lista;
}

function get_datos_lista_carreras(){

  $elsql = "select cve_plan NOT IN(742) as Id_carrera,
if (cve_plan=670,concat(cve_plan,'-Ingeniero En Sistemas(Antiguo)'),
if (cve_plan=686,concat(cve_plan,'-Ingeniero Industrial(Antiguo)'),
if (cve_plan=689,concat(cve_plan,'-Licenciado de Sistemas Computacionales Administrativos'),
if (cve_plan=754,concat(cve_plan,'-Ingeniero en Tecnologias de la Informacion y Comunicaciones'),
if (cve_plan=820,concat(cve_plan,'-Ingeniero Industrial y de Sistemas'),
if (cve_plan=827,concat(cve_plan,'-Ingeniero en Electronica y Comunicaciones'),
if (cve_plan=828,concat(cve_plan,'-Ingeniero en Sistemas Computacionales'),
if (cve_plan=851,concat(cve_plan,'-Ingeniero Automotriz'),'')))))))) as nombre_carrera from alumnos
  group by cve_plan";

  //print $elsql;exit;

  $this->set_sql($elsql);
  $lista=NULL;
  $rs=mysqli_query($this->db_conn,$this->db_query) or die (mysqli_error($this->db_conn));
  $lista=mysqli_fetch_all($rs);

  return $lista;
}

	    //Insertar
  	function insertar($obj){


		$sql = "insert into especiales (";
  		$sql .= "Matricula,";
        $sql .= "Nombre,";
        $sql .= "Correo,";
        $sql .= "Telefono,";
        $sql .= "Grado,";
        $sql .= "Id_carrera,";
        $sql .= "Id_materia,";
        $sql .= "Estatus";
     	$sql .= ") ";
		$sql .= "values(";
    	$sql .= "'".$obj->getMatricula()."',";
        $sql .= "'".$obj->getNombre()."',";
        $sql .= "'".$obj->getCorreo()."',";
        $sql .= "'".$obj->getTelefono()."',";
        $sql .= "'".$obj->getGrado()."', ";
        $sql .= "'".$obj->getId_carrera()."', ";
        $sql .= "'".$obj->getId_materia()."', ";
        $sql .= "'".$obj->getEstatus()."' ";
        $sql .= ")";
		//print $sql;exit;
	   	$this->set_sql($sql);
        $this->db_conn->set_charset("utf8");

    	mysqli_query($this->db_conn,$this->db_query) or die(mysqli_error($this->db_conn));

        if(mysqli_affected_rows($this->db_conn)==1) {
			$insertado=1;
			//print "insertado"."\n";
		}else{
			$insertado=0;
		}
		unset($obj);
 		return $insertado;
  	}



  /*function actualizar($obj){

    $sql = "UPDATE especiales ";
    $sql .= SET  "Matricula = '"$obj->getMatricula()"',";
    $sql .= "Nombre = '"$obj->getNombre()"',";
    $sql .= "Correo = '"$obj->getCorreo()"',";
    $sql .= "Telefono = '"$obj->getTelefono()"',";
    $sql .= "Grado = '"$obj->getGrado()"',";
    $sql .= "Id_carrera = '"$obj->getId_carrera()"',";
    $sql .= "Id_materia = '"$obj->getId_materia()"',";
    $sql .= "Estatus = '"$obj->getEstatus()"' ";
    $sql .= "WHERE Matricula = '"$obj->getMatricula()"'";

    //print $sql;exit;
    $this->set_sql($sql);
    $this->db_conn->set_charset("utf8");

    mysqli_query($this->db_conn,$this->db_query) or die(mysqli_error($this->db_conn));

    if(mysqli_affected_rows($this->db_conn)==1) {
      $actualizado=1;
      print "actualizado"."\n";
    }
    else{
      $actualizado=0;
    }
    unset($obj);
    return $actualizado;
    }*/

 /*
        //borrar
    function borrar($obj){

        $sql = "delete from especiales where Matricula='".$obj->getMatricula()."'";

        //print $sql;exit;
        $this->set_sql($sql);
        $this->db_conn->set_charset("utf8");

        mysqli_query($this->db_conn,$this->db_query) or die(mysqli_error($this->db_conn));

        if(mysqli_affected_rows($this->db_conn)==1) {
            $borrado=1;
        }else{
            $borrado=0;
        }
        unset($obj);
        return $borrado;
    }

*/  


//Muestra un campo d ela tabla alumnos segun la matricula dada
    function get_datos_by_matricula($Matricula){
      $Matricula=$this->db_conn->real_escape_string($Matricula);

        $this->set_sql("select Matricula,Nombre,Correo,Telefono,Grado,Id_carrera,Id_materia,Estatus from especiales where Matricula='$Matricula'");

        $rs = mysqli_query($this->db_conn,$this->db_query) or die(mysqli_error($this->db_conn));
        $total_de_registro = mysqli_num_rows($rs);
        $obj_det=null;
        $renglon = mysqli_fetch_assoc($rs);
        if($total_de_registro>0){
            $obj_det = new registro(
            $renglon["Matricula"],
            utf8_encode($renglon["Nombre"]),
            utf8_encode($renglon["Correo"]),
            utf8_encode($renglon["Telefono"]),
            utf8_encode($renglon["Grado"]),
            $renglon["Id_carrera"],
            $renglon["Id_materia"],
            $renglon["Estatus"]
            );
        }
        return $obj_det;
     }

}
?>
