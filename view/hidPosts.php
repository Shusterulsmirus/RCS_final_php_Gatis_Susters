<?php

    session_start();

    require_once "../db.php";
    require_once "../models/Post.php";
    require_once "../models/User.php";
    require_once "../functions/getParamsFromUrl.php";

    $post = new Post($dbConnect);

    $postImageName = $post->getImageName();

    $sql = "SELECT * FROM posts WHERE to_hide = 1";

    $stmt = $dbConnect->stmt_init();
    if ($stmt->prepare($sql)) {
        if ($stmt->execute()) {
            $allHidePosts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } else { 
            echo "Error!";
        }
    }

    $userOwnsThisPost = $post->userOwnsThisPost($_SESSION["id"]);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"> 


</head>
<body>
<?php include('../view/navbar.php'); ?>

    <h1 style="text-align: center;">Paslēptās receptes</h1>

        <?php foreach ($allHidePosts as $post) {?>
            
            <a style="display:flex; margin-bottom:20px;" href="post.php?post-id=<?= $post["id"] ?>">
            <div class="post-image"><img style="width:300px; height:200px; margin-left: 10px;" src="../images/<?php echo $post["image"] ?>"></div>
                <h2><?php echo $post["title"] ?></h2>
            </a>
            
        <?php } ?>

        <?php if ($userOwnsThisPost) { ?>
            <a href="../controller/toUnhide.php?post-id=<?= $postId ?>">Neslēpt recepti</a>
        <?php } ?>


<?php include('../view/footer.php'); ?>        
</body>
</html>