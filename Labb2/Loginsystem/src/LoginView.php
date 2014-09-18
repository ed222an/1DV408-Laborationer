<?php

	class LoginView
	{
		private $model;
		private $loginStatus = "";
		private $username = "username";
		private $password = "password";
		private $checkbox = "checkbox";
		private $message = "";
		
		public function __construct(LoginModel $model)
		{
			$this->model = $model;
		}
		
		// Kontrollerar ifall användarnamnet är lagrat i POST-arrayen.
		public function didUserPressLogin()
		{
			return isset($_POST[$this->username]);
		}
		
		// Kontrollerar ifall URL:en innehåller logout.
		public function didUserPressLogout()
		{
			return isset($_GET['logout']);
		}
		
		// Sätter body-innehållet.
		public function showLoginPage()
		{
			// Variabler
			$weekDay = ucfirst(utf8_encode(strftime("%A"))); // Hittar veckodagen, tillåter Å,Ä,Ö och gör den första bokstaven stor.
			$month = ucfirst(strftime("%B")); // Hittar månaden och gör den första bokstaven stor.
			$year = strftime("%Y");
			$time = strftime("%H:%M:%S");
			$format = '%e'; // Fixar formatet så att datumet anpassas för olika platformar. Lösning hittade på http://php.net/manual/en/function.strftime.php
			
			// Kontrollerar inloggningsstatus. Är användaren inloggad...	
			if($this->model->checkLoginStatus())
			{				
				// ...visa användarsidan...
				$contentString = "
					$this->message
					<p><a href='?logout'>Logga ut</a></p>";
				$this->loginStatus = $this->model->getLoggedInUser() . " är inloggad";
			}
			else // ...annars visas inloggningssidan.
			{
				$this->loginStatus = "Ej inloggad";
				$contentString = 
				"<form id='loginForm' method=post action='?login'>
					<fieldset>
						<legend>Login - Skriv in användarnamn och lösenord</legend>
						$this->message
						Namn: <input type='text' name='$this->username' value='" . $this->getInputUsername() . "'> 
						Lösenord: <input type='password' name='$this->password'> 
						<input type='checkbox' name='$this->checkbox' value='checked'>Håll mig inloggad:
						<button type='submit' name='button' form='loginForm' value='Submit'>Logga in</button>
					</fieldset>
				</form>";
			}
			
			// Kontrollerar ifall windowsformatet används och ersätter %e med en fungerande del.
			if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
			{
    			$format = preg_replace('#(?<!%)((?:%%)*)%e#', '\1%#d', $format);
			}
			
			$HTMLbody = "
				<h1>Laboration 2 - ed222an</h1>
				<h2>$this->loginStatus</h2>
				<p><a href=''>Registrera ny användare</a></p>
				$contentString
				" . strftime('' . $weekDay . ', den ' . $format . ' '. $month . ' år ' . $year . '. Klockan är [' . $time . ']') . ".";
			
			return $HTMLbody;
		}
		
		// Skapar cookies innehållande de medskickande värdena.
		public function createCookies($usernameToSave, $passwordToSave)
		{
			setcookie("Username", $usernameToSave, time()+60*60*24*30);
			setcookie("Password", $passwordToSave, time()+60*60*24*30);
		}
		
		public function searchForCookies()
		{
			if(isset($_COOKIE["Username"]) === true && isset($_COOKIE["Password"]) === true)
			{
				return true;
			}
			
			return false;
		}
		
		// Logga in med kakor.
		public function loginWithCookies()
		{
			$this->model->verifyUserInput($_COOKIE["Username"], $_COOKIE["Password"], true);
			$this->showMessage("Inloggningen lyckades via cookies");
		}
		
		// Tar bort alla cookies.
		public function removeCookies()
		{
			foreach ($_COOKIE as $c_key => $c_value)
			{
				setcookie($c_key, NULL, 1);
			}
		}
		
		// Sparar angivet användarnamn i textfältet.
		public function getInputUsername()
		{
			if(isset($_POST['username']))
			{
				return $_POST['username'];
			}
			
			// Är inte användarnamnet satt skickas en tomsträng med.
			return "";
		}
		
		// Visar eventuella meddelanden.
		public function showMessage($message)
		{
			$this->message = "<p>" . $message . "</p>";
		}
		
		// Visar login-meddelande.
		public function successfulLogin()
		{
			$this->showMessage("Inloggningen lyckades!");
		}
		
		// Visar login-meddelande för "Håll mig inloggad"-funktionen.
		public function successfulLoginAndCookieCreation()
		{
			$this->showMessage("Inloggningen lyckades och vi kommer ihåg dig nästa gång");
		}
		
		// Visar logout-meddelande.
		public function successfulLogout()
		{
			$this->showMessage("Du har nu loggat ut");
		}
	}
?>