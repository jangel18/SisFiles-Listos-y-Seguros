<?php
session_start();

//Evitamos que nos salgan los NOTICES de PHP
error_reporting(E_ALL ^ E_NOTICE);

//Comprobamos si la sesión está iniciada
//Si existe una sesión correcta, mostramos la página para los usuarios
//Sino, mostramos la página de acceso y registro de usuarios
if (isset($_SESSION['user_name']) and $_SESSION['estado'] == 'Autenticado') {
	include('Usuario/GestorArchivosUser.php');
	$nombreUsuario = htmlspecialchars($_SESSION['user_name']);
	die();
} else {
	include('Auth/login.php');
	die();
};
