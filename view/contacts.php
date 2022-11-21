<?php

   session_start();

    require_once "../db.php";
    require_once "../models/User.php";
    require_once "../models/Post.php";

    ?>

   


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacts</title>
    <link rel="stylesheet" href="../contacts.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

</head>
<body>
    


<?php include('../view/navbar.php'); ?>


<section id="kontakti" style="text-align:center;">
    <h1>Kontakti</h1>

<div class="col-lg-12 map-address">
    <h4>Mūs vari atrast šeit:</h4>
    <h3>Doma laukums 2, Rīga, Latvia</h3>
</div>
    <div class="content-contact">
        <div class="google-map"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2175.9721931054264!2d24.1015911159773!3d56.94927768089024!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46eecfd75c3457a9%3A0x8732e3e548cd3748!2sDoma%20laukums%202%2C%20Centra%20rajons%2C%20R%C4%ABga%2C%20LV-1050!5e0!3m2!1sen!2slv!4v1600886783452!5m2!1sen!2slv" width="800" height="600" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe></div>
    </div>
    <address>
<h4>Vai arī vari zvanīt <a class="phone" href="tel:+37126642848">(+371) 2664xxx</a></h4>
<h4>Epasts <a href="mailto: gatis.susters@gmail.com">gatis.susters@gmail.com</a> </h4>
</address>
   </section>

<?php include('../view/footer.php'); ?>

   </body>
</html>