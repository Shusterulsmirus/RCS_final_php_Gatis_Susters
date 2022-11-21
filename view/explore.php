<?php

    session_start();

    require_once "../db.php";
    require_once "../models/Post.php";
    require_once "../models/User.php";
    require_once "../functions/getParamsFromUrl.php";

    $post = new Post($dbConnect);

    $postImageName = $post->getImageName();

    $sql = "SELECT * FROM posts WHERE NOT is_deleted AND NOT to_hide";

    $stmt = $dbConnect->stmt_init();
    if ($stmt->prepare($sql)) {
        if ($stmt->execute()) {
            $allPosts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } else { 
            echo "Error!";
        }
    }
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

    <h1 style="text-align:center; margin-left: 10px;">RECEPTES</h1>

        <?php foreach ($allPosts as $post) {?>
            
            <a style="display:flex; margin-bottom:20px;" href="post.php?post-id=<?= $post["id"] ?>">
            <div class=""><img style="width:300px; height:200px; margin-left: 10px;" class="img-thumbnail" src="../images/<?php echo $post["image"] ?>"></div>
             <div class="my-auto" >  <h2><?php echo $post["title"] ?></h2> </div> 
            </a>
        <?php } ?>
        

<?php include('../view/footer.php'); ?>        
</body>
</html>