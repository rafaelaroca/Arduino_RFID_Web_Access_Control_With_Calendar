<?php

//Answers Arduino HTTP queries if a RFID card is allowed or not to open the Lab door

$card=$_GET["card"];

/*
//Versao que autoriza o cartao de forma fixa, para teste

if (strpos($card, 'B8') !== false) {
	echo "LIBERADO";
	file_put_contents("/tmp/log-rfid.txt", "Liberado: $card\r\n", FILE_APPEND);

}
else {
	echo "NEGADO";
	file_put_contents("/tmp/log-rfid.txt", "Negado: $card\r\n", FILE_APPEND);
}
*/

//Versao com banco de dados!


$servername = "localhost";
$username = "MySQL_database_user";
$password = "MySQL_database_password;
$dbname = "controle_acesso";

$conn = mysqli_connect($servername, $username, $password, $dbname);

file_put_contents("/tmp/log-rfid.txt", "[" . date("Y/m/d H:i:s") . "] Verificando cartao no banco de dados: $card\r\n", FILE_APPEND);

if($conn)
{
	//Dia da semana
	//echo "Dia = " . date('w');
	$dia=date('w');
	//1 = segunda; 2 = terca; 3=quarta; 4=quinta; 5=sexta; 6=sab; 7=domg
	//10 = todos
	//O select abaixo ja seleciona apenas o cartao que pode no dia correto ou o 10, que pode em todos dias


	$cardt = ltrim($card); //TODO - Treat SQL Injection - not a problem now, as the system is in a closed/private/limited network
	$sql = "SELECT * FROM cards WHERE card = \"$cardt\" AND (dia_semana=$dia or dia_semana=10)";

	//TODO, verificar se o horario ta certo

	file_put_contents("/tmp/log-rfid.txt", "SQL = " . $sql . "\r\n", FILE_APPEND);
	$result = mysqli_query($conn, $sql);

	$desc = "Acesso negado";
	if (mysqli_num_rows($result) > 0)
	{
		//Verifica se o horario eh permitido
		$row = mysqli_fetch_assoc($result);
		$hora_ini = $row["horario_ini"];
		$hora_fim = $row["horario_fim"];

		//Hora e minuto no formato HH:MM, por exemplo, 23:51
		$hora_minuto = date('H:i');

		file_put_contents("/tmp/log-rfid.txt", "Horario autorizado: $hora_ini ate $hora_fim / Agora $hora_minuto\r\n", FILE_APPEND);

		if(( strtotime($hora_minuto)>=strtotime($hora_ini)) && ( strtotime($hora_minuto)<=strtotime($hora_fim)) ) {
		
			echo "LIBERADO";
			$desc = "Acesso liberado";
			file_put_contents("/tmp/log-rfid.txt", "[" . date("Y/m/d H:i:s") . "] Autorizado: $card\r\n", FILE_APPEND);

		}
		else {
			echo "NEGADO";
			$desc = "Acesso negado - fora de horario";
			file_put_contents("/tmp/log-rfid.txt", "[" . date("Y/m/d H:i:s") . "] Negado, fora de horario: $card\r\n", FILE_APPEND);

		}
	}
	else
	{
		echo "NEGADO";
		$desc = "Acesso negado";
		file_put_contents("/tmp/log-rfid.txt", "[" . date("Y/m/d H:i:s") . "] Negado: $card\r\n", FILE_APPEND);
	}

	$sql = "INSERT INTO logs(instante, cartao, descricao) values(now(), \"$cardt\", \"$desc\")";

	file_put_contents("/tmp/log-rfid.txt", "Log SQL = " . $sql . "\r\n", FILE_APPEND);
	$result = mysqli_query($conn, $sql);

}


?>
