<?php

    session_start();

    require_once "../db.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipy</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../footer.css">
    <link rel="stylesheet" href="../main-wrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"> 

    <style>
        body {font: 14px sans-serif;}
        .wrapper {width: 360px; padding: 20px}
        .main-wrap {margin-left: 20px;}
        img {width: 800px; height: 800px;}
        .welcome {margin-left:0; margin-right:0; text-align:center;}

    </style>
</head>
<body>
    <?php include('../view/navbar.php'); ?>

    <div class="main-wrap" style="margin-bottom: 20px;">
        <h1 class="welcome">Pie mums vari izveidot savu recepti, kurai varēsi piekļūt jebkurā brīdī</h1>
        <img class="center-block rounded" src="../assets/images/landing.png" alt="">
        <br>
        <img class="center-block rounded" src="../assets/images/spicy_burger.png" alt="" >
        <br>
        <img class="center-block rounded" src="../assets/images/burger_recipe.png" alt="" >
    </div>


    
    <?php include('../view/footer.php'); ?>
</body>

</html>

