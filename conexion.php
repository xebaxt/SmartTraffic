<?php
class Datos{


	private $host="localhost";
	private $password="";
	private $user="root";
	private $dbName="semaforo";

	public  function conectar(){
		$mysql = new mysqli($this->host,$this->user,$this->password,$this->dbName);
		if ($mysql->connect_error)
			die('Problemas con la conexion a la base de datos');

		return $mysql;
	}

	public function desconectar($mysql){
		$mysql->close();
		return $mysql;
	}

	public function tiempoDelSemaforo(){

		$conexion = $this->conectar();
		$query = mysqli_query($conexion,"Select id, tiempo from semaforo");
		$resultado = array();
		while ($tabla = mysqli_fetch_array($query)){
			array_push($resultado, array($tabla['id'], $tabla['tiempo']));
		}
		$this->Desconectar($conexion);
		return $resultado;
	}

	public function enviarSerial($tabla){

		for ($i = 0; $i < count($tabla); $i++){
			$velocidad = $tabla[$i];
			$cadena = "mode COM5: BAUD=9600 PARITY=N data=%s stop=1 xon=off";
			$comando =  sprintf($cadena, $velocidad);
			echo $comando;
			  $fp = fopen("COM5:", "w+");
			 if (!$fp) {
			 echo "Error al abrir COM5.";
			 } else {
			 $datos= escapeshellcmd($comando);
			 fputs ($fp,$datos);
			 fclose ($fp);
			}
		}
	}
}
$vel_a = $_REQUEST['vel_a'];
$vel_b = $_REQUEST['vel_b']; 
if ($vel_a > $vel_b){
	$vel_a = 90;
	$vel_b = 60;
}else{
	$vel_a = 60;
	$vel_b = 90;
}
$array = array($vel_a,$vel_b);

$datos = new Datos();
$datos->enviarSerial($array);

?>


