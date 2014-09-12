<?php

	class LoginModel
	{
		private $correctUsername = "Admin";
		private $correctPassword = "Password";
		
		// Kontrollerar loginstatusen. Är användaren inloggad returnerar metoden true, annars false.
		public function checkLoginStatus()
		{
			if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true)
			{
				return true;
			}
			
			return false;
		}
		
		// Kontrollerar användarinput gentemot de faktiska användaruppgifterna.
		public function verifyUserInput($inputUsername, $inputPassword, $inputCheckbox)
		{	
			if($inputUsername == "" || $inputUsername === NULL)
			{
				// Kasta undantag.
				throw new Exception("Användarnamn saknas");
			}
			
			if($inputPassword == "" || $inputPassword === NULL)
			{
				// Kasta undantag.
				throw new Exception("Lösenord saknas");
			}
			
			// Kontrollerar ifall inparametrarna matchar de faktiska användaruppgifterna.
			if($inputUsername == $this->correctUsername && $inputPassword == $this->correctPassword)
			{
				// Inloggningsstatus och användarnamn sparas i sessionen.
				$_SESSION['loggedIn'] = true;
				$_SESSION['loggedInUser'] = $inputUsername;
				
				
				if($inputCheckbox === true)
				{	
					// skapa cookie.
				}
				
				return true;
			}
			else
			{
				// Kasta undantag.
				throw new Exception("Felaktigt användarnamn och/eller lösenord");
			}
		}
		
		// Hämtar användarnamnet från sessionen.
		public function getLoggedInUser()
		{
			if(isset($_SESSION['loggedInUser']))
			{
				return $_SESSION['loggedInUser'];
			}
		}
		
		// Logout-metod som avsätter och förstör sessionen.
		public function logOut()
		{
			session_unset();
			session_destroy();
		}
	}

?>