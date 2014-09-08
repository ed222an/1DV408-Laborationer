<?php
	setlocale(LC_ALL , "swedish"); // Ställer in sidans format så att månad, år, tid etc. visas på svenska.
	
	// Variabler
	$weekDay = ucfirst(strftime("%A")); // Hittar veckodagen och gör den första bokstaven stor.
	$month = ucfirst(strftime("%B")); // Hittar månaden och gör den första bokstaven stor.
	$year = strftime("%Y");
	$time = strftime("%H:%M:%S");
	$format = '%e'; // Fixar formatet så att datumet anpassas för olika platformar. Lösning hittade på http://php.net/manual/en/function.strftime.php

	// Kontrollerar ifall windowsformatet används och ersätter %e med en fungerande del.
	if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
	{
    	$format = preg_replace('#(?<!%)((?:%%)*)%e#', '\1%#d', $format);
	}
	
	echo "<html>
			<head>
				<title>Laboration 2 - Login del 1</title>
				<meta charset='utf-8'>
			</head>
			<body>
				<h1>Laboration 2 - Login del 1</h1>
				<h2>Ej inloggad</h2>
				<form id='loginForm'>
					<fieldset>
						<legend>Login - Skriv in användarnamn och lösenord</legend>
						Namn: <input type='text' name='userName'> Lösenord: <input type='password' name='userPassword'> <input type='checkbox' name='stayLoggedIn'>Håll mig inloggad:
						<button type='submit' form='loginForm' value='Submit'>Log in</button>
					</fieldset>
				</form>
				" . strftime('' . $weekDay . ', den ' . $format . ' '. $month . ' år ' . $year . '. Klockan är [' . $time . ']') . ".
			</body>
		</html>";
?>