<?php
	
	require_once("src/LoginModel.php");
	require_once("src/LoginView.php");
	
	class LoginController
	{
		private $view;
		private $model;
		
		public function __construct()
		{
			$this->model = new LoginModel();
			$this->view = new LoginView($this->model);
			
			$this->doLogin();
		}
		
		public function doHTMLBody()
		{
			return $this->view->showLoginPage();
		}
		
		public function doLogin()
		{
			// Kontrollerar indata, har användaren tryckt på Log in?
			if($this->view->didUserPressLogin())
			{
				$checkboxStatus = false;
				
				// Kontrollera ifall "Håll mig inloggad"-rutan är ikryssad.
				if(isset($_POST['checkbox']))
				{
					$checkboxStatus = true;
				}
				
				try
				{
					// Verifiera data i fälten.
					if($this->model->verifyUserInput($_POST['username'], $_POST['password'], $checkboxStatus))
					{
						$this->view->loginSuccess();	
					}
				}
				catch(Exception $e)
				{
					$this->view->showMessage($e->getMessage());
				}
			}
			
			//Generera utdata
			return $this->view->showLoginPage();
		}
	}
	
?>