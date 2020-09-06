<?php

session_start();

if (!isset($_SESSION['logged'])){
   header('Location: index.php');
	exit();
    }  

if (isset($_SESSION['logged'])){

    require_once "connect.php"; 
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_query($connection, "SET CHARSET utf8");
    mysqli_query($connection, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");

    if($connection->connect_errno != 0){
        echo "Error: ".$connection->connect_errno;
    }
    else{
        if ($connection){

            $userId = $_SESSION['userId'];
            $resultName = mysqli_query($connection, "SELECT categoryName FROM expensescategoryassigned WHERE userId = '$userId'");
            $i = 0;
            while ($row = $resultName->fetch_assoc()) {

                $categoryName= $row['categoryName'];
                $_SESSION['c_category'.$i] = '<option value="'.$categoryName.'">'.$categoryName.'</option>';
                $i += 1;          
            }
            $_SESSION['c_cat'] = '';
        }
        else{
             throw new Exception($connection->error);        
        }
  }
$connection->close();
}  
    
if(isset($_POST['kwota'])){
	//Flaga
    $validation_OK = true;
    
    require_once "connect.php"; 

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_query($connection, "SET CHARSET utf8");
    mysqli_query($connection, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");

	if($connection->connect_errno != 0){
		echo "Error: ".$connection->connect_errno;
    }
    else{
        $kwota = $_POST['kwota'];

        //walidacja kwoty
        if($kwota != 0){
            $kwota = str_replace(",",".",$kwota); 
            $places = 2;
            $mult = pow(10, $places);
            $newKwota = ceil($kwota * $mult) / $mult;
        }
        else{
            $_SESSION['e_kwota']="Wprowadź liczbę dodatnią, różną od zera!";
            $validation_OK = false;
        }

        //walidacja kategorii
        if(!isset($_POST['kategoria'])){

            $_SESSION['e_kategoria']="Wybierz kategorię!";
            $validation_OK = false;
        }
    
        if($validation_OK == true){
            //Testy zaliczone, dodajemy wydatek do bazy

            if ($connection){

                $kategoria = $_POST['kategoria'];
                $data = $_POST['data'];
                $komentarz = $_POST['komentarz'];
                $userId = $_SESSION['userId'];
                $methodPay = $_POST['metodaPlatnosci'];

                $resultId = mysqli_query($connection, "SELECT * FROM expensescategoryassigned WHERE categoryName = '$kategoria' AND userId = '$userId'");
            
                while ($row = $resultId->fetch_assoc()) {
                    $categoryId= $row['id'];
                    
                   mysqli_query($connection, "INSERT INTO expenses VALUES ('$userId', NULL, '$data', '$newKwota', '$methodPay','$categoryId', '$komentarz')");
                }
                    
                $_SESSION['c_communicat'] = "Wydatek został prawidłowo dodany";
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

    <title>Dodawanie wydatku | TB twojbudzet.com</title>
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
                    <li class="nav-item"> <a class="nav-link btn-active" href="expenses.php"> Dodaj wydatek</a></li>
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
                    <li class="nav-item"> <a class="nav-link" href="settings.php">Ustawienia</a></li>
                    <li class="nav-item"> <a class="nav-link" href="logout.php">Wyloguj się</a></li>
                </ul>
            </div>

        </nav>

    </header>

    <main>
        <div class="container">
            <form method="post">

                <div class="row text-center bg-background my-4 p-sm-3 p-lg-0">

                    <div class="col-lg-10 offset-lg-1 my-5 bg-white bg-shadow">

                        <h1 class="h2 font-weight-bold bg-color my-4">
                            Dodaj swój wydatek
                        </h1>

                    </div>

                    <?php
                        if(isset($_SESSION['c_communicat'])) {
                            echo '<div class="col-lg-10 offset-lg-1 my-2" style="color:#47A8BD; font-weight:bold;">'.$_SESSION['c_communicat'].'</div>';
                            unset($_SESSION['c_communicat']);
                        }
                    ?>

                    <div class="col-lg-5 offset-lg-1">

                        <label class="font-weight-bold" for="kwota">Dodaj kwotę wydatku</label>

                        <input type="text" class="form-control" name="kwota" id="kwota" placeholder="Kwota"
                            aria-label="kwota" aria-describedby="kwota">

                        <?php

                            if(isset($_SESSION['e_kwota'])) {
                                echo '<div style="color: red;">'.$_SESSION['e_kwota'].'</div>';
                                unset($_SESSION['e_kwota']);
                            }
                        ?>

                    </div>

                    <div class="col-lg-5">

                        <label class="font-weight-bold" for="data">Dodaj datę wydatku</label>

                        <input type="date" name="data" class="form-control" id="data" aria-label="data"
                            aria-describedby="data">

                    </div>
                    
                    <div class="form-group col-lg-3 offset-lg-1">
                        <label class="font-weight-bold"> Wybierz metodę płatności </label>
                            <div class="form-control method-pay">
                                <input type="radio" id="gotowka" name="metodaPlatnosci" value="Gotówka" checked>
                                <label for="gotowka">Gotówka</label>
                                <br />
                                <input type="radio" id="debetowa" name="metodaPlatnosci" value="Karta debetowa">
                                <label for="debetowa">Karta debetowa</label>
                                <br />
                                <input type="radio" id="kredytowa" name="metodaPlatnosci" value="Karta kredytowa">
                                <label for="kredytowa">Karta kredytowa</label>  
                            </div>    
                        </label>
                    </div>

                    <div class="form-group col-lg-4">

                        <label class="font-weight-bold" for="przychod-kategoria">Wybierz kategorie dodawanego
                            wydatku</label>
                        <select name="kategoria" multiple class="form-control" id="przychod-kategoria">

                            <?php
                             if(isset($_SESSION['c_cat'])) {
                                 
                                 for ($j = 0; $j < $i; $j++) {
                                     
                                    echo $_SESSION['c_category'.$j];
                                    unset($_SESSION['c_category'.$j]);
                                 }
                                 unset($_SESSION['c_cat']);
                             }
                            ?>

                        </select>

                        <?php
                            if(isset($_SESSION['e_kategoria'])) {
                                echo '<div style="color: red;">'.$_SESSION['e_kategoria'].'</div>';
                                unset($_SESSION['e_kategoria']);
                            }
                        ?>

                    </div>

                    <div class="form-group col-lg-3">

                        <label class="font-weight-bold" for="komentarz"> Dodaj opcjonalnie swój komentarz </label>
                        <textarea name="komentarz" class="form-control" id="komentarz" rows="3"></textarea>

                    </div>

                    <div class="col-lg-5 offset-lg-1 p-1">
                        <button type="submit" class="btn btn-register my-3"> Dodaj wydatek </button>
                    </div>

                    <div class="col-lg-5 p-1">
                        <a href="menu.php">
                            <button type="button" class="btn btn-register my-3"> Anuluj </button>
                        </a>
                    </div>

                </div>
            </form>
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