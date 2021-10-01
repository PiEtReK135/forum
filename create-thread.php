<?php
session_start();
require_once "dbconnect.php";

if(isset($_SESSION["id"])==false){
    header("Location: login.php");
    exit;
}

if(isset($_POST["topic"])&&isset($_POST["text"])){
    $stmt=$conn->prepare("INSERT INTO threads (user_id, category_id, topic) VALUES (:user_id, :category_id, :topic)");
    $stmt->execute(["user_id"=>$_SESSION["id"],"category_id"=>$_GET["id"],"topic"=>$_POST["topic"]]);
    $threadId = $conn->lastInsertId();
    
    $stmt=$conn->prepare("INSERT INTO posts (user_id, thread_id, text) VALUES (:user_id, :thread_id, :text)");
    $stmt->execute(["user_id"=>$_SESSION["id"],"thread_id"=>$threadId,"text"=>$_POST["text"]]);

    header("Location: thread.php?id=".$threadId);
    exit;
}

?>
<!DOCTYPE html>
<html lang="PL">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stwórz nowy wątek - Forum</title>
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
            <h2>Stwórz nowy temat</h2>

            <form method="POST">
                <div class="mb-3 row">
                    <label for="topic" class="col-sm-2 col-form-label">Temat</label>
                    <div class="col-sm-10">
                        <input name="topic" type="text" class="form-control" id="topic">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="text" class="col-sm-2 col-form-label">Treść</label>
                    <div class="col-sm-10">
                        <textarea id="text" name="text" class="form-control"></textarea>
                    </div>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Stwórz</button>
                </div>

            </form>

        </div>

        <footer class="text-center"> &copy; 2137 </footer>
    </div>

</body>

</html>