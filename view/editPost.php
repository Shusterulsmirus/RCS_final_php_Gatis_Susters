<?php
   
   session_start();

   if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== TRUE) {
    header("location: ../view/index.php");
    exit;
   }

    require_once "../db.php";
    require_once "../models/Post.php";
    require_once "../models/User.php";
    require_once "../functions/getParamsFromUrl.php";
    require_once "../functions/editing.php";
     
    $title = $excerpt = $servings = $duration = $ingredients = $preparation = "";
    $title_err = $excerpt_err = $servings_err = $duration_err = $ingredients_err = $preparation_err = "";

    // $post = new Post ($dbConnect);

    // if (!isset($_SESSION["post-id"]) && $_SESSION["post-id"] !== TRUE) {
    //     $postId = getParamsFromUrl("post-id");
    //     $_SESSION["post-id"] = $postId;
    // }
    
    // $post->getOne($_SESSION["post-id"]);
    
    // $title = $post->getTitle();
    // $servings = $post->getServings();
    // $duration = $post->getDuration();
    // $ingredients = $post->getIngredients();
    // $preparation = $post->getPreparation(); 

    // $user = new User ($dbConnect);
  
    // // if ($user->getOne($post_user_id) === FALSE) {
    // //     header("location: ../view/index.php");
    // //     exit;
    // // }
    
    // $userOwnsThisPost = $post->userOwnsThisPost($_SESSION["id"]);

    // if (!$userOwnsThisPost) {
    //     header("location: ../view/index.php");
    //     exit;
    // }
    
    // $post->getOne($_SESSION["post-id"]);

    // $postOwnerUsername = $user->getUsername();

    // if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //     $param_Title = trim($_POST["title"]);
    //     $param_Servings = trim($_POST["servings"]);
    //     $param_Duration = trim($_POST["duration"]);
    //     $param_Ingredients = trim($_POST["ingredients"]);
    //     $param_Preparation = trim($_POST["preparation"]);

    //     $title_err = editTitle($param_Title);
    //     $servings_err = editServings($param_Servings);
    //     $duration_err = editDuration($param_Duration);
    //     $ingredients_err = editIngredients($param_Ingredients);
    //     $preparation_err = editPreparation($param_Preparation);

    // if ($userOwnsThisPost) {
    //     if (empty($title_err) && empty($servings_err) && empty($duration_err) && empty($ingredients_err) && empty($preparation_err)) {
    //         $post->editPost($param_Title, $param_Servings, $param_Duration, $param_Ingredients, $param_Preparation);
    //     }
    // } else {
    //     $post->getOne($postId);
    // }
    // } else {
    //     $postId = getParamsFromURL("post-id");
    //     $_SESSION["post-id"] = $postId;
    // }   





    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty(trim($_POST["title"]))) {
            $title_err = "This has to contain some text";
        } else if (strlen(trim($_POST["title"])) > 200) {
            $title_err = "This is too long!";
        } else {
            $titleEdited = trim($_POST["title"]);
        }

        if (empty(trim($_POST["excerpt"]))) {
            $excerpt_err = "This has to contain some text";
        } else if (strlen(trim($_POST["excerpt"])) > 500) {
            $excerpt_err = "This is too long!";
        } else {
            $excerptEdited = trim($_POST["excerpt"]);
        }

        if (empty(trim($_POST["type"]))) {
            $type_err = "This has to contain some text";
        } else if (strlen(trim($_POST["servings"])) > 200) {
            $type_err = "This is too long!";
        } else {
            $typeEdited = trim($_POST["type"]);
        }

        if (empty(trim($_POST["servings"]))) {
            $servings_err = "This has to contain some numbers";
        } else if (strlen(trim($_POST["servings"])) > 200) {
            $servings_err = "This is too long!";
        } else {
            $servingsEdited = trim($_POST["servings"]);
        }

        if (empty(trim($_POST["duration"]))) {
            $duration_err = "This has to contain some time";
        } else if (strlen(trim($_POST["duration"])) > 200) {
            $duration_err = "This is too long!";
        } else {
            $durationEdited = trim($_POST["duration"]);
        }

        if (empty(trim($_POST["ingredients"]))) {
            $ingredients_err = "This has to contain some text";
        } else if (strlen(trim($_POST["ingredients"])) > 750) {
            $ingredients_err = "This is too long!";
        } else {
            $ingredientsEdited = trim($_POST["ingredients"]);
        }

        if (empty(trim($_POST["preparation"]))) {
            $preparation_err = "This has to contain some text";
        } else if (strlen(trim($_POST["preparation"])) > 1250) {
            $preparation_err = "This is too long!";
        } else {
            $preparationEdited = trim($_POST["preparation"]);
        }

        
        if (empty($title_err) && empty($excerpt_err) && empty($type_err) && empty($servings_err) && empty($duration_err) && empty($ingredients_err) && empty($preparation_err)) {

        $sql = "UPDATE posts SET title = ?, excerpt = ?, type = ?, servings = ?, duration = ?, ingredients = ?, preparation = ? WHERE id = ?";


        $stmt = $dbConnect->stmt_init();

        if ($stmt->prepare($sql)) {
            $stmt->bind_param("sssssssi", $param_title, $param_excerpt, $param_type, $param_servings, $param_duration, $param_ingredients, $param_preparation, $param_postEditId);
            
            $param_title = $titleEdited;
            $param_excerpt = $excerptEdited;
            $param_type = $typeEdited;
            $param_servings = $servingsEdited;
            $param_duration = $durationEdited;
            $param_ingredients = $ingredientsEdited;
            $param_preparation = $preparationEdited;
            $param_postEditId = (int)$_SESSION["post-id"];
        
            if ($stmt->execute()) {
                $stmt->close();
                $userId = $_SESSION["id"];
                $_SESSION["post-id"] = NULL;
                header("location: profile.php?user-id=".$userId);
            } else {
                echo "Something went wrong";
            }
        }
        $stmt->close();
    }
        
} else {

    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $url_components = parse_url($actual_link);
    parse_str($url_components['query'], $urlParams);
    $postId = $urlParams["post-id"];

    $_SESSION["post-id"] = $postId;
    $sql = "SELECT title,excerpt,type,servings,duration,ingredients,preparation,user_id FROM posts WHERE id = ?";
    $stmt = $dbConnect->stmt_init();

    if ($stmt->prepare ($sql)) {

        $stmt->bind_param("i", $param_postId);
        $param_postId = (int)$postId;

        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($title,$excerpt,$type,$servings,$duration,$ingredients,$preparation,$post_user_id);
                if ($stmt->fetch()) {
                    $postExists = TRUE;
                    $title = trim($title);
                    $userId = $_SESSION["id"];
                    if ($userId !== $post_user_id) {
                        header("location: ../view/index.php");
                        $stmt->close();
                        exit;
                    }
                }
            }
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
    <title>Edit Post</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"> 


    <style>
        body {font: 14px sans-serif;}
        .wrapper {width: 360px; padding: 20px; margin: auto; text-align: center;}
    </style>

</head>
<body>
    


<div class="wrapper">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <div class="form-group">
            <label>Nosaukums</label>
            <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>">
            <span class="invalid-feedback"><?php echo $title_err; ?></span>
        </div>

        <div class="form-group">
            <label>Apraksts</label>
            <input type="text" name="excerpt" class="form-control <?php echo (!empty($excerpt_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $excerpt; ?>">
            <span class="invalid-feedback"><?php echo $excerpt_err; ?></span>
        </div>

        <div class="form-group">
            <label>Tips</label>
            <input type="text" name="title" class="form-control <?php echo (!empty($type_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $type; ?>">
            <span class="invalid-feedback"><?php echo $type_err; ?></span>
        </div>

        <div class="form-group">
            <label>Porcijas</label>
            <input type="text" name="servings" class="form-control <?php echo (!empty($servings_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $servings; ?>">
            <span class="invalid-feedback"><?php echo $servings_err; ?></span>
        </div>

        <div class="form-group">
            <label>Aptuvenais laiks minūtēs</label>
            <input type="text" name="duration" class="form-control <?php echo (!empty($duration_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $duration; ?>">
            <span class="invalid-feedback"><?php echo $duration_err; ?></span>
        </div>

        
        <div class="form-group">
            <label>Sastāvdaļas</label>
            <input type="text" name="ingredients" class="form-control <?php echo (!empty($ingredients_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $ingredients; ?>">
            <span class="invalid-feedback"><?php echo $ingredients_err; ?></span>
        </div>
        
        <div class="form-group">
            <label>Pagatavošana</label>
            <textarea style="min-height: 200px;" type="text" name="preparation" class="form-control <?php echo (!empty($preparation_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $preparation; ?>"></textarea>
            <span class="invalid-feedback"><?php echo $preparation_err; ?></span>
        </div>

        <div class="form-group">
            <label>Ievietot bildi</label>
            <input class="form-control"type="file" name="thumbnail" value="" />
            <span class="invalid-feedback"><?php echo $img_err; ?></span>
        </div>

        <div class="form-group">
            <label>Ievietot vairākas bildes</label>
            <input class="form-control"type="file" name="gallery[]" multiple value="" />
            <span class="invalid-feedback"><?php echo $gallery_err; ?></span>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
        </div>
        </form>
    </div>

    <?php include('../view/footer.php'); ?>
</body>
</html>



