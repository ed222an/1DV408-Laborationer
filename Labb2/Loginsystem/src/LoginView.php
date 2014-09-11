<?php

	class LoginView
	{
		private $model;
		private $loginStatus = "Ej inloggad";
		private $username = "username";
		private $password = "password";
		private $checkbox = "checkbox";
		private $message = "";
		
		public function __construct(LoginModel $model)
		{
			$this->model = $model;
		}
		
		public function didUserPressLogin()
		{	
			return isset($_POST[$this->username]);
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

			
			// Kontrollerar ifall windowsformatet används och ersätter %e med en fungerande del.
			if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
			{
    			$format = preg_replace('#(?<!%)((?:%%)*)%e#', '\1%#d', $format);
			}
			
			$HTMLbody = "
				<h1>Laboration 2 - ed222an</h1>
				<h2>$this->loginStatus</h2>
				<a href=''>Registrera ny användare</a>
				<form id='loginForm' method=post>
					<fieldset>
						<legend>Login - Skriv in användarnamn och lösenord</legend>
						$this->message
						Namn: <input type='text' name='$this->username' value='" . $this->getInputUsername() . "'> Lösenord: <input type='password' name='$this->password'> <input type='checkbox' name='$this->checkbox' value='checked'>Håll mig inloggad:
						<button type='submit' name='button' form='loginForm' value='Submit'>Log in</button>
					</fieldset>
				</form>
				" . strftime('' . $weekDay . ', den ' . $format . ' '. $month . ' år ' . $year . '. Klockan är [' . $time . ']') . ".";
			
			return $HTMLbody;
		}
		
		// Visar eventuella meddelanden.
		public function showMessage($message)
		{
			$this->message = "<p>" . $message . "</p>";
		}
		
		// Sparar angivet användarnamn i textfältet.
		public function getInputUsername()
		{
			if(isset($_POST['username']))
			{
				return $_POST['username'];
			}
			return "";
		}
		
		// Visar inloggningssidan.
		public function loginSuccess()
		{
			$this->loginStatus = $this->getInputUsername() . " är inloggad";
		}
	}
?>