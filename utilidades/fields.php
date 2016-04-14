<?php

function verificar_campos_vacios($array){
	$i=0;
    foreach($array as $campo){
        if(empty($campo)){
            throw new Exception('Todos los campos son requeridos: ');
        }
		$i++;
    }
}

function verificarValorFloat($str){
	if(!is_numeric($str)){
		throw new Exception('El valor del monto es invalido');
	}
}

?>
    