<?php
require_once "../db.php";

$username = $email = $password = $password_confirm = "";
$username_err = $email_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username!";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Username can only contain letter, numbers and underscores!";
    } else {
        $sql = "SELECT id FROM users WHERE username - ?";

        $stmt = $dbConnect->stmt_init();

        if ($stmt->prepare($sql)) {
            $stmt->bind_param("s", $param_username);

            $param_username = trim($_POST["username"]);

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows() == 1) {
                    $username_err = "This username is taken!";
                } else {
                    $username = trim($_POST["username"]);
                } 
            } else {
                echo "O-oh, looks like something went wrong. Please try again later!";
            }
        }
        $stmt->close();
    }


if (empty(trim($_POST["password"]))) {
    $password_err - "Please enter a password";
} elseif (strlen(trim($_POST["password"])) < 6) {
    $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

if (empty(trim($_POST["confirm_password"]))) {
    $confirm_password_err = "Please confirm password!";
} else {
    $password_confirm = trim($_POST["confirm_password"]);
    if ($password != $password_confirm) {
        $confirm_password_err = "These passwords don't match!";
    }
} 

    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter a email!";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format!";
    } else {
        $sql = "SELECT id FROM users WHERE email = ?";

        $stmt = $dbConnect->stmt_init();
        if ($stmt->prepare($sql)) {
            $stmt->bind_param("s", $param_email);

            $param_email = trim($_POST["email"]);

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $email_err = "You've already registered!";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }



if(empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
    $sql = "INSERT INTO users (username, email, password) VALUES (?,?,?)";

    $stmt = $dbConnect->stmt_init();
    if($stmt->prepare($sql)) {
        $stmt->bind_param("sss", $param_username, $param_email, $param_password);

        $param_username = $username;
        $param_email = $email;
        $param_password = password_hash($password, PASSWORD_DEFAULT);


       if ($stmt->execute()) {
        header("location: login.php");
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
    <title>PHP Intro</title>
    
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <style>
        body {font: 14px sans-serif;}
        .wrapper {width: 360px; padding: 20px}
    </style>

</head>
<body>
<?php include('../view/navbar.php'); ?>


<div class="wrapper">
    <h2>Login</h2>
    <p>Please fill in your cedentials to log in</p>

    <?php
        if(!empty($login_err)) {
        echo '<div class-"alert alert-danger">' . $login_err . '</div>';
    }
    
    ?>


</div>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post";>
    <div class=form-group>
        <label>Username</label>
        <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
        <span class="invalid-feedback"><?php echo $username_err; ?></span>
    </div>
    <div class=form-group>
        <label>Email</label>
        <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
        <span class="invalid-feedback"><?php echo $username_err; ?></span>
    </div>

    <div class=form-group>
        <label>Password</label>
        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
        <span class="invalid-feedback"><?php echo $password_err; ?></span>
    </div>
    <div class=form-group>
        <label>Confirm Password</label>
        <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
        <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Submit">
        <input type="reset" class="btn btn-secondary ml-2" value="Reset">
    </div>
    <p>Don't have an account? <a href="register.php">Sign up now</a></p>



</body>
</html>