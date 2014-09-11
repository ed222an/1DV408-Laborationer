<?php

	class LoginModel
	{
		private $correctUsername = "Admin";
		private $correctPassword = "Password";
			
		public function __construct()
		{
			
		}
		
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
	}

?>