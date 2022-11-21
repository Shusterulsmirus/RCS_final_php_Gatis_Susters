<?php

    session_start();
    if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != TRUE) {
        header ("location: index.php");
        exit;
    }

    require_once "../db.php";

    $userId = $_SESSION['id'];

    $sql = "SELECT followers FROM users WHERE id = ?";

    $stmt = $dbConnect->stmt_init();
    if ($stmt->prepare($sql)) {
        $stmt->bind_param("i", $param_userId);
        $param_userId = (int)$userId;
        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($followersFromDB);
                $stmt->fetch();

                $followersIdList = str_replace(array('[',']'),'',$followersFromDB);
                $followersIdList = str_replace("'",'',$followersIdList);
                $followersIdList = explode(",",$followersIdList);
            }
        }
    }
    $stmt->close();


    $stmt = $dbConnect->stmt_init();

    $sql = "SELECT id,username FROM users WHERE ";

    if (count($followersIdList) > 0 && $followersIdList[0] !== '') {
        foreach ($followersIdList as $key => $value) {
            $sql = $sql . " id = " . $value;
            if ($key !== count($followersIdList) -1) {
                $sql = $sql. " OR";
            }
        }

     //   $stmt = $dbConnect->stmt_init();

        if ($stmt->prepare($sql)) {
            if ($stmt->execute()) {
                $followingArray = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            }
        }
        $stmt->close();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Followers</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"> 


</head>
<body>
<?php include('../view/navbar.php'); ?>

    <div class="main-wrap">
        <h2 style="text-align: center;">Cilvēki, kuri seko man:</h2>
        <?php if (isset($followingArray)) { ?>
            <?php foreach ($followingArray as $follower) { ?>
                <div>
                    <p><?= $follower['username'] ?></p>
                    <a href="../controller/BlockUser.php?user-id=<?= $follower['id'] ?>&redirect=followers">Block</a>
                </div>
            <?php } ?>
         <?php } ?>
    </div>

    <?php include('../view/footer.php'); ?>
</body>
</html>