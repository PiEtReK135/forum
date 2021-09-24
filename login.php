<?php
session_start();

if(isset($_POST["email"])&&isset($_POST["password"])){
    require_once "dbconnect.php";
    $stmt=$conn->prepare("SELECT * FROM users WHERE email=:email AND password=:password");
    $stmt->execute(array("email"=>$_POST["email"],"password"=>$_POST["password"]));
    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
    if(count($result)){
        $_SESSION["id"]=$result[0]["id"];
        header("Location: index.php");
        exit;
    }else{
        echo "Niepoprawne dane";
    }
}
?>
<!DOCTYPE html>
<html lang="PL">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie do forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>

<body>
    <h1 class="text-center mt-5 pt-5">Zaloguj się</h1>
    <div class="mx-auto border p-4" style="width: 400px;">
        <form method="post">

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
            <div class="text-end">
                <button class="btn btn-primary">Zaloguj się</button>
            </div>
        </form>
    </div>
</body>

</html>