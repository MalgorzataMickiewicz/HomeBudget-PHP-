<?php

session_start();
    
if ((isset($_SESSION['logged'])) && ($_SESSION['logged'] == true)){
    header('Location: menu.php');
    exit();
}

if(isset($_POST['email'])){
	//Flaga
    $validation_OK = true;
    
    require_once "connect.php"; 

	$connection = @new mysqli($host, $db_user, $db_password, $db_name);

	if($connection->connect_errno!=0){
		echo "Error: ".$connection->connect_errno;
    }
    else{

          // Walidacja emaila i loginu
          $email = $_POST['email'];
          $emailB = filter_var($email,FILTER_SANITIZE_EMAIL);
  
          if((filter_var($emailB,FILTER_VALIDATE_EMAIL) == false)){
              $validation_OK = false;
              $_SESSION['e_email'] = "Podaj poprawny adres email";
          }

		//Czy email już istnieje?
		$resultat = $connection->query("SELECT userId FROM clients WHERE userEmail='$email'");
				
		if (!$resultat) throw new Exception($connection->error);
			
			$user_number_email = $resultat->num_rows;
			if($user_number_email > 0){
				$validation_OK = false;
				$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
            }		
            
        $login = $_POST['login'];

        //Czy nick jest już zarezerwowany?
		$resultat = $connection->query("SELECT userID FROM clients WHERE userLogin='$login'");
			
		if (!$resultat) throw new Exception($connection->error);
			
		$user_number_login = $resultat->num_rows;
			if($user_number_login > 0)
			{
				$validation_OK = false;
				$_SESSION['e_login']="Istnieje już gracz o takim loginie! Wybierz inny.";
            }
            
        if ((strlen($login) < 3) || (strlen($login) > 20)){
            $validation_OK = false;
            $_SESSION['e_login'] = "Login musi posiadać od 3 do 20 znaków!";
        }
       /*
       if (ctype_alnum($login) == false){
            $validation_OK = false;
            $_SESSION['e_login'] = "Login musi posiadać tylko znaki i cyfry (bez polskich znaków)!";
        }
        */

        // Walidacja hasła
        $password = $_POST['password'];

        if(strlen($password) < 8 || strlen($password) > 20){
            $validation_OK = false;
            $_SESSION['e_password'] = "Hasło musi posiadać od 8 do 20 znaków";
        }

        
        //hashowanie haseł
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        if($validation_OK == true){
            //Testy zaliczone, dodajemy użytkownika do bazy

            if ($connection->query("INSERT INTO clients VALUES (NULL, '$login', '$email', '$password_hash')")){
               
                $resultUser = mysqli_query($connection, "SELECT userId FROM clients ORDER BY userId DESC LIMIT 1");               
                    while ($row = $resultUser->fetch_assoc()) {
                        $userId= $row['userId'];
                    }
                $resultCategory = mysqli_query($connection, "SELECT categoryName FROM incomescategory");               
                    while ($row = $resultCategory->fetch_assoc()) {
                        $categoryName= $row['categoryName'];
                        mysqli_query($connection, "INSERT INTO incomescategoryassigned VALUES (NULL, '$userId', '$categoryName')");
                    }
                $resultCategoryExp = mysqli_query($connection, "SELECT categoryName FROM expensescategory");               
                    while ($row2 = $resultCategoryExp->fetch_assoc()) {
                        $categoryNameExp= $row2['categoryName'];
                        mysqli_query($connection, "INSERT INTO expensescategoryassigned VALUES (NULL, '$userId', '$categoryNameExp')");
                    }
                    $_SESSION['registration'] = true;
                    $_SESSION['c_registration'] = "Użytkownik został prawidłowo zarejestrowany";
            }
            else{
					throw new Exception($connection->error);
            }
            $connection->close();
        }
    }
}
    
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>

    <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Rejestracja | TB twojbudzet.com</title>
    <meta name="description" content="Strona, na której możesz stworzyć swój domowy budżet" />
    <meta name="keywords" content="budżet, domowy, oszczędności, plany" />
    <meta name="author" content="Małgorzata Mickiewicz">
    <meta http-equiv="X-Ua-Compatible" content="IE=edge">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css" type="text/css" />
    <link rel="stylesheet" href="css/fontello.css" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display&display=swap" rel="stylesheet" />

    <!--[if lt IE 9]>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <![endif]-->

</head>

<body>

    <header>

        <nav class="navbar bg-budget navbar-dark navbar-expand-lg text-center">
            <a class="navbar-brand logo ml-2" href="#">Your Budget</a>

        </nav>

    </header>

    <main>
        <div class="container">

            <div class="row text-center bg-background my-4 p-sm-3 p-lg-0">

                <div class="col-lg-4 bg-white offset-lg-1 my-4 shadow p-3">

                    <h1 class="h3 font-weight-bold my-4">Rejestracja</h1>

                    <form method="post"> 
                        <div class="col-10 offset-md-1 input-group mb-4">

                            <div class="input-group-prepend">
                                <span class="input-group-text register-color"> 
                                    <svg class="bi bi-people-circle" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.468 12.37C12.758 11.226 11.195 10 8 10s-4.757 1.225-5.468 2.37A6.987 6.987 0 008 15a6.987 6.987 0 005.468-2.63z"/>
                                        <path fill-rule="evenodd" d="M8 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                                        <path fill-rule="evenodd" d="M8 1a7 7 0 100 14A7 7 0 008 1zM0 8a8 8 0 1116 0A8 8 0 010 8z" clip-rule="evenodd"/>
                                    </svg>    
                                </span>

                            </div>

                            <input type="text" name="login" class="form-control" placeholder="*Login" id="login" aria-label="login"
                            aria-describedby="login">

                            <?php

                                if(isset($_SESSION['e_login'])) {
                                    echo '<div style="color: red;">'.$_SESSION['e_login'].'</div>';
                                    unset($_SESSION['e_login']);
                                }
                            ?>

                        </div>
                    
                        <div class="col-10 offset-md-1 input-group mb-4">

                            <div class="input-group-prepend">
                                <span class="input-group-text register-color"> ✉ </span>

                            </div>

                            <input type="text" name="email" class="form-control" placeholder="*Email" id="email" aria-label="email"
                            aria-describedby="email">

                            <?php

                                if(isset($_SESSION['e_email'])) {
                                    echo '<div style="color: red;">'.$_SESSION['e_email'].'</div>';
                                    unset($_SESSION['e_email']);
                                }
                            ?>

                        </div>

                        <div class="col-10 offset-md-1 input-group mb-4">

                            <div class="input-group-prepend">

                                <span class="input-group-text register-color">
                                    <svg class="bi bi-lock-fill" width="1em" height="1em" viewBox="0 0 16 16"
                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="11" height="9" x="2.5" y="7" rx="2" />
                                        <path fill-rule="evenodd" d="M4.5 4a3.5 3.5 0 117 0v3h-1V4a2.5 2.5 0 00-5 0v3h-1V4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>

                            </div>

                            <input type="password" name="password" class="form-control" placeholder="*Hasło" id="haslo" aria-label="haslo"
                                aria-describedby="haslo">

                                <?php

                                    if(isset($_SESSION['e_password'])) {
                                        echo '<div style="color: red;">'.$_SESSION['e_password'].'</div>';
                                        unset($_SESSION['e_password']);
                                    }
                                ?>

                        </div>

                        <button type="submit" class="btn btn-register my-3 mb-3">Zarejestruj się</button>
                    
                        <p>*Pole wymagane</p>
                            <?php

                            if(isset($_SESSION['c_registration'])) {
                                echo '<div>'.$_SESSION['c_registration'].'</div>';
                                unset($_SESSION['c_registration']);
                            }
                            ?>         
                    </form>

                </div>

                <div class="col-lg-4 bg-white my-4 offset-lg-2 offset-xs-0 shadow p-3">
                    <h1 class="h3 font-weight-bold my-4">Masz już konto? <br />Zaloguj się!</h1>
                    <a href="login.php">
                        <button type="submit" class="btn-login my-3 mb-3">Logowanie </button>
                    </a>
                    <p class="h4 font-weight-bold mb-2 mt-2">  </p>

                </div>
            </div>

        </div>

    </main>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>
	

</body>

</html>