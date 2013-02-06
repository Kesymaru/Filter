<?php
ini_set("default_socket_timeout", 900);
ini_set('soap.wsdl_cache_enabled', 0);
ini_set("connection_timeout", 900);
date_default_timezone_set('America/Costa_Rica');

error_reporting(E_ALL);

/**
* VALIDA EL USUARIO
*/

//if( isset($_GET['username']) && isset($_GET['password']) ){
if(true){
	//$username = $_GET['username'];
	//$password = $_GET['password'];
	

	$filtro = '';
	$acciones = array('99999', '99998', '99997');
	$usuarios = array( array('username' => 'IPURDY', 'password' => 'GPM2013'), array('username' => 'IPURDYL', 'password' => 'LEXUS2013'), array('username' => 'IPURDYPM', 'password' => 'PMCR2013'), array('username' => 'TEST', 'password' => 'TESTPASS') );

	$WebService="http://190.7.202.76:8070/?WSDL";
	//$WebService="http://190.7.202.76:8088/WS_iPurdy/iPurdy.asmx?WSDL";

	//parametros de la llamada
	//$parametros = array( 'compania' => 'PURDYMO', 'usuario' => $username, 'password' => $password, 'accion' => '', 'error' => '');
	$parametros = array( 'compania' => 'PURDYMO', 'usuario' => '', 'password' => '', 'accion' => '', 'error' => '');

	try{
		//Invocación al web service
		$WS = @new SoapClient($WebService, array('trace' => 1, "exceptions" => 1));
	}catch(SoapFault $E){ 
		echo $E->faultstring;
	}catch(Exception $e) {
		echo $e->getMessage();
	}
		
	try{
		echo '<table><tr><td>Username</td><td>Password</td><td>Accion</td><td>Resultado</td></tr>';

		foreach ($usuarios as $key => $usuario) {
			$parametros['username'] = $usuario['username'];
			$parametros['password'] = $usuario['password'];
			
			foreach ($acciones as $accion) {
				$parametros['accion'] = $accion;
				if( $WS->ValidarUsuario($parametros) ){
					echo '<tr><td>'.$parametros['username'].'</td><td>'.$parametros['password'].'</td><td>'.$parametros['accion'].'</td><td>TRUE</td></tr>';
				}else{
					echo '<tr><td>'.$parametros['username'].'</td><td>'.$parametros['password'].'</td><td>'.$parametros['accion'].'</td><td>FALSE</td></tr>';
				}
			}
		}

	}catch(SoapFault $e){
		echo $e->getMessage();
		echo "Exception: "; print_r($e);
	}catch(Exception $e) {
		echo $e->getMessage();
		echo "Exception: "; print_r($e);
		echo $result->error;
	}

	/*if( $filtro == ''){
		echo 'Error: datos invalidos';
	}else{
		echo $filtro;
	}*/
}else{
	header('content-type: application/json; charset=utf-8');
	echo '"error":'.json_encode('accion datos invalidos');
}

/*

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
}*/