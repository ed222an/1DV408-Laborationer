<?php
	session_start();
	session_regenerate_id();
	ini_set('session.cookie_httponly', true);
	setlocale(LC_ALL , "swedish"); // Ställer in sidans format så att månad, år, tid etc. visas på svenska.
	
	require_once("../../common/HTMLView.php");
	require_once("src/LoginController.php");
	
	$c = new LoginController();
	$htmlBody = $c->doHTMLBody();
	
	$view = new HTMLView();
	$view->echoHTML($htmlBody);
?>