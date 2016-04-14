<?php
class conex{ 
	public static function con(){                
                $conexion = new PDO('pgsql:host=localhost;port=5432;dbname=convocatorias', 'postgres', '1234');
                $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
		if(!$conexion){
			return false;	
		}else{
			return $conexion;	
		}
	}	
}
?>