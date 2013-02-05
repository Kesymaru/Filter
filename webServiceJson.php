﻿<?php
ini_set("default_socket_timeout", 900);
ini_set('soap.wsdl_cache_enabled', 0);
ini_set("connection_timeout", 900);
date_default_timezone_set('America/Costa_Rica');

$username = $_GET['username'];
$password = $_GET['password'];



if($_GET['action'] == 'vehiculos'){
	if(strcmp($username, "ipurdy") != 0 || strcmp($password, "12345678") != 0){	
		echo '"error":'.json_encode('credenciales invalidas');	
	}else{
		$WebService="http://190.7.202.76:8088/WS_iPurdy/iPurdy.asmx?WSDL";
		//parametros de la llamada
		$parametros = array('tipo' => '','estado' => '', 'asesor' => '', 'sucursal' => '', 'unidad' => '');
		
		try{
			//Invocación al web service
			$WS = @new SoapClient($WebService, array('trace' => 1, "exceptions" => 1));
		}catch(SoapFault $E){ 
			echo $E->faultstring;
		}catch(Exception $e) {
			echo $e->getMessage();
		}
		
		try{
			//recibimos la respuesta dentro de un objeto
			$result = $WS->ConsultaInfoUnidad($parametros);
		}catch(SoapFault $e){
			echo $e->getMessage();
			echo "Exception: "; print_r($e);
		}catch(Exception $e) {
			echo $e->getMessage();
			echo "Exception: "; print_r($e);
			echo $result->error;
		}
	
		//Mostramos el resultado de la consulta
		$xml = simplexml_load_string($result->xml->any);
		header('content-type: application/json; charset=utf-8');
		echo json_encode($xml);
	}
}elseif($_GET['action'] == 'reservas'){
	$WebService="http://190.7.202.76:8088/WS_iPurdy/iPurdy.asmx?WSDL";
	$parametros = array('unidad' => '');
	try {
		//Invocación al web service
		$WS = new SoapClient($WebService, array('trace' => 1));
	}catch(SoapFault $e){
		echo $e->getMessage();
		echo "Exception: "; print_r($e);
	}catch(Exception $e) {
		echo $e->getMessage();
		echo "Exception: "; print_r($e);
	}
	try {
		//recibimos la respuesta dentro de un objeto
		$result = $WS->ConsultaReservaUnidad($parametros);
	}catch(SoapFault $e){
		echo $e->getMessage();
		echo "Exception: "; print_r($e);
	}catch(Exception $e) {
		echo $e->getMessage();
		echo "Exception: "; print_r($e);
	}

	$xml = simplexml_load_string($result->xml->any);
	header('content-type: application/json; charset=utf-8');
	echo stripcslashes(json_encode($xml));
}else{
	header('content-type: application/json; charset=utf-8');
	echo '"error":'.json_encode('accion invalida');
}