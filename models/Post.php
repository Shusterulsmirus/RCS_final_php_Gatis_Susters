<?php

require_once "../functions/convertToArray.php";

class Post {

    private $id;
    private $title;
    private $excerpt;
    private $type;
    private $servings;
    private $duration;
    private $ingredients;
    private $preparation;
    private $user_id;
    private $publish_date;
    private $image;
    private $gallery;
    private $is_deleted;
    private $to_hide;

    private $dbConnect;

    public function __construct($dbConnect)
    {
        $this->dbConnect = $dbConnect;
    }

    

    public function getOne($postId)
    {
        $this->id = (int)$postId;

        $sql = "SELECT title,excerpt,type,servings,duration,ingredients,preparation,user_id,publish_date,image,gallery,is_deleted,to_hide FROM posts WHERE id = ?";
        $stmt = $this->dbConnect->stmt_init();

        if ($stmt->prepare($sql)) {

            $stmt->bind_param("i", $param_postId);
            $param_postId = $this->id;

            if ($stmt->execute()) {
                $stmt->store_result();
                    if ($stmt->num_rows == 1) {
                        $stmt->bind_result($db_title, $db_excerpt, $db_type, $db_servings, $db_duration, $db_ingredients, $db_preparation, $db_user_id, $db_publish_date, $db_image, $db_gallery, $db_is_deleted, $db_to_hide);
                        $stmt->fetch();

                        $this->title = $db_title;
                        $this->excerpt = $db_excerpt;
                        $this->type = $db_type;
                        $this->servings = $db_servings;
                        $this->duration = $db_duration;
                        $this->ingredients = $db_ingredients;
                        $this->preparation = $db_preparation;
                        $this->user_id = $db_user_id;
                        $this->publish_date = $db_publish_date;
                        $this->image = $db_image;
                        $this->gallery = convertToArray($db_gallery);
                        $this->is_deleted = $db_is_deleted;
                        $this->to_hide = $db_to_hide;

                    } else {
                        return FALSE;
                    }
                }
            }
            $stmt->close();
    }

    public function editPost($titleEdited, $excerptEdited, $typeEdited, $servingsEdited, $durationEdited, $ingredientsEdited, $preparationEdited) {

        $sql = "UPDATE posts SET title = ?, type = ?, servings = ?, duration = ?,ingredients = ?, preparation = ? WHERE id = ?";
        $stmt = $this->dbConnect->stmt_init();

                if ($stmt->prepare($sql)) {
                    $stmt->bind_param("sssssi", $param_editedTitle, $param_editedType, $param_editedServings, $param_editedDuration, $param_editedIngredients, $param_editedPreparation, $param_postEditId);
                    
                    $param_editedTitle = $titleEdited;
                    $param_editedType = $typeEdited;
                    $param_editedServings = $servingsEdited;
                    $param_editedDuration = $durationEdited;
                    $param_editedIngredients = $ingredientsEdited;
                    $param_editedPreparation = $preparationEdited;
                    $param_postId = $this->id;

                    if($stmt->execute()){
                        $stmt->close();
                    } else {
                        echo "Something went wrong! Please try again!";
                    }
                   
        }
        // $stmt->close();

    }
    


    public function getAllFromUser($userId) {
        $sql = "SELECT * FROM posts WHERE user_id = ? AND NOT is_deleted";
        $stmt = $this->dbConnect->stmt_init();
        if ($stmt->prepare($sql)) {
            $stmt->bind_param("i", $param_userId);
            $param_userId = $userId;
            if ($stmt->execute()) {
                return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            } else {
                echo "error";
            }
        } else {
            echo "error";
          }
    }

    public function getId($user_id) {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getExcerpt() {
        return $this->excerpt;
    }

    public function getType() {
        return $this->type;
    }

    public function getServings() {
        return $this->servings;
    }

    public function getDuration() {
        return $this->duration;
    }

    public function getIngredients() {
        return $this->ingredients;
    }

    public function getPreparation() {
        return $this->preparation;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getPublishDate() {
        return $this->publish_date;
    }

    public function getIsDeleted() {
        return $this->is_deleted;
    }

    public function getToHide() {
        return $this->to_hide;
    }

    public function userOwnsThisPost($user_id) {
        return (int)$user_id === $this->user_id;
    }

    public function getImageName() {
        return $this->image;
    }

    public function getGalleryImages() {
        return $this->gallery;
    }
    
}
?>
