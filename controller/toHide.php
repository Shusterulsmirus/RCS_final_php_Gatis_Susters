<?php
    require_once "../db.php";
    
    session_start();

    $sql = "SELECT user_id FROM posts WHERE id = ?";

    $stmt = $dbConnect->stmt_init();

    if ($stmt->prepare($sql)) {

        $stmt->bind_param("i", $param_postId);
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $url_components = parse_url($actual_link);
        parse_str($url_components['query'], $urlParams);
        $postId = $urlParams["post-id"];
        $param_postId = (int)$postId;

        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($postonwer_user_id);
                if ($stmt->fetch()) {
                    $loggedInUserId = $_SESSION["id"];
                    if ((int)$loggedInUserId !== (int)$postonwer_user_id) {
                        header("location: ../view/index.php");
                        $stmt->close();
                        exit;
                    }
                }
            }
        }
    }
    $stmt->close();

    $sql = "UPDATE posts SET to_hide = 1 WHERE id = ?";

    $stmt = $dbConnect->stmt_init();

    if ($stmt->prepare($sql)) {

        $stmt->bind_param("i", $param_postId);
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $url_components = parse_url($actual_link);
        parse_str($url_components['query'], $urlParams);
        $postId = $urlParams["post-id"];
        $param_postId = (int)$postId;

        if ($stmt->execute()) {
            header("location: ../view/index.php");
                        $stmt->close();
                        exit;
        }
        $stmt->close();
    }
    ?>