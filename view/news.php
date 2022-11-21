<?php

    session_start();

    require_once "../db.php";

    $subscribe = "";
    $subscribe_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        if (empty(trim($_POST["subscribe"]))) {
            $email_err = "Please enter a email!";
        } elseif (!filter_var($_POST["subscribe"], FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format!";
        } else {
            $sql = "SELECT id FROM subscribe WHERE subscribe = ?";

            $stmt = $dbConnect->stmt_init();
            if ($stmt->prepare($sql)) {
                $stmt->bind_param("s", $param_subscribe);

                $param_subscribe = trim($_POST["subscribe"]);

                if ($stmt->execute()) {
                    $stmt->store_result();

                    if ($stmt->num_rows == 1) {
                        $subscribe_err = "You've already registered!";
                    } else {
                        $subscribe = trim($_POST["subscribe"]);
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
                $stmt->close();
            }
        }



    if(empty($subscribe_err)) {
        $sql = "INSERT INTO subscribe (subscribe) VALUE (?)";

        $stmt = $dbConnect->stmt_init();
        if($stmt->prepare($sql)) {
            $stmt->bind_param("s", $param_subscribe);

            $param_subscribe = $subscribe;

            if ($stmt->execute()) {
                // header("location: ../view/contact.php");

                echo 'Paldies, Jūs esat pierakstījies saņemt mūsu ziņas!';
            } else {
                echo "Something went wrong!";
            }
        }
        $stmt->close();
    }
    }

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

         <!-- piesekot jaunumiem -->
        <div class="row justify-content-md-center" style="text-align: center;">
        <div class="col-lg-4 col-md-4">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post";>
            <div class=form-group>
                <label>Piesekot jaunumiem:</label>
                <input type="text" name="subscribe" placeholder="Ievadiet Jūsu epastu..." class="form-control <?php echo (!empty($subscribe_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $subscribe; ?>">
                <span class="invalid-feedback"><?php echo $subscribe_err; ?></span>
                <input type="submit" class="btn btn-primary" value="Piesekot">
            </div>
        </div>
    </div>


    
    <?php include('../view/footer.php'); ?>
</body>

</html>