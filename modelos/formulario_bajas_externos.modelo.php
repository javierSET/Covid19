<?php

require_once "conexion.db.php";

class ModeloFormularioBajasExterno{

    static public function mdlMostrarFormularioBajasExterno($tabla, $item, $valor){
        if($item != null){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
            $stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt->execute();
            $respuesta = $stmt->fetch();
        }else{
            $respuesta = "";
        }                
        return $respuesta;
    }

    /*=====================================================================
            REGISTRA A LOS PACIENTES QUE TIENEN LABORATORIO EXTERNO
    =======================================================================*/
    static public function mdlIngresarFormularioBajaExterno($tabla, $data){
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("INSERT INTO $tabla(id_pacientes_asegurados, id_personas_notificadores, id_formulario_baja)VALUES(:id_pacientes_asegurados,:id_personas_notificadores, :id_formulario_baja)");
        $stmt->bindParam(":id_pacientes_asegurados", $data["id_pacientes_asegurados"],PDO::PARAM_INT);
        $stmt->bindParam(":id_personas_notificadores", $data["id_personas_notificadores"],PDO::PARAM_INT);
        $stmt->bindParam(":id_formulario_baja", $data["id_formulario_baja"],PDO::PARAM_INT);
        
        if($stmt->execute()){
            $respuesta = $stmt->fetch();
        }
        else{
            $respuesta = $stmt->errorInfo();
        }
        return $respuesta;
    }

    /*=====================================================================
            REGISTRA UNA BAJA POR SOSPECHOSO-COVID
    =======================================================================*/
    static public function mdlIngresarFormularioBajaSospechoso($tabla, $data){
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("INSERT INTO $tabla(id_pacientes_asegurados, id_personas_notificadores, tipo_baja, id_ficha, id_formulario_baja)VALUES(:id_pacientes_asegurados, :id_personas_notificadores, :tipo_baja, :id_ficha, :id_formulario_baja)");
        $stmt->bindParam(":id_pacientes_asegurados", $data["id_pacientes_asegurados"],PDO::PARAM_INT);
        $stmt->bindParam(":id_personas_notificadores", $data["id_personas_notificadores"],PDO::PARAM_INT);
        $stmt->bindParam(":tipo_baja", $data["tipo_baja"],PDO::PARAM_STR);
        $stmt->bindParam(":id_ficha", $data["id_ficha"],PDO::PARAM_INT);
        $stmt->bindParam(":id_formulario_baja", $data["id_formulario_baja"],PDO::PARAM_INT);
        
        if($stmt->execute()){
            $respuesta = 'ok';
        }
        else{
            $respuesta = 'error';
        }
        return $respuesta;
    }

    /*======================================================================
                BORRAR REGISTRO DE FORMULARIO BAJA EXTERNO
    ========================================================================*/

    static public function mdlEliminarFormularioBajaExterno($tabla,$item ,$valor){
		$pdo = Conexion::conectar();
		$stmt = $pdo->prepare("DELETE FROM $tabla WHERE $item = :$item");
		$stmt->bindParam(":".$item, $valor, PDO::PARAM_INT);
		if($stmt->execute()){
			$respuesta = $stmt->fetch();
		}else{
			$respuesta = $stmt->errorInfo();
		}
		return $respuesta;
	}

    /*======================================================================
                OBTENER EL ID DEL PACIENTE
    ========================================================================*/

    static public function mdlObtenerIdPaciente($tabla,$item ,$valor){
		$pdo = Conexion::conectar();
		$stmt = $pdo->prepare("SELECT id_pacientes_asegurados FROM $tabla WHERE $item = :$item;");
		$stmt->bindParam(":".$item, $valor, PDO::PARAM_INT);
		if($stmt->execute()){
			$respuesta = $stmt->fetch();
		}else{
			$respuesta = null;
		}
		return $respuesta;
	}
}
?>