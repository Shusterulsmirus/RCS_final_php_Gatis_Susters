<?php

require_once "../db.php";
require_once "../models/User.php";
require_once "../models/Post.php";

$user = new User($dbConnect);

$usernameOrEmail = $password = "";
$usernameOrEmail_err = $password_err = $login_err = "";

$username = $email = $password = $password_confirm = "";
$username_err = $email_err = $password_err = $confirm_password_err = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["usernameOrEmail"]))) {
        $usernameOrEmail_err = "Please enter a username or Email!";
    } else {
        $usernameOrEmail = trim($_POST["usernameOrEmail"]);
    }

    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password!";
    } else {
        $password = trim($_POST["password"]);
    }

    if(empty($usernameOrEmail_err) && empty($password_err)) {
        $sql = "SELECT id, username, email, password FROM users WHERE username = ? OR email = ?";

        $stmt = $dbConnect->stmt_init();
        if($stmt->prepare($sql)) {
            $stmt->bind_param("ss", $param_usernameOrEmail, $param_usernameOrEmail);

            $param_usernameOrEmail = $usernameOrEmail;

           if ($stmt->execute()) {
               $stmt->store_result();
          
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $username, $email, $hashed_password);
                    if($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();

                            $_SESSION["loggedin"] = TRUE;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                         //   $retrievedUsername = $username;

                            header("location: index.php");
                        } else {
                            $login_err = "Invalid username/email or password!";
                        }
                    }
                } else {
                    $login_err = "Invalid username or password!";
                }
            }
            $stmt->close();
        }
    }
}

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
    $password_err = "Please enter a password";
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
        header("location: ../view/index.php");
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
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Navbar</title>
<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<link rel="stylesheet" href="../navbar.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head> 
<body>
<nav class="navbar navbar-default navbar-expand-lg navbar-dark">
	<div class="navbar-header">
	<a class="brand-image">
		<a href="../view/index.php">
			<img class="brand-image-class" src="/assets/images/RECIPY-small.png" alt="" style="width:90px; height:50px; border-radius: 10px;">
		</a>
	</a>	

		<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
			<span class="navbar-toggler-icon"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>
	<!-- Collection of nav links, forms, and other content for toggling -->
	<div id="navbarCollapse" class="collapse navbar-collapse">
		<ul class="nav navbar-nav">
			<li class="home" style="background-color: darkorange; border-radius: 20px;"><a style="color: black;" href="explore.php">Visas receptes</a></li>
			<li>
			<?php 
				if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === TRUE){
					?> <a style="color: black;" href="profile.php?user-id=<?= $_SESSION["id"] ?>">Mans profils</a>
                    <li><a style="color: black;" href="myrecipe.php">Izveidot recepti</a></li>	 <?php
				}				
			?>
			</li>	
            <li><a style="color: black;" href="news.php">Jaunumi</a></li>
			<li><a style="color: black;" href="contacts.php">Kontakti</a></li>
		</ul>

		<ul class="nav navbar-nav navbar-right" style="text-align: right; margin-right: 0; margin-left: auto;">
            <div class="dropdown" aria-labelledby="dropdownLogin">		
			<li class="navbar-login">
            <?php 
				if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === TRUE){
                    ?> <h2>Labu apetīti, <a style="color: darkorange;" href="profile.php?user-id=<?= $_SESSION["id"] ?>">   <?= $_SESSION["username"] ?></h2></a> <?php
					echo '<a style="color: gray;" href="../controller/logout.php">Iziet</a>';
				} else {
					echo '<a data-toggle="dropdown" id="dropdownLogin" class="dropdown-toggle btn mt-1" href="#">Ienākt</a>';
                } 
			?>
                 
				<ul class="dropdown-menu form-wrapper" style="min-width: 20em;">					
					<li>
						<form style="margin-left: 5px; margin-right: 5px;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                            <form style="margin-left: 5px; margin-right: 5px;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post";>
                        <div class=form-group>
                            <label>Lietotājvārds vai Epasts</label>
                                <input type="text" name="usernameOrEmail" class="form-control <?php echo (!empty($usernameOrEmail_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $usernameOrEmail; ?>">
                                <span class="invalid-feedback"> <?php echo $usernameOrEmail_err; ?> </span>
                        </div>

                        <div class=form-group>
                            <label>Parole</label>
                                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                                <span class="invalid-feedback"> <?php echo $password_err; ?> </span>
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Ienākt">
                        </div>

                        <?php
            if(!empty($login_err)) {
                echo '<div class-"alert alert-danger">' . $login_err . '</div>';
            }
        ?>
						</form>
					</li>
				</ul>
			</li>
        </div>	
            

        
        <div class="dropdown" aria-labelledby="dropdownRegister" aria-haspopup="true" aria-expanded="false">
            <li>
            <?php 
				if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === TRUE){
                    ?>  <?php } else {
                				
                    echo '<a href="#" style="color: darkorange;" data-toggle="dropdown" class="btn btn-light dropdown-toggle get-started-btn mt-1 mb-1" id="dropdownRegister">Reģistrēties</a>';
                } 
				?>
				<ul class="dropdown-menu form-wrapper" style="min-width: 20em;">	
                    
                <form style="margin-left: 5px; margin-right: 5px;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post";>
                <div class=form-group>
                    <label>Lietotājvārds</label>
                        <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                        <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>

                <div class=form-group>
                    <label>Epasts</label>
                        <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                        <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>

                <div class=form-group>
                    <label>Parole</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>

                <div class=form-group>
                <label>Apstiprināt paroli</label>
                    <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password_confirm; ?>">
                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Reģistrēties">
                </div>					
						</form>
					</li>
				</ul>
			</li>
		</ul>
        </div>
	</div>
</nav>
</body>



<script>
	// Prevent dropdown menu from closing when click inside the form
	$(document).on("click", ".navbar-right .dropdown-menu", function(e){
		e.stopPropagation();
	});
</script>

</html>                                                        