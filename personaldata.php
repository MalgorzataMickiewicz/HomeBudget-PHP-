<?php

session_start();

if (!isset($_SESSION['logged'])){
   header('Location: index.php');
    exit();
    }  
    
if(isset($_POST['email'])){
	//Flaga
    $validation_OK = true;
    
    require_once "connect.php"; 

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_query($connection, "SET CHARSET utf8");
    mysqli_query($connection, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");

	if($connection->connect_errno!=0){
		echo "Error: ".$connection->connect_errno;
    }
    else{
          // Walidacja emaila
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
            else{
                if($validation_OK == true){
                    $userId = $_SESSION['userId'];
                    "SELECT userEmail FROM clients WHERE userID='$userId'";

                    if ($connection->query("UPDATE clients SET userEmail = '$email' WHERE userId = '$userId'")){
                        $_SESSION['c_change'] = "Email został prawidłowo zmieniony!";
                    }
                    else{
                            throw new Exception($connection->error);
                    }
                    $connection->close();
                }
            }		    
        }
    }

if(isset($_POST['login'])){

    $validation_OK = true;
    
    require_once "connect.php"; 

	$connection = @new mysqli($host, $db_user, $db_password, $db_name);

	if($connection->connect_errno!=0){
		echo "Error: ".$connection->connect_errno;
    }
    else{

    $login = $_POST['login'];

     //Czy nick jest już zarezerwowany?
     $resultat = $connection->query("SELECT userID FROM clients WHERE userLogin='$login'");
                
     if (!$resultat) throw new Exception($connection->error);
         
     $user_number_login = $resultat->num_rows;
         if($user_number_login > 0){
             $validation_OK = false;
             $_SESSION['e_login']="Istnieje już gracz o takim loginie! Wybierz inny.";
         }
         
     if ((strlen($login) < 3) || (strlen($login) > 20)){
         $validation_OK = false;
         $_SESSION['e_login'] = "Login musi posiadać od 3 do 20 znaków!";
     }
     else{
         if($validation_OK == true){
             $userId = $_SESSION['userId'];
             "SELECT userLogin FROM clients WHERE userID='$userId'";

             if ($connection->query("UPDATE clients SET userLogin = '$login' WHERE userId = '$userId'")){
                 $_SESSION['c_change'] = "Login został prawidłowo zmieniony!";
             }
             else{
                     throw new Exception($connection->error);
             }
             $connection->close();
         }
    }
}
}
?>

<!DOCTYPE HTML>
<html lang="pl">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title> Edycja danych osobowych | TB twojbudzet.com</title>
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
            <a class="navbar-brand logo ml-2" href="menu.php">Your Budget</a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu"
                aria-controls="main-menu" aria-expanded="false" aria-label="Przełącznik nawigacji">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="main-menu">
                <ul class="navbar-nav my-auto">
                    <li class="nav-item"> <a class="nav-link" href="incomes.php"> Dodaj przychód</a></li>
                    <li class="nav-item"> <a class="nav-link" href="expenses.php"> Dodaj wydatek</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="" data-toggle="dropdown" role="button"
                            aria-expanded="false" id="submenu" aria-haspopup="true"> Przeglądaj bilans </a>

                        <div class="dropdown-menu" aria-labelledby="submenu">

                            <a class="dropdown-item" href="summerycurrentmonth.php"> Bieżący miesiąc </a>
                            <a class="dropdown-item" href="summerypreviesmonth.php"> Poprzedni miesiąc </a>

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item" href="summerycurrentyear.php"> Bieżący rok </a>
                            <a class="dropdown-item" href="summeryrange.php"> Niestandardowy </a>

                        </div>

                    </li>
                    <li class="nav-item"> <a class="nav-link btn-active" href="personaldata.php">Ustawienia</a></li>
                    <li class="nav-item"> <a class="nav-link" href="logout.php">Wyloguj się</a></li>
                </ul>
            </div>

        </nav>

    </header>

    <main>
        <div class="container">

            <div class="row text-center bg-background my-4 p-sm-3 p-lg-0">

                <div class="col-lg-10 offset-lg-1 my-4 bg-white shadow p-3">

                    <h1 class="h2 font-weight-bold bg-color my-4">
                        Edycja danych osobowych
                    </h1>

                </div>

                <div class="col-lg-10 offset-lg-1 my-4 bg-white shadow p-3">
                    <?php
                        if(isset($_SESSION['c_change'])) {
                            echo '<div style="color: #47A8BD; font-weight: bold;">'.$_SESSION['c_change'].'</div>';
                            unset($_SESSION['c_change']);
                        }
                        if(isset($_SESSION['e_email'])) {
                            echo '<div style="color: red;">'.$_SESSION['e_email'].'</div>';
                            unset($_SESSION['e_email']);
                        }
                        if(isset($_SESSION['e_login'])) {
                            echo '<div style="color: red;">'.$_SESSION['e_login'].'</div>';
                            unset($_SESSION['e_login']);
                        }
                    ?>

                    <!--Name change-->
                    <div class="col-lg-6 offset-lg-3 p-3">

                        <button type="button" class="btn btn-settings" data-toggle="modal" data-target="#modal-name">
                            Zmień login
                        </button>

                    </div>

                    <div class="modal fade" id="modal-name" tabindex="-1" role="dialog" aria-labelledby="name"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title font-weight-bold" id="name">Zmień login</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post">
                                    <div class="modal-body">
                                        <h5>Podaj nowy login</h5>

                                        <input type="text" name="login" class="form-control mt-3" id="login"
                                            placeholder="login" aria-label="login" aria-describedby="login">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary font-weight-bold"
                                            data-dismiss="modal">Anuluj</button>
                                        <button type="submit"
                                            class="btn btn-sub-settings font-weight-bold">Zapisz</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!--Email change-->
                    <div class="col-lg-6 offset-lg-3 p-3">

                        <button type="button" class="btn btn-settings" data-toggle="modal" data-target="#modal-email">
                            Zmień email
                        </button>

                    </div>

                    <div class="modal fade" id="modal-email" tabindex="-1" role="dialog" aria-labelledby="modal-email"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title font-weight-bold" id="modal-new-email">Zmień email</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post">
                                    <div class="modal-body">
                                        <h5>Podaj nowy email</h5>
                                        <input type="text" name="email" class="form-control mt-3" id="email"
                                            placeholder="Email" aria-label="email" aria-describedby="email">
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary font-weight-bold"
                                            data-dismiss="modal">Anuluj</button>
                                        <button type="submit"
                                            class="btn btn-sub-settings font-weight-bold">Zapisz</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!--Go back-->
                    <div class="col-lg-6 offset-lg-3 p-3">
                        <a href="settings.php">
                            <button type="button" class="btn btn-settings">
                                Powrót
                            </button>
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </main>

    <footer class="fixed-bottom">    
        <div class="footer">
         © Małgorzata Mickiewicz <a href="malgorzatamickiewicz.pl/kontakt">contact with me</a>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>

    <script src="js/bootstrap.min.js"></script>


</body>

</html>