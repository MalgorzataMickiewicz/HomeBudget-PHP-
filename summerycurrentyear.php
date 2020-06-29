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

    <title> Przeglądaj bilans | TB twojbudzet.com</title>
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
                        <a class="nav-link dropdown-toggle font-weight-bold" href="" data-toggle="dropdown"
                            role="button" aria-expanded="false" id="submenu" aria-haspopup="true"> Przeglądaj bilans
                        </a>


                        <div class="dropdown-menu" aria-labelledby="submenu">

                         <a class="dropdown-item" href="summerycurrentmonth.php"> Bieżący miesiąc </a>
							<a class="dropdown-item" href="summerypreviesmonth.php"> Poprzedni miesiąc </a>
							
							<div class="dropdown-divider"></div>
							
							<a class="dropdown-item" href="summerycurrentyear.php"> Bieżący rok </a>
							<a class="dropdown-item" href="summeryrange.php"> Niestandardowy </a>

                        </div>

                    </li>
                    <li class="nav-item"> <a class="nav-link" href="settings.php">Ustawienia</a></li>
                    <li class="nav-item"> <a class="nav-link" href="logout.php">Wyloguj się</a></li>
                </ul>
            </div>

        </nav>

    </header>

    <main>
        <div class="container">

            <div class="row text-center bg-background my-4 p-sm-3 p-lg-0">

                <div class="col-lg-10 offset-lg-1 my-5 bg-white bg-shadow">
                    <p class=" h2 col-8 font-weight-bold bg-color my-4 d-inline-block">
                        Przeglądaj swój bilans
                    </p>
                    <div class="d-inline-block">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="list"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Bieżący rok
                            </button>
                            <div class="dropdown-menu" aria-labelledby="list">
                                <a class="dropdown-item" href="summerycurrentmonth.php">Bieżący miesiąc</a>
                                <a class="dropdown-item" href="summerypreviesmonth.php">Poprzedni miesiąc</a>
                                <a class="dropdown-item" href="summeryrange.php">Niestandardowy</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <table class="table table-bordered">
                        <thead class="bg-table">
                            <tr>
                                <th style="width: 50%;" scope="col">PRZYCHODY</th>
                            </tr>
                        </thead>
                    </table>

                    <table class="table table-bordered bg-white">
                        <tbody>
                            <tr>
                                <th style="width: 25%;">Kategoria</th>
                                <th style="width: 25%;">Wartość</th>
                                <th style="width: 25%;">Edytuj/Usuń</th>
                            </tr>
                            <tr style="background-color: lightgrey;">
                                <td>Wypłata</td>
                                <td>5000</td>
                                <td>
                                    <button type="button" class="btn" data-toggle="modal" data-target="#edit-1">
                                        <svg class="bi bi-check" width="1.5em" height="1.5em" viewBox="0 0 16 16"
                                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M13.854 3.646a.5.5 0 010 .708l-7 7a.5.5 0 01-.708 0l-3.5-3.5a.5.5 0 11.708-.708L6.5 10.293l6.646-6.647a.5.5 0 01.708 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </td>
                                <div class="modal fade" id="edit-1" tabindex="-1" role="dialog"
                                aria-labelledby="edit-1" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title font-weight-bold" id="modal-new-password">Edytuj
                                                lub usuń</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body col-12">
                                            <h5 class="d-inline-block">Edytuj</h5>
                                            <input type="text" class="form-control little-input d-inline-block ml-2"
                                                id="wartosc" placeholder="Wartość" aria-label="wartosc"
                                                aria-describedby="wartosc">
                                        </div>

                                        <div class="modal-body col-12">
                                            <h5 class="d-inline-block ml-2">Usuń</h5>
                                            <input class="d-inline-block" type="checkbox" id="scales" name="scales">
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary font-weight-bold"
                                                data-dismiss="modal">Anuluj</button>
                                            <button type="submit"
                                                class="btn btn-sub-settings font-weight-bold">Zapisz</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            </tr>
                            <tr>
                                <td>Wypłata Partnera</td>
                                <td>4000</td>
                                <td>
                                    <button type="button" class="btn" data-toggle="modal" data-target="#edit-2">
                                        <svg class="bi bi-check" width="1.5em" height="1.5em" viewBox="0 0 16 16"
                                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M13.854 3.646a.5.5 0 010 .708l-7 7a.5.5 0 01-.708 0l-3.5-3.5a.5.5 0 11.708-.708L6.5 10.293l6.646-6.647a.5.5 0 01.708 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </td>
                                <div class="modal fade" id="edit-2" tabindex="-1" role="dialog"
                                    aria-labelledby="edit-2" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title font-weight-bold" id="modal-new-password">Edytuj
                                                    lub usuń</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body col-12">
                                                <h5 class="d-inline-block">Edytuj</h5>
                                                <input type="text" class="form-control little-input d-inline-block ml-2"
                                                    id="wartosc" placeholder="Wartość" aria-label="wartosc"
                                                    aria-describedby="wartosc">
                                            </div>

                                            <div class="modal-body col-12">
                                                <h5 class="d-inline-block ml-2">Usuń</h5>
                                                <input class="d-inline-block" type="checkbox" id="scales" name="scales">
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary font-weight-bold"
                                                    data-dismiss="modal">Anuluj</button>
                                                <button type="submit"
                                                    class="btn btn-sub-settings font-weight-bold">Zapisz</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </tr>
                            <tr class="bg-table">
                                <th>SUMA</th>
                                <th>9000</th>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>

                </div>

                <div class="col-lg-6">
                    <table class="table table-bordered">
                        <thead class="bg-table">
                            <tr>
                                <th style="width: 50%;" scope="col">WYDATKI</th>
                            </tr>
                        </thead>
                    </table>

                    <table class="table table-bordered bg-white">
                        <tbody>
                            <tr>
                                <th style="width: 25%;">Kategoria</th>
                                <th style="width: 25%;">Wartość</th>
                                <th style="width: 25%;">Edytuj/Usuń</th>
                            </tr>
                            <tr style="background-color: lightgrey;">
                                <td>Jedzenie</td>
                                <td>200</td>
                                <td>
                                    <button type="button" class="btn" data-toggle="modal" data-target="#edit-3">
                                        <svg class="bi bi-check" width="1.5em" height="1.5em" viewBox="0 0 16 16"
                                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M13.854 3.646a.5.5 0 010 .708l-7 7a.5.5 0 01-.708 0l-3.5-3.5a.5.5 0 11.708-.708L6.5 10.293l6.646-6.647a.5.5 0 01.708 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </td>
                                <div class="modal fade" id="edit-3" tabindex="-1" role="dialog"
                                aria-labelledby="edit-3" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title font-weight-bold" id="modal-new-password">Edytuj
                                                lub usuń</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body col-12">
                                            <h5 class="d-inline-block">Edytuj</h5>
                                            <input type="text" class="form-control little-input d-inline-block ml-2"
                                                id="wartosc" placeholder="Wartość" aria-label="wartosc"
                                                aria-describedby="wartosc">
                                        </div>

                                        <div class="modal-body col-12">
                                            <h5 class="d-inline-block ml-2">Usuń</h5>
                                            <input class="d-inline-block" type="checkbox" id="scales" name="scales">
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary font-weight-bold"
                                                data-dismiss="modal">Anuluj</button>
                                            <button type="submit"
                                                class="btn btn-sub-settings font-weight-bold">Zapisz</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            </tr>
                            <tr>
                                <td>Hobby</td>
                                <td>50</td>
                                <td>
                                    <button type="button" class="btn" data-toggle="modal" data-target="#edit-4">
                                        <svg class="bi bi-check" width="1.5em" height="1.5em" viewBox="0 0 16 16"
                                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M13.854 3.646a.5.5 0 010 .708l-7 7a.5.5 0 01-.708 0l-3.5-3.5a.5.5 0 11.708-.708L6.5 10.293l6.646-6.647a.5.5 0 01.708 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </td>
                                <div class="modal fade" id="edit-4" tabindex="-1" role="dialog"
                                aria-labelledby="edit-4" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title font-weight-bold" id="modal-new-password">Edytuj
                                                lub usuń</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body col-12">
                                            <h5 class="d-inline-block">Edytuj</h5>
                                            <input type="text" class="form-control little-input d-inline-block ml-2"
                                                id="wartosc" placeholder="Wartość" aria-label="wartosc"
                                                aria-describedby="wartosc">
                                        </div>

                                        <div class="modal-body col-12">
                                            <h5 class="d-inline-block ml-2">Usuń</h5>
                                            <input class="d-inline-block" type="checkbox" id="scales" name="scales">
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary font-weight-bold"
                                                data-dismiss="modal">Anuluj</button>
                                            <button type="submit"
                                                class="btn btn-sub-settings font-weight-bold">Zapisz</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            </tr>
                            <tr class="bg-table">
                                <th>SUMA</th>
                                <th>250</th>
                                <th></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p class="h4 col-12 mb-4">Gratulacje! Nie przekroczyłeś swojego budżetu</p>

            </div>
        </div>

    </main>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>

    <script src="js/bootstrap.min.js"></script>


</body>

</html>