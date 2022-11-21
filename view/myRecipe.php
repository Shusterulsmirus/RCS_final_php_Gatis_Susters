<?php
   
   session_start();


    require_once "../db.php";


    $title = $excerpt = $type = $servings = $duration = $ingredients = $preparation = "";
    $title_err = $excerpt_err = $type_err = $servings_err = $duration_err = $ingredients_err = $preparation_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty(trim($_POST["title"]))) {
            $title_err = "This has to contain some text";
        } else if (strlen(trim($_POST["title"])) > 200) {
            $title_err = "This is too long!";
        } else {
            $title = trim($_POST["title"]);
        }

        if (empty(trim($_POST["excerpt"]))) {
            $excerpt_err = "This has to contain some text";
        } else if (strlen(trim($_POST["excerpt"])) > 500) {
            $excerpt_err = "This is too long!";
        } else {
            $excerpt = trim($_POST["excerpt"]);
        }

        if (empty(trim($_POST["type"]))) {
            $type_err = "This has to contain some text";
        } else if (strlen(trim($_POST["servings"])) > 200) {
            $type_err = "This is too long!";
        } else {
            $type = trim($_POST["type"]);
        }

        if (empty(trim($_POST["servings"]))) {
            $servings_err = "This has to contain some numbers";
        } else if (strlen(trim($_POST["servings"])) > 200) {
            $servings_err = "This is too long!";
        } else {
            $servings = trim($_POST["servings"]);
        }

        if (empty(trim($_POST["duration"]))) {
            $duration_err = "This has to contain some time";
        } else if (strlen(trim($_POST["duration"])) > 200) {
            $duration_err = "This is too long!";
        } else {
            $duration = trim($_POST["duration"]);
        }

        if (empty(trim($_POST["ingredients"]))) {
            $ingredients_err = "This has to contain some text";
        } else if (strlen(trim($_POST["ingredients"])) > 750) {
            $ingredients_err = "This is too long!";
        } else {
            $ingredients = trim($_POST["ingredients"]);
        }

        if (empty(trim($_POST["preparation"]))) {
            $preparation_err = "This has to contain some text";
        } else if (strlen(trim($_POST["preparation"])) > 1250) {
            $preparation_err = "This is too long!";
        } else {
            $preparation = trim($_POST["preparation"]);
        }

        
    

         // Titulbilde
        $tempname = $_FILES["uploadfile"]["tmp_name"];

        $filepath = tempnam('../images', "");
        rename($filepath, $filepath .= '.png');
        $originalFilename = $_FILES["uploadfile"]["name"];
        unlink($filepath);

        $pathExploded = explode("\\",$filepath);
        $filename = $pathExploded[count($pathExploded)-1];

        if (!move_uploaded_file($tempname, $filepath)) {
            header("location: profile.php?user-id=".$_SESSION["id"]);
        }

        // Galerija
        $galleryImages = $_FILES["gallery"];

        $galleryArray = reArrayFiles($galleryImages);
        
        $insertGalleryString = "[";

        foreach ($galleryArray as $key => $image) {

        $gallery_tempname = $image["tmp_name"];
        $gallery_filepath = tempnam('../images', "");

        rename($gallery_filepath, $gallery_filepath .= '.png');
        unlink($gallery_filepath);
        $gallery_pathExploded = explode("\\",$gallery_filepath);
        $gallery_filename = $gallery_pathExploded[count($gallery_pathExploded)-1];

        $insertGalleryString = $insertGalleryString. "'".$gallery_filename."'";

        if ($key < count($galleryArray) -1) {
            $insertGalleryString = $insertGalleryString . ",";
        }
        if (!move_uploaded_file($gallery_tempname, $gallery_filepath)) {
            header("location: profile.php?user-id=".$_SESSION["id"]);
        }
    }

        $insertGalleryString = $insertGalleryString . "]"; 
       


    if (empty($title_err) && empty($excerpt_err) && empty($type_err) && empty($servings_err) && empty($duration_err) && empty($ingredients_err) && empty($preparation_err)) {

        $sql = "INSERT INTO posts (title,excerpt,type,servings,duration,ingredients,preparation,user_id,publish_date,image,gallery) VALUES (?,?,?,?,?,?,?,?,NOW(),?,?)";


        $stmt = $dbConnect->stmt_init();

        if ($stmt->prepare($sql)) {
            $stmt->bind_param("sssssssiss", $param_title, $param_excerpt, $param_type, $param_servings, $param_duration, $param_ingredients, $param_preparation, $param_userId, $param_imageName, $param_gallery);
            
            $param_title = $title;
            $param_excerpt = $excerpt;
            $param_type = $type;
            $param_servings = $servings;
            $param_duration = $duration;
            $param_ingredients = $ingredients;
            $param_preparation = $preparation;
            $param_imageName = $filename;
            $param_gallery = $insertGalleryString;
             // $param_userId = $userId;
            $param_userId = $_SESSION["id"];
           
            if ($stmt->execute()) {
                header("location: profile.php?user-id=".$param_userId);
            } else {
                echo "Something went wrong";
            }
        }
        $stmt->close();
    }
    
}

function reArrayFiles(&$file_post) {

        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }

        return $file_ary;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create new Post</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"> 


    <style>
        body {font: 14px sans-serif;}
        .wrapper {width: 500px; padding: 10px; margin: auto; text-align: center;}
    </style>

</head>
<body>
    
<?php include('../view/navbar.php'); ?>


<div class="wrapper">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label>Nosaukums</label>
            <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>">
            <span class="invalid-feedback"><?php echo $title_err; ?></span>
        </div>

        <div class="form-group">
            <label>Apraksts</label>
            <textarea style="min-height: 200px;" name="excerpt" class="form-control <?php echo (!empty($excerpt_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $excerpt; ?>"></textarea>
            <span class="invalid-feedback"><?php echo $excerpt_err; ?></span>
        </div>


        <div class="form-group">
            <label>Tips</label>
            <input type="text" name="type" class="form-control  <?php echo (!empty($type_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $type; ?>">
            <span class="invalid-feedback"><?php echo $type_err; ?></span>
        </div>

        <div class="form-group">
            <label>Porcijas</label>
            <input type="text" name="servings" class="form-control <?php echo (!empty($servings_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $servings; ?>">
            <span class="invalid-feedback"><?php echo $title_err; ?></span>
        </div>

        <div class="form-group">
            <label>Aptuvenais laiks (minūtēs)</label>
            <input type="text" name="duration" class="form-control <?php echo (!empty($duration_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $duration; ?>">
            <span class="invalid-feedback"><?php echo $title_err; ?></span>
        </div>

        
        <div class="form-group">
            <label>Sastāvdaļas</label>
            <textarea style="min-height: 200px;" type="text" name="ingredients" class="form-control <?php echo (!empty($ingredients_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $ingredients; ?>"></textarea>
            <span class="invalid-feedback"><?php echo $excerpt_err; ?></span>
        </div>
        
        <div class="form-group">
            <label>Pagatavošana</label>
            <textarea style="min-height: 200px;" type="text" name="preparation" class="form-control <?php echo (!empty($preparation_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $preparation; ?>"></textarea>
            <span class="invalid-feedback"><?php echo $text_err; ?></span>
        </div>

        <div class="form-group">
            <label>Ievietot bildi</label>
            <input class="form-control" type="file" name="uploadfile" value="" />
            <span class="invalid-feedback"><?php echo $img_err; ?></span>
        </div>

        <div class="form-group">
            <label>Ievietot vairākas bildes</label>
            <input class="form-control" type="file" name="gallery[]" multiple value="" enctype="multipart/form-data" />
            <span class="invalid-feedback"><?php echo $gallery_err; ?></span>
        </div>

        <div class="form-group" style="text-align: center;">
            <input type="submit" class="btn btn-primary" value="Apstiprināt">
        </div>
        </form>
    </div>

    <?php include('../view/footer.php'); ?>
</body>
</html>