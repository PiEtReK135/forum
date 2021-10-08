<?php
session_start();
require_once "dbconnect.php";
?>
<!DOCTYPE html>
<html lang="PL">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="py-5">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <span class="h1">Forum</span>
                </div>
                <div class="col-12 col-lg-6">
                    <ul class="list-unstyled d-flex">
                        <?php
                        
                        if(isset($_SESSION["id"])){
                        ?>
                        <li class="pe-3"><a href="account.php">Moje konto</a></li>
                        <li><a href="logout.php">Wyloguj się</a></li>

                        <?php
                        }else{

                        ?>
                        <li class="pe-3"><a href="login.php">Zaloguj się</a></li>
                        <li><a href="register.php">Zarejestruj się</a></li>
                        <?php   
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <ol class="list-unstyled pt-3">
                <li class="border p-3 mb-2">
                    <h3 class="h4"> <a href="Konto premium.php">Konto premium</a> </h3>
                    <p class="m-0">Brak reklam i przedpremierowe artykuły</p>
                </li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12 col-lg-8">
                <h2>Kategorie</h2>
                <ol class="list-unstyled pt-3">
                    <?php
                        $stmt=$conn->prepare("select * from categories");
                        $stmt->execute();
                        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach($result as $row)  {
                            echo '<li class="border p-3 mb-2">
                            <h3 class="h4"><a href="category.php?id='.$row['id'].'">'.$row["name"].'</a></h3>
                            <p class="m-0">'.$row["description"].'</p>
                        </li>';
                        }
                    ?>
                     <!-- <li class="border p-3 mb-2">
                        <h3 class="h4">Gry</h3>
                        <p class="m-0">Nadchodzące premiery</p>
                    </li>
                    <li class="border p-3 mb-2">
                        <h3 class="h4">Książki</h3>
                        <p class="m-0">Bestsellery roku</p>
                    </li>
                    <li class="border p-3 mb-2">
                        <h3 class="h4">Filmy</h3>
                        <p class="m-0">Natchodzące filmy</p>
                    </li> -->
                </ol>
            </div>
            <div class="col-12 col-lg-4">
                <!-- zrób żeby tu wyświetlały się ostatnio dodane tematy i posty (tabele threads i posts). Do kwerendy wykorzystaj "ORDER BY id DESC LIMIT 3" -->
                <h2>Ostatnio dodane</h2>
                <h3>Tematy</h3>
                <!-- w pętli wypisz (foreach i echo) -->
                <ol class="list-unstyled pt-3">
                    <?php
                    $stmt=$conn->prepare("SELECT id,topic FROM threads ORDER BY id DESC LIMIT 3");
                    $stmt->execute();
                    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach($result as $row){
                        echo '<li class="border p-3 mb-2">
                        <h3 class="h4"><a href="thread.php?id='.$row['id'].'">'.$row['topic'].'</a></h3>
                    </li>';
                    }
                    ?>
                    
                </ol>
                <h3>Posty</h3>
                <ol class="list-unstyled pt-3">
                    <?php
                    $stmt=$conn->prepare("SELECT posts.id AS p_id, text, thread_id, login FROM posts INNER JOIN users ON posts.user_id=users.id ORDER BY posts.id DESC LIMIT 3");
                    $stmt->execute();
                    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach($result as $row){
                        echo '<li class="border p-3 mb-2">
                        <h3 class="h4"><a href="thread.php?id='.$row['thread_id'].'#'.$row['p_id'].'">'.$row["text"].'</a></h3>
                        <p class="m-0">'.$row["login"].'</p>
                    </li>';
                    }
                    ?>
                    
                </ol>
            </div>
        </div>

        <footer class="text-center"> &copy; 2137 </footer>
    </div>

</body>

</html>