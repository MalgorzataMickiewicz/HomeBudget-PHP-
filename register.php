<?php

session_start();
    
if ((isset($_SESSION['logged'])) && ($_SESSION['logged'] == true)){
    header('Location: menu.php');
    exit();
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

                        <input type="text" class="form-control" placeholder="*Login" id="login" aria-label="login"
                        aria-describedby="login">

                    </div>
                    
                    <div class="col-10 offset-md-1 input-group mb-4">

                        <div class="input-group-prepend">
                            <span class="input-group-text register-color"> ✉ </span>

                        </div>

                        <input type="text" class="form-control" placeholder="*Email" id="email" aria-label="email"
                        aria-describedby="email">

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

                        <input type="password" class="form-control" placeholder="*Hasło" id="haslo" aria-label="haslo"
                            aria-describedby="haslo">

                    </div>

                        <button type="submit" class="btn btn-register my-3 mb-3">Zarejestruj się</button>
                    
                    <p>*Pole wymagane</p>

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