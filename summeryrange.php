<?php

session_start();

if (!isset($_SESSION['logged'])){
   header('Location: login.php');
	exit();
    }  

function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

if(isset($_POST['date-from'])){

    if(isset($_POST['date-to'])){

        //Flaga
        $validation_OK = true;

        $dateFrom = $_POST['date-from'];
        $dateTo = $_POST['date-to'];

        $checkFrom = validateDate($dateFrom);

        if($checkFrom){
            $checkTo = validateDate($dateTo);
            if($checkTo){
                $validation_OK = true;
            }
            else{
                $validation_OK = false;
            }
        }
        else{
            $validation_OK = false;
        }
    }

    if($validation_OK == false){
        $_SESSION['c_information'] = '<p style="color: red;">Podałeś nieprawidłową datę!</p>';
    }

    if($validation_OK == true){
        require_once "connect.php"; 
        $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    
        if($connection->connect_errno!=0){
            echo "Error: ".$connection->connect_errno;
        }
        else{
            if ($connection){
                $userId = $_SESSION['userId'];   
    
                //incomes
    
                $resultId = mysqli_query($connection, "SELECT valueIncome, categoryIncomeId, idIncome FROM incomes WHERE userId = '$userId' AND dateIncome >= '$dateFrom' AND dateIncome <= '$dateTo'");
                                
                $i = 0;
                $sum = 0;
                while ($row = $resultId->fetch_assoc()) {
    
                    $valueIncome = $row['valueIncome'];
                    $categoryIncomeId = $row['categoryIncomeId'];
                    $idIncome = $row['idIncome'];
                    
                    $resultName = mysqli_query($connection, "SELECT categoryName FROM incomescategoryassigned WHERE id = '$categoryIncomeId'");
                    
                     while ($row = $resultName->fetch_assoc()) {
                         $categoryName = $row['categoryName'];
                         
                          $_SESSION['c_value'.$i] = '<tr style="background-color: lightgrey;" id="incomeInformation"><td incomeId="'.$idIncome.'">'.$categoryName.'</td><td>'.$valueIncome.'</td>
                          <td>
                                        <button type="button" class="btn" data-toggle="modal" data-target="#edit-1" onclick="">
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
                                                <h5 class="modal-title font-weight-bold" id="modal-new-password">Edytuj wartość</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form metho="post">
                                                <div class="modal-body col-12">
                                                    <h5 class="d-inline-block">Edytuj</h5>
                                                    <input type="text" name="newIncomeValue" class="form-control little-input d-inline-block ml-2"
                                                        id="wartosc" placeholder="Wartość" aria-label="wartosc"
                                                        aria-describedby="wartosc">
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
                                </tr>';                           
                            $i += 1;   
                            $sum += $valueIncome;
                            
                            $_SESSION['c_sum'] = '<tr class="bg-table">
                                            <th>SUMA</th>
                                            <th>'.$sum.'</th>
                                            <td></td>
                                        </tr>';
                     }
                }
                  
                $_SESSION['c_val'] = '';
                $_SESSION['c_valDelete'] = '';
    
                //expenses
    
                $resultIdExp = mysqli_query($connection, "SELECT valueExpense, categoryExpenseId, idExpense FROM expenses WHERE userId = '$userId' AND dateExpense >= '$dateFrom' AND dateExpense <= '$dateTo'");
                            
                $j = 0;
                $sumExp = 0;
    
                while ($row1 = $resultIdExp->fetch_assoc()) {
    
                    $valueExpense = $row1['valueExpense'];
                    $categoryExpenseId = $row1['categoryExpenseId'];
                    $idExpense = $row1['idExpense'];
    
                    $resultNameExp = mysqli_query($connection, "SELECT categoryName FROM expensescategoryassigned WHERE id = '$categoryExpenseId'");
                
                    while ($row1 = $resultNameExp->fetch_assoc()) {
                         $categoryNameExp = $row1['categoryName'];
                         
                          $_SESSION['c_valueExp'.$j] = '<tr style="background-color: lightgrey;" id="expenseInformation"><td expenseId="'.$idExpense.'">'.$categoryNameExp.'</td><td>'.$valueExpense.'</td>
                          <td>
                                        <button type="button" class="btn" data-toggle="modal" data-target="#edit-1" onclick="">
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
                                                <h5 class="modal-title font-weight-bold" id="modal-new-password">Edytuj wartość</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form metho="post">
                                                <div class="modal-body col-12">
                                                    <h5 class="d-inline-block">Edytuj</h5>
                                                    <input type="text" name="newIncomeValue" class="form-control little-input d-inline-block ml-2"
                                                        id="wartosc" placeholder="Wartość" aria-label="wartosc"
                                                        aria-describedby="wartosc">
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
                                </tr>';                           
                            $j += 1;   
                            $sumExp += $valueExpense;
                            }
                            
                            $_SESSION['c_sumExp'] = '<tr class="bg-table">
                                            <th>SUMA</th>
                                            <th>'.$sumExp.'</th>
                                            <td></td>
                                        </tr>';
                     }
    
                        
                $_SESSION['c_valExp'] = '';
                $_SESSION['c_valDeleteExp'] = '';  
    
                if($sumExp == 0 && $sum == 0){
                    $_SESSION['c_finalSum'] = '<p class="h4 col-12 mb-4">Jeszcze nie posiadasz żadnych danych</p>';
                }
                else if($sumExp < $sum) {
                    $_SESSION['c_finalSum'] = '<p class="h4 col-12 mb-4">Gratulacje! Nie przekroczyłeś swojego budżetu</p>';
                }
                else {
                    $_SESSION['c_finalSum'] = '<p class="h4 col-12 mb-4">Uwaga! Przekroczyłeś swój budżet</p>';
                }
    
            }
            else{
                 throw new Exception($connection->error);        
            }
      }
      $connection->close();
    }
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
                
                    <p class="h2 col-8 font-weight-bold bg-color my-4 d-inline-block">
                        Przeglądaj swój bilans
                    </p>
                    <div class="d-inline-block">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="list"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Niestandardowy
                            </button>
                            <div class="dropdown-menu" aria-labelledby="list">
                                <a class="dropdown-item" href="summerycurrentmonth.php">Bieżący miesiąc</a>
                                <a class="dropdown-item" href="summerypreviesmonth.php">Poprzedni miesiąc</a>
                                <a class="dropdown-item" href="summerycurrentyear.php">Bieżący rok</a>
                            </div>
                        </div>
                    </div>
                    <?php
                if(isset($_SESSION['c_information'])) {

                 echo $_SESSION['c_information'];
                 unset($_SESSION['c_information']);
                }
                ?>
                    <form method="post">
                        <p class="h4 col-8 font-weight-bold bg-color my-4 d-inline-block">
                            Wybierz zakres
                        </p>
                        <div class="col-lg-12 col-md-12 input-group input-daterange d-inline-block mb-4">

                            <div class="input-group-addon d-lg-inline-block mx-2">od</div>

                            <input type="text" name="date-from" class="col-lg-12 col-md-12  form-control control d-lg-inline-block mx-2" placeholder="2012-04-05">
                            <div class="input-group-addon d-lg-inline-block mx-2">do</div>

                            <input type="text" name="date-to" class="form-control control d-lg-inline-block mx-2" placeholder="2012-04-19">

                        </div>   
                        <div>
                            <a href="">
                            <button type="submit" class="btn btn-register my-3"> Pokaż </button>
                        </a>
                    </form>
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
                            <?php
                                     if(isset($_SESSION['c_val'])) {

                                         for ($l = 0; $l < $i; $l++) {

                                            echo $_SESSION['c_value'.$l];
                                            unset($_SESSION['c_value'.$l]);
                                         }
                                          unset($_SESSION['c_val']);
                                         
                                        if(isset($_SESSION['c_sum'])) {
                                         echo $_SESSION['c_sum']; 
                                         unset($_SESSION['c_sum']);
                                        }
                                     }
                                     if(!isset($_SESSION['c_val'])) {
                                        $_SESSION['c_sumZero'] = '<tr class="bg-table">
                                        <th>SUMA</th>
                                        <th>0</th>
                                        <td></td>
                                    </tr>';
                                    echo $_SESSION['c_sumZero']; 
                                    unset($_SESSION['c_sumZero']); 
                                     }
                                    ?>
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
                            <?php
                                     if(isset($_SESSION['c_valExp'])) {
                                         for ($k = 0; $k < $j; $k++) {
                                            echo $_SESSION['c_valueExp'.$k];
                                            unset($_SESSION['c_valueExp'.$k]);
                                         }
                                          unset($_SESSION['c_valExp']);
                                         
                                        if(isset($_SESSION['c_sumExp'])) {
                                         echo $_SESSION['c_sumExp']; 
                                         unset($_SESSION['c_sumExp']);
                                        }
                                     }
                                     if(!isset($_SESSION['c_valExp'])) {
                                        $_SESSION['c_sumZero'] = '<tr class="bg-table">
                                        <th>SUMA</th>
                                        <th>0</th>
                                        <td></td>
                                    </tr>';
                                    echo $_SESSION['c_sumZero']; 
                                    unset($_SESSION['c_sumZero']); 
                                     }
                                    ?>
                        </tbody>
                    </table>
                </div>
                <?php
                    if(isset($_SESSION['c_finalSum'])) {
                        echo $_SESSION['c_finalSum'];
                        unset($_SESSION['c_finalSum']); 
                    }
                    if(!isset($_SESSION['c_finalSum'])) {
                        $_SESSION['c_finalSum'] = '<p class="h4 col-12 mb-4">Jeszcze nie posiadasz żadnych danych</p>';
                        echo $_SESSION['c_finalSum'];
                        unset($_SESSION['c_finalSum']); 
                    }
                ?>
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