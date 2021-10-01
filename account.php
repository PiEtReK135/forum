<?php
session_start();
require_once "dbconnect.php";
if(isset($_POST["new-password"])&&isset($_POST["new-password-confirm"])){
    if($_POST["new-password"]==$_POST["new-password-confirm"]){
        $stmt=$conn->prepare("UPDATE users SET password = :password WHERE id = :id ");
        $stmt->execute([
            "password"=>$_POST["new-password"],
            "id"=>$_SESSION["id"]
        ]);
    }
}
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
        </div>
        <div class="row">
            <div class="col-12 col-lg-8">

                <h1>Moje konto</h1>
                <h2 class="h4">Zmień hasło</h2>

                <!-- formularz dwa inputy do zmiany hasła -->
                <form method="POST" class="pt-3">
                    <label for="new-password">Nowe Hasło</label>
                    <input type="password" id="new-password" name="new-password">
                    <div class="py-2">
                        <label for="new-password-confirm">Powtórz Hasło</label>
                        <input type="password" id="new-password-confirm" name="new-password-confirm">
                    </div>
                    <input type="submit">
                </form>
            </div>
        </div>

        <footer class="text-center"> &copy; 2137 </footer>
    </div>

</body>

</html>