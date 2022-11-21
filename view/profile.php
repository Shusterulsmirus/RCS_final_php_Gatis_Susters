<?php
    session_start();
    $guest = TRUE;
    $userOwnsProfile = FALSE;
    $isFollowingThisUser = FALSE;

    require_once "../db.php";
    require_once "../models/User.php";
    require_once "../models/Post.php";
    require_once "../functions/getParamsFromUrl.php";

    
    $userId = getParamsFromUrl("user-id");
    $user = new User($dbConnect);
    $user->getOne($userId);

    $userOwnsProfile = $user->isOwner($_SESSION["id"]);
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === TRUE) {
        $guest = FALSE;
    }

    $isFollowingThisUser = $user->isFollowingMe($_SESSION["id"]);

    $username = $user->getUsername();
    $email = $user->getEmail();
    $followers = $user->getFollowers();

    $allPosts = new Post($dbConnect);
    $allPosts = $allPosts->getAllFromUser($user->getId());

    


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mans profils</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"> 


</head>
<body>

<?php include('../view/navbar.php'); ?>

<h1 style="text-align: center;">Manas receptes</h1>
    <div class="links" style="margin-bottom: 20px; margin-left: 20px;">
        <?php if (!$guest && $userOwnsProfile) { ?>
            <a href="following.php" style="margin-right: 50px;">Kam seko</a>
            <a href="followers.php" style="margin-right: 50px;">Sekotāji</a>
            <a href="blocked.php" style="margin-right: 50px;">Bloķētie</a>
            <a href="hidPosts.php" style="margin-right: 50px;">Paslēptās receptes</a>
    </div>
    <?php } ?>
    <div>
    <?php if (!$guest && !$userOwnsProfile) { ?>
        <?php if (!$isFollowingThisUser) { ?>
            <a href="../controller/FollowUser.php?user-id=<?= $userId ?>&redirect=profile">Piesekot</a>
        <?php } else { ?>
            <a href="../controller/UnfollowUser.php?user-id=<?= $userId ?>&redirect=profile">Atsekot</a>
        <?php } ?>
    <?php } ?>
    </div>

    <?php foreach ($allPosts as $post) {?>
            <a style="display:flex; margin-bottom:20px;" href="post.php?post-id=<?= $post["id"] ?>">
            <div class=""><img style="width:300px; height:200px; margin-left: 10px;" class="img-thumbnail" src="../images/<?php echo $post["image"] ?>"></div>
             <div class="my-auto" >  <h2><?php echo $post["title"] ?></h2> </div> 
            </a>
        <?php } ?>


   

    <?php include('../view/footer.php'); ?>
</body>
</html>