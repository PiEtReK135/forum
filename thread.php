<?php
session_start();
require_once "dbconnect.php";

$stmt = $conn->prepare('SELECT * FROM threads WHERE id=:id');
$stmt->execute(['id' => $_GET['id']]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];


// Dodawanie wpisu do bazy danych

if(isset($_POST["text"]) && isset($_SESSION['id'])){
    if(strlen($_POST["text"]) < 2){
        exit("Wpis musi mieć minimum 3 znaki");
    }
    $stmt=$conn->prepare("INSERT INTO posts (user_id, thread_id, text, datetime) VALUES (:user_id, :thread_id, :text, :datetime)");
    $stmt->execute(["user_id"=>$_SESSION["id"], "thread_id"=>$_GET["id"], "text"=>$_POST["text"], "datetime"=>date('Y-m-d H:i:s')]);

    header('Location: thread.php?id='.$_GET['id']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="PL">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $result['topic'] ?> - Forum</title>
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

                        if (isset($_SESSION["id"])) {
                        ?>
                            <li class="pe-3"><a href="account.php">Moje konto</a></li>
                            <li><a href="logout.php">Wyloguj się</a></li>

                        <?php
                        } else {

                        ?>
                            <li class="pe-3"><a href="login.php">Zaloguj się</a></li>
                            <li><a href="register.php">Zarejestruj się</a></li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div>
            <h2><?= $result['topic'] ?></h2>
            <ol class="list-unstyled pt-3">
                <?php
                $stmt = $conn->prepare("SELECT *,posts.id AS p_id FROM posts INNER JOIN users ON posts.user_id=users.id WHERE thread_id=:id");
                $stmt->execute(["id" => $_GET["id"]]);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                    echo '<li class="p-3 border mb-3" id="'.$row['p_id'].'"><div class="text-success fw-bold">'.$row['login'].'</div><div>'.$row['text'].'</div><div>'.$row['datetime'].'</div></li>';
                }
                ?>
            </ol>

            <!-- Dodawanie wpisu -->
            <?php
                if(isset($_SESSION['id'])){
            ?>
            <form class="pt-5" method="POST">
                <div class="form-group row">
                    <label for="text" class="col-sm-2 col-form-label">Treść</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="text" name="text" ></textarea>
                    </div>
                </div>
                <div>
                    <button class="btn btn-primary">Dodaj</button>
                </div>
            </form>
            <?php       
             }
            ?>

        </div>

        <footer class="text-center"> &copy; 2137 </footer>
    </div>

</body>

</html>