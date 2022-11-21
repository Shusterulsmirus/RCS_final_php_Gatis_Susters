<?php

    session_start();
    if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != TRUE) {
        header ("location: index.php");
        exit;
    }

    require_once "../db.php";

    $userId = $_SESSION['id'];

    $sql = "SELECT following FROM users WHERE id = ?";

    $stmt = $dbConnect->stmt_init();
    if ($stmt->prepare($sql)) {
        $stmt->bind_param("i", $param_profileUserId);
        $param_profileUserId = (int)$userId;
        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($followersFromDB);
                $stmt->fetch();

                $followers = str_replace(array('[',']'),'',$followersFromDB);
                $followers = str_replace("'",'',$followers);
                $followers = explode(",",$followers);
            }
        }
    }
    $stmt->close();

    $sql = "SELECT * FROM users WHERE ";

    if (count($followers) > 0 && $followers[0] !== '') {
        foreach ($followers as $key => $value) {
            $sql = $sql . " id = " . $value;
            if ($key !== count($followers) -1) {
                $sql = $sql. " OR";
            }
        }

        $stmt = $dbConnect->stmt_init();
        if ($stmt->prepare($sql)) {
            if ($stmt->execute()) {
                $followersArray = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            }
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Following list</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"> 


</head>
<body>
<?php include('../view/navbar.php'); ?>

    <div class="main-wrap">
        <h2 style="text-align: center;">Cilvēki, kuriem Tu seko:</h2>
            <?php if (isset($followersArray)) { ?>
                <?php foreach ($followersArray as $follower) { ?>
                    <div>
                        <h2><?= $follower['username'] ?></h2>
                        <a href="../controller/UnfollowUser.php?user-id=<?= $follower['id'] ?>&redirect-following">Unfollow</a>
                    </div>
                <?php   } ?>
            <?php } ?>
    </div>

    <?php include('../view/footer.php'); ?>
</body>
</html>