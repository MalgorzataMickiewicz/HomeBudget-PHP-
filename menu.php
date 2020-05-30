<?php

session_start();

if (!isset($_SESSION['logged'])){
   header('Location: login.php');
	exit();
    }  
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>

    <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title> Menu | TB twojbudzet.com</title>
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

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Przełącznik nawigacji">
                <span class="navbar-toggler-icon"></span>
            </button>
     
			<div class="collapse navbar-collapse" id="main-menu">
				<ul class="navbar-nav my-auto">
                    <li class="nav-item"> <a class="nav-link" href="#"> Dodaj przychód</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#"> Dodaj wydatek</a></li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false" id="submenu" aria-haspopup="true"> Przeglądaj bilans </a>
						
						<div class="dropdown-menu" aria-labelledby="submenu">
						
							<a class="dropdown-item" href="#"> Bieżący miesiąc </a>
							<a class="dropdown-item" href="#"> Poprzedni miesiąc </a>
							
							<div class="dropdown-divider"></div>
							
							<a class="dropdown-item" href="#"> Bieżący rok </a>
							<a class="dropdown-item" href="#"> Niestandardowy </a>
				
						</div>
						
					</li>
					<li class="nav-item"> <a class="nav-link" href="#">Ustawienia</a></li>
					<li class="nav-item"> <a class="nav-link" href="logout.php">Wyloguj się</a></li>

				</ul>
			</div> 

        </nav>

    </header>

    <main>
        <div class="container">

            <div class="row text-center bg-background my-4 p-sm-3 p-lg-0">

                <div class="col-lg-10 offset-lg-1 my-4 bg-white shadow p-3">

                <?php
                  	echo '<p class="h3 font-weight-bold my-4">Witaj '.$_SESSION['userName'].'! Poznaj siłę kontroli nad własnym budżetem </p>';
                ?>

                    <h2 class="h3">
                        Planowanie swojego budżetu domowego oraz jego kontrola pozwala na wprowdzenie harmonii do życia. Dzięki chwili poświęconej na zaplanowanie budżetu na cały miesiąc, będziesz czuć kontrolę nie tylko w sferze finansów ale również w życiu codziennym.
                    </h2>

                    <img class="img-fluid mt-3 mb-3" alt="obraz" src="img/obraz.png">
                </div>
            </div>

        </div>

    </main>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>
	

</body>

</html>