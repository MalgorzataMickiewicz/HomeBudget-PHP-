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

    <title> Zmiana hasła | TB twojbudzet.com</title>
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

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu"
                aria-controls="main-menu" aria-expanded="false" aria-label="Przełącznik nawigacji">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="main-menu">
                <ul class="navbar-nav my-auto">
                    <li class="nav-item"> <a class="nav-link" href="#"> Dodaj przychód</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#"> Dodaj wydatek</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button"
                            aria-expanded="false" id="submenu" aria-haspopup="true"> Przeglądaj bilans </a>

                        <div class="dropdown-menu" aria-labelledby="submenu">

                            <a class="dropdown-item" href="#"> Bieżący miesiąc </a>
                            <a class="dropdown-item" href="#"> Poprzedni miesiąc </a>

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item" href="#"> Bieżący rok </a>
                            <a class="dropdown-item" href="#"> Niestandardowy </a>

                        </div>

                    </li>
                    <li class="nav-item"> <a class="nav-link btn-active" href="#">Ustawienia</a></li>
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
                        Zmiana hasła
                    </h1>

                </div>

                <div class="col-lg-10 offset-lg-1 my-4 bg-white shadow p-3">

                    <!--Password change-->
                    <div class="col-lg-6 offset-lg-3 p-3">

                        <button type="button" class="btn btn-settings" data-toggle="modal"
                            data-target="#modal-password">
                            Zmiana hasła
                        </button>

                    </div>

                    <div class="modal fade" id="modal-password" tabindex="-1" role="dialog" aria-labelledby="modal-password"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title font-weight-bold" id="modal-new-password">Zmień hasło</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h5>Podaj nowe hasło</h5>
                                    <input type="text" class="form-control mt-3" id="haslo" placeholder="Hasło"
                                        aria-label="haslo" aria-describedby="haslo">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary font-weight-bold"
                                        data-dismiss="modal">Anuluj</button>
                                    <button type="submit" class="btn btn-sub-settings font-weight-bold">Zapisz</button>
                                </div>
                            </div>
                        </div>
                    </div>

                      <!--Go back-->
                      <div class="col-lg-6 offset-lg-3 p-3">

                        <button type="button" class="btn btn-settings">
                            Powrót
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </main>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>

    <script src="js/bootstrap.min.js"></script>


</body>

</html>