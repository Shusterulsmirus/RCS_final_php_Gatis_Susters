<?php
    require_once "../db.php";
    require_once "../models/Post.php";
    require_once "../models/User.php";
    require_once "../functions/getParamsFromUrl.php";

    $postId = getParamsFromUrl("post-id");

    $post = new Post($dbConnect);

    if ($post->getOne($postId) === FALSE) {
        header ("location: ../view/index.php");
        exit;
    }

    session_start();
    
    $userOwnsThisPost = $post->userOwnsThisPost($_SESSION["id"]);
    
    $title = $post->getTitle();
    $excerpt = $post->getExcerpt();
    $type = $post->getType();
    $servings = $post->getServings();
    $duration = $post->getDuration();
    $ingredients = $post->getIngredients();
    $preparation = $post->getPreparation();
    $post_user_id = $post->getUserId();
    $publish_date = $post->getPublishDate();
    $postImageName = $post->getImageName();
    $galleryImages = $post->getGalleryImages();
    
    $user = new User($dbConnect);



    if ($user->getOne($post_user_id) === FALSE) {
        header("location: ../view/index.php");
        exit;
    }

    $postOwnerUsername = $user->getUsername();
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Viewing Post</title>
        <link rel="stylesheet" href="../style/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"> 

    <style>
        img {width: 300px; height: 200px;}
        body {margin-left: 20px;}
    </style>
    </head>
    <body>
    <?php include ("../view/navbar.php"); ?>

        <div class="recipe-card" style="text-align: center; margin-left: 20px; margin-right: 20px; margin-bottom: 30px; ">
        <h1 style="font-size: 4em;"><?= $title ?></h1>
        <h5><?= $type ?></h5>
        <img style="width:600px; height:390px;" class="img-thumbnail" src="../images/<?= $postImageName ?>" alt="" />
        <h2 style="margin-bottom: 20px;"><?= $excerpt ?></h2>
        
        <article>            
            
            <ul class="list-unstyled">
            <li><h3 style="margin-bottom: 20px;"><span>Paredzēts: <i class="fa-solid fa-person"></i><span style="font-weight: bold;"> <?= $servings ?></span> personām</span></h3></li>
            <li><h3 style="margin-bottom: 20px;"><span>Pagatavošanas laiks: <i class="fa-regular fa-clock"></i> <?= $duration ?> minūtes</span></h3></li>
            </ul>
            <h3 style="margin-bottom: 20px;" class="ingredients"><span>Sastāvdaļas:&nbsp;</span><?= $ingredients ?></h3>

            <h3 style="margin-bottom: 20px;" class="list-unstyle"><?= $preparation ?></h3>
            
        <div class="row">
            <?php foreach ($galleryImages as $key => $imageName) { ?>
                <div class="col-md-6">
                    <img style="width:400px; height:290px;" class="img-thumbnail" src="../images/<?= $imageName ?>" alt="">
                </div>
            <?php } ?>
        </div>

        </article>
        </div>

        <h4 style="margin-bottom: 20px; margin-right: 20px; text-align: end;">Recepti izveidoja:<?php if (isset($postOwnerUsername)) { ?>
            <a href="profile.php?user-id=<?= $post_user_id ?>"><?= $postOwnerUsername ?></a>
        <?php } ?>
        </h4>
            <div style="margin-left: 20px;">

        <?php if ($userOwnsThisPost) { ?>
            <a href="../view/editPost.php?post-id=<?= $postId ?>"><button type="button" class="btn btn-info">Labot recepti</button></a>
        <?php } ?>

        <?php if ($userOwnsThisPost) { ?>
            <a href="../controller/DeletePost.php?post-id=<?= $postId ?>"><button type="button" class="btn btn-info">Izdzēst recepti</button></a>
        <?php } ?>
        <?php if ($userOwnsThisPost) { ?>
            <a href="../controller/toHide.php?post-id=<?= $postId ?>"><button type="button" class="btn btn-info">Paslēpt recepti</button></a>
        <?php } ?>
        <?php if ($userOwnsThisPost) { ?>
            <a href="../controller/toUnhide.php?post-id=<?= $postId ?>"><button type="button" class="btn btn-info">Neslēpt recepti</button></a>
        <?php } ?>
        </div>
        
        </div>

        <?php include ("../view/footer.php"); ?>
    </body>
    </html>