<?php

    session_start();
    if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != TRUE) {
        header ("location: index.php");
        exit;
    }

    require_once "../db.php";

    $guest = TRUE;
    $userOwnsProfile = FALSE;
    $isBlockedThisUser = FALSE;


    $userId = $_SESSION['id'];

    $sql = "SELECT blocked FROM users WHERE id = ?";

    $stmt = $dbConnect->stmt_init();
    if ($stmt->prepare($sql)) {
        $stmt->bind_param("i", $param_userId);
        $param_userId = (int)$userId;
        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($blockedFromDB);
                $stmt->fetch();

                $blockedIdList = str_replace(array('[',']'),'',$blockedFromDB);
                $blockedIdList = str_replace("'",'',$blockedIdList);
                $blockedIdList = explode(",",$blockedIdList);
            }
        }
    }
    $stmt->close();


    $stmt = $dbConnect->stmt_init();

    $sql = "SELECT id,username FROM users WHERE ";

    if (count($blockedIdList) > 0 && $blockedIdList[0] !== '') {
        foreach ($blockedIdList as $key => $value) {
            $sql = $sql . " id = " . $value;
            if ($key !== count($blockedIdList) -1) {
                $sql = $sql. " OR";
            }
        }

     //   $stmt = $dbConnect->stmt_init();

        if ($stmt->prepare($sql)) {
            if ($stmt->execute()) {
                $blockedArray = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
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
    <title>Blocked</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"> 


</head>
<body>
<?php include('../view/navbar.php'); ?>

    <div class="main-wrap">
        <h2 style="text-align: center;">Cilvēki, kuri ir nobloķēti:</h2>
        <?php if (isset($blockedArray)) { ?>
            <?php foreach ($blockedArray as $blocked) { ?>
                <div>
                    <p><?= $blocked['username'] ?></p>
                    <a href="../controller/UnblockUser.php?user-id=<?= $userId ?>&redirect=profile">Atbloķēt</a>
                    <!-- <a href="../controller/BlockUser.php?user-id=<?= $blocked['id'] ?>&redirect=followers">Bloķēt</a> -->
                </div>
            <?php } ?>
         <?php } ?>

        <?php if (!$guest && !$userOwnsProfile) { ?>
        <?php if (!$isBlockedThisUser) { ?>
            <a href="../controller/BlockUser.php?user-id=<?= $userId ?>&redirect=profile">Nobloķēt</a>
        <?php } else { ?>
            <a href="../controller/UnblockUser.php?user-id=<?= $userId ?>&redirect=profile">Atbloķēt</a>
        <?php } ?>
    <?php } ?>

    </div>

    <?php include('../view/footer.php'); ?>
</body>
</html>