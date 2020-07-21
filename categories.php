 <?php

session_start();

if (!isset($_SESSION['logged'])){
   header('Location: login.php');
	exit();
    }  


if (isset($_SESSION['logged'])){

    require_once "connect.php"; 
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

    if($connection->connect_errno!=0){
        echo "Error: ".$connection->connect_errno;
    }
    else{
        if ($connection){

            $userId = $_SESSION['userId'];
            $resultName = mysqli_query($connection, "SELECT categoryName FROM incomescategoryassigned WHERE userId = '$userId'");
            $i = 0;
            while ($row = $resultName->fetch_assoc()) {

                $categoryName= $row['categoryName'];
                
                $_SESSION['c_category'.$i] = '<option value="'.$categoryName.'">'.$categoryName.'</option>';
                $_SESSION['c_categoryDelete'.$i] = '<h5 name="categoryDelete" class="d-inline-block col-6 my-3">'.$categoryName.'</h5> <button class="btn btn-secondary font-weight-bold" style="background-color: #F5E683; color: black; border-color:#F5E683;">Usuń</button>'; 
                $i += 1;          
            }
            
            //$resultNameExp = mysqli_query($connection, "SELECT categoryName FROM expensescategoryassigned WHERE userId = '$userId'");
            //$j = 0;
            //while ($row = $resultNameExp->fetch_assoc()) {

              //  $categoryNameExp= $row['categoryName'];
                
                //$_SESSION['c_categoryExp'.$j] = '<option value="'.$categoryName.'">'.$categoryName.'</option>';
                //$_SESSION['c_categoryDeleteExp'.$j] = '<h5 name="categoryDeleteExp" class="d-inline-block col-6 my-3">'.$categoryNameExp.'</h5> <button class="btn btn-secondary font-weight-bold" style="background-color: #F5E683; color: black; border-color:#F5E683;">Usuń</button>'; 
                //$j += 1;          
            //}
            
            $_SESSION['c_cat'] = '';
            $_SESSION['c_catDelete'] = '';
            //$_SESSION['c_catDeleteExp'] = '';

        }
        else{
             throw new Exception($connection->error);        
        }
  }
$connection->close();
}  

if(isset($_POST['newCategory'])){
    require_once "connect.php"; 

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

    if($connection->connect_errno!=0){
        echo "Error: ".$connection->connect_errno;
    }
    else{
        $userId = $_SESSION['userId'];
        $newCategory = $_POST['newCategory'];
    
        $resultat = $connection->query("SELECT categoryName FROM incomescategoryassigned WHERE categoryName='$newCategory'");
				
		if (!$resultat) throw new Exception($connection->error);
			
			$numberOfCategory = $resultat->num_rows;
			if($numberOfCategory > 0){
				$_SESSION['e_newCategory']="Istnieje już taka kategoria!";
            }
        else{
             mysqli_query($connection, "INSERT INTO incomescategoryassigned VALUES (NULL, '$userId', '$newCategory')");
             $_SESSION['c_newCategory']="Prawidłowo dodałeś nową kategorię!";
        }
    }
    $connection->close(); 
}

?>


<!DOCTYPE HTML>
<html lang="pl">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title> Zarządzanie kategoriami | TB twojbudzet.com</title>
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
                    <li class="nav-item"> <a class="nav-link btn-active" href="settings">Ustawienia</a></li>
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
                        Zarządzanie kategoriami
                    </h1>

                </div>
               

                <div class="col-lg-10 offset-lg-1 my-4 bg-white shadow p-3">
                       <?php
                            if(isset($_SESSION['c_newCategory'])) {
                                echo '<div style="color: #47A8BD;">'.$_SESSION['c_newCategory'].'</div>';
                                unset($_SESSION['c_newCategory']);
                            }
                        ?>
                       <?php
                            if(isset($_SESSION['e_newCategory'])) {
                                echo '<div style="color: red; font-weight: bold">'.$_SESSION['e_newCategory'].'</div>';
                                unset($_SESSION['e_newCategory']);
                            }
                        ?>

                    <div class="col-6 offset-3 border mt-3"></div>

                    <h3 class="h4 font-weight-bold bg-color my-4">
                        Przychód
                    </h3>

                    <!--Incomes categories list-->
                    <div class="col-lg-6 offset-lg-3 p-3">

                        <button type="button" class="btn btn-settings" data-toggle="modal"
                            data-target="#modal-incomes-category-list">
                            Wyświetl listę kategorii
                        </button>

                    </div>

                    <div class="modal fade" id="modal-incomes-category-list" tabindex="-1" role="dialog"
                        aria-labelledby="modal-incomes-category-list" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title font-weight-bold" id="incomes-cattegory-list">Lista kategorii
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                     <?php
                                     if(isset($_SESSION['c_cat'])) {

                                         for ($j = 0; $j < $i; $j++) {

                                            echo $_SESSION['c_category'.$j];
                                            echo '<div class="col-6 offset-3 border my-2"></div>';
                                            unset($_SESSION['c_category'.$j]);
                                         }
                                          unset($_SESSION['c_cat']);
                                     }
                                    ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary font-weight-bold"
                                        data-dismiss="modal">Powrót</button>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!--Incomes Add category-->
                    <div class="col-lg-6 offset-lg-3 p-3">

                        <button type="button" class="btn btn-settings" data-toggle="modal"
                            data-target="#modal-incomes-add-category">
                            Dodaj kategorię
                        </button>

                    </div>

                    <div class="modal fade" id="modal-incomes-add-category" tabindex="-1" role="dialog"
                        aria-labelledby="modal-incomes-add-category" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form method="post">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title font-weight-bold" id="incomes-add-cattegory">Dodawanie
                                            kategorii</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>                                     
                                    <div class="modal-body">
                                        <input class="d-inline-block form-control mt-3" type="text" name="newCategory" id="incomes-add-new-category"
                                            placeholder="Kategoria" aria-label="incomes-add-new-category"
                                            aria-describedby="incomes-add-new-category">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-secondary font-weight-bold" style="background-color: #F5E683; color: black; border-color:#F5E683;">Dodaj</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!--Incomes Delate category-->
                    <div class="col-lg-6 offset-lg-3 p-3">

                        <button type="button" class="btn btn-settings" data-toggle="modal"
                            data-target="#modal-incomes-delete-category">
                            Usuń kategorię
                        </button>

                    </div>

                    <div class="modal fade" id="modal-incomes-delete-category" tabindex="-1" role="dialog"
                        aria-labelledby="modal-incomes-delete-category" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title font-weight-bold" id="incomes-delete-cattegory">Usuwanie kategorii</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post">
                                    <div class="modal-body">
                                        <div class="border my-1">
                                                <?php
                                                 if(isset($_SESSION['c_catDelete'])) {

                                                     for ($j = 0; $j < $i; $j++) {

                                                        echo $_SESSION['c_categoryDelete'.$j];
                                                        unset($_SESSION['c_categoryDelete'.$j]);
                                                     }
                                                     unset($_SESSION['c_catDelete']);
                                                 }
                                                ?>
                                           
                                        </div> 
                                    </div>
                                </form>
                                <div class="modal-footer">
                                    <button type="submit" class="btn-sub-settings font-weight-bold">Powrót</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 offset-3 border mt-3"></div>

                    <h3 class="h4 font-weight-boldbg-color my-4">
                        Wydatek
                    </h3>

                    <!--Expenses Categories list-->
                    <div class="col-lg-6 offset-lg-3 p-3">

                        <button type="button" class="btn btn-settings" data-toggle="modal"
                            data-target="#modal-expenses-category-list">
                            Wyświetlej listę kategorii
                        </button>

                    </div>

                    <div class="modal fade" id="modal-expenses-category-list" tabindex="-1" role="dialog"
                        aria-labelledby="modal-expenses-category-list" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title font-weight-bold" id="expenses-cattegory-list">Lista kategorii</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    
                                     <div class="modal-body">
                                    //<?php
                                     //if(isset($_SESSION['c_cat'])) {

                                       //  for ($j = 0; $j < $i; $j++) {

                                         //   echo $_SESSION['c_category'.$j];
                                           // echo '<div class="col-6 offset-3 border my-2"></div>';
                                        //    unset($_SESSION['c_category'.$j]);
                                        // }
                                        //  unset($_SESSION['c_cat']);
                                    // }
                                    // ?>
                                </div>
                            
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary font-weight-bold"
                                        data-dismiss="modal">Powrót</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Expenses Add category-->
                    <div class="col-lg-6 offset-lg-3 p-3">

                        <button type="button" class="btn btn-settings" data-toggle="modal"
                            data-target="#modal-expenses-add-category">
                            Dodaj kategorię
                        </button>

                    </div>

                    <div class="modal fade" id="modal-expenses-add-category" tabindex="-1" role="dialog"
                        aria-labelledby="modal-expenses-add-category" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title font-weight-bold" id="expenses-add-cattegory">Dodawania
                                        kategorii</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input class="d-inline-block form-control mt-3" type="text" id="expenses-add-new-category"
                                        placeholder="Kategoria" aria-label="expenses-add-new-category"
                                        aria-describedby="expenses-add-new-category">
                                    <button class="d-inline-block btn-sub-mini-setting ml-1">Dodaj</button>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary font-weight-bold"
                                        data-dismiss="modal">Anuluj</button>
                                    <button type="submit" class="btn-sub-settings font-weight-bold">Zapisz</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Expenses Delate category-->
                    <div class="col-lg-6 offset-lg-3 p-3">

                        <button type="button" class="btn btn-settings" data-toggle="modal"
                            data-target="#modal-expenses-delete-category">
                            Usuń kategorię
                        </button>

                    </div>

                    <div class="modal fade" id="modal-expenses-delete-category" tabindex="-1" role="dialog"
                        aria-labelledby="modal-expenses-delete-category" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title font-weight-bold" id="expenses-delete-cattegory">Usuwanie kategorii</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="border my-1">
                                        <h5 class="d-inline-block col-6 my-2">Jedzenie</h5> <button class="d-inline-block btn-sub-mini-setting my-2">Usuń</button>
                                    </div> 
                                    <div class="border my-1">
                                    <h5 class="d-inline-block col-6 my-2">Hobby</h5> <button class="d-inline-block 
                                    btn-sub-mini-setting my-2">Usuń</button>
                                </div> 

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary font-weight-bold"
                                        data-dismiss="modal">Anuluj</button>
                                    <button type="submit" class="btn-sub-settings font-weight-bold">Zapisz</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 offset-3 border mt-3"></div>

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

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>

    <script src="js/bootstrap.min.js"></script>


</body>
</html>