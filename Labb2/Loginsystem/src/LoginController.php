<?php
	
	require_once("src/LoginModel.php");
	require_once("src/LoginView.php");
	
	class LoginController
	{
		private $view;
		private $model;
		
		public function __construct()
		{
			// Skapar nya instanser av modell- & vy-klassen.
			$this->model = new LoginModel();
			$this->view = new LoginView($this->model);
			
			// Kontrollerar ifall det finns kakor och ifall användaren inte är inloggad.
			if($this->view->searchForCookies() && !$this->model->checkLoginStatus())
			{
				try
				{
					// Logga in med kakor.
					$this->view->loginWithCookies();
				}
				catch(Exception $e)
				{
					// Visar eventuella felmeddelanden.
					$this->view->showMessage($e->getMessage());
				}
			}
			else // Annars, visa standardsidan på normalt vis.
			{
				// Ifall användaren tryckt på "Logga in" och inte redan är inloggad...
				if($this->view->didUserPressLogin() && !$this->model->checkLoginStatus())
				{
					// ...så loggas användaren in.
					$this->doLogin();
				}
			
				// Ifall användaren tryckt på "Logga ut" och är inloggad...
				if($this->view->didUserPressLogout() && $this->model->checkLoginStatus())
				{
					// ...så loggas användaren ut.
					$this->doLogout();
				}
			}
		}
		
		// Hämtar sidans innehåll.
		public function doHTMLBody()
		{
			return $this->view->showLoginPage();
		}
		
		// Försöker verifiera och logga in användaren.
		public function doLogin()
		{
			// Kontrollerar ifall användaren tryckt på "Logga in" och inte redan är inloggad.
			if($this->view->didUserPressLogin() && !$this->model->checkLoginStatus())
			{
				// Kontrollerar indata
				$checkboxStatus = false;
				
				// Kontrollera ifall "Håll mig inloggad"-rutan är ikryssad.
				if(isset($_POST['checkbox']))
				{
					$checkboxStatus = true;
				}
				
				try
				{
					// Verifiera data i fälten.
					$this->model->verifyUserInput($_POST['username'], $_POST['password']);
					
					// Kontrollerar om "Håll mig inloggad"-rutan är ikryssad.
					if($checkboxStatus === true)
					{
						// Skapa cookies.
						$this->view->createCookies($_POST['username'], $_POST['password']);
					}
					
					// Visar login-meddelande.
					$this->view->successfulLogin();
				}
				catch(Exception $e)
				{
					// Visar eventuella felmeddelanden.
					$this->view->showMessage($e->getMessage());
				}
			}
			
			//Generera utdata
			return $this->view->showLoginPage();
		}
		
		// Loggar ut användaren.
		public function doLogout()
		{
			// Kontrollera indata, tryckte användaren på Logga ut?
			if($this->view->didUserPressLogout() && $this->model->checkLoginStatus())
			{
				// Logga ut.
				$this->model->logOut();
				
				// Ifall det finns cookies...
				if($this->view->searchForCookies())
				{
					// ...ta bort dem.
					$this->view->removeCookies();
				}
				
				//Generera utdata, tillåt användaren att logga in igen.
				$this->doLogin();
				$this->view->successfulLogout();
			}
		}
	}
	
?>