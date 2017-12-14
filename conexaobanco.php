<?php

function abreBanco(){

	$host = "localhost";
	$user = "William1994";
	$pass = "william";
	$banco = "sistematarefas";
	$con = mysqli_connect($host, $user, $pass, $banco);

	return $con;
}

?>