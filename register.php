<?php
if(isset($_POST["login"])&&isset($_POST["email"])&&isset($_POST["password"])&&isset($_POST["repeat-password"])){
    require_once "dbconnect.php";
    if(strlen($_POST["login"]) < 3 || strlen($_POST["login"]) > 15){
        echo "Login musi zawierać więcej niż 3 znaki i mniej niż 15 znaków!";
        exit;
    }
    if($_POST["password"]!=$_POST["repeat-password"]){
        echo "Hasła muszą się zgadzać";
        exit;
    }
    $stmt=$conn->prepare("insert into users(login,email,password,permissions) values(:login, :email, :password, :permissions)");
    $stmt->execute(array("login"=>$_POST["login"],"email"=>$_POST["email"],"password"=>$_POST["password"],"permissions"=>1));
}
?><!DOCTYPE html>
<html lang="PL">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja do forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>

<body>
    <h1 class="text-center mt-5 pt-5">Zarejestruj się</h1>
    <div class="mx-auto border p-4" style="width: 400px;">
        <form method="post">
            <div class="mb-3 row">
                <label for="login" class="col-sm-2 col-form-label">Login</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="login" name="login">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" name="email">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="password" class="col-sm-2 col-form-label">Hasło</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="password" name="password">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="repeat-password" class="col-sm-2 col-form-label">Powtórz hasło</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="repeat-password" name="repeat-password">
                </div>
            </div>
            <div class="text-end">
                <button class="btn btn-primary">Zarejestruj się</button>
            </div>
        </form>
    </div>
</body>

</html>