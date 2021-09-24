<?php
session_start();
require_once "dbconnect.php";

$stmt=$conn->prepare('SELECT name, description FROM categories WHERE id=:id');
$stmt->execute(['id'=>$_GET['id']]);
$result=$stmt->fetchAll(PDO::FETCH_ASSOC)[0];
?>
<!DOCTYPE html>
<html lang="PL">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $result['name'] ?> - Forum</title>
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
        <div>
            <div class="row">
                <div class="col">
                    <h2>Tematy w kategorii: <?= $result['name'] ?></h2>
                </div>
                <div class="col text-end">
                    <a href="create-thread.php?id=<?= $_GET['id'] ?>" class="btn btn-primary">Stwórz nowy temat</a>
                </div>
            </div>
            <ol class="list-unstyled pt-3">
            <?php
            $stmt=$conn->prepare("SELECT * FROM threads WHERE category_id=:id");
            $stmt->execute(["id"=>$_GET["id"]]);
            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row){
                echo '<li class="border p-3 mb-2">
                <h3 class="h4"><a href="thread.php?id='.$row['id'].'">'.$row['topic'].'</a></h3>
            </li>';
            }
            ?>
            </ol>
        </div>

        <footer class="text-center"> &copy; 2137 </footer>
    </div>

</body>

</html>