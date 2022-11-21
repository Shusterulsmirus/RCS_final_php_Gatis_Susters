<?php
    session_start();
    if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != TRUE) {
        header("location: ../view/index.php");
        exit;
    }
    require_once "../db.php";

    // get following of the user that is logged in
    $sql = "SELECT following from users WHERE id = ?";
    $stmt = $dbConnect->stmt_init();
    if ($stmt->prepare($sql)) {
        $stmt->bind_param("i", $param_loggedInUserId);
        $param_loggedInUserId = (int)$_SESSION["id"];

        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($oldFollowing);
                $stmt->fetch();
            }
        }
    }
    $stmt->close();

    // get user to unfollow id from url param 'user-id'
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $url_components = parse_url($actual_link);
    parse_str($url_components['query'], $urlParams);
    
    $profileUserId = $urlParams["user-id"];
    $redirectTo = $urlParams["redirect"];

    // get following list from database and convert to array
    $followingNew = str_replace(array('[',']'),'',$oldFollowing);
    $followingNew = str_replace("'",'',$followingNew);
    $followingNew = explode(",",$followingNew);

    // if logged in user doesn't follow this user or tries to unfollow self, then exit
    if (!in_array($profileUserId,$followingNew) || (string)$profileUserId === (string)$param_loggedInUserId) {
        if ($redirectTo == "profile") {
            header("location: ../view/".$redirectTo.".php?user-id=".(string)$profileUserId);
        } else {
            header("location: ../view/".$redirectTo.".php");
        }
        exit;
    }

    // get followers of the user that we are following
    $sql = "SELECT followers FROM users WHERE id = ?";
    $stmt = $dbConnect->stmt_init();
    if ($stmt->prepare($sql)) {
        $stmt->bind_param("i", $param_profileToFollow);
        $param_profileToFollow = $profileUserId;

        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($oldFollowers);
                $stmt->fetch();
            }
        }
    }
    $stmt->close();

    // convert followers to array
    $followersNew = str_replace(array('[',']'),'',$oldFollowers);
    $followersNew = str_replace("'",'',$followersNew);
    $followersNew = explode(",",$followersNew);

    // update followers of user that gets a new follow
    $sql = "UPDATE users SET followers = ? WHERE id =?";
    $stmt = $dbConnect->stmt_init();
    if ($stmt->prepare($sql)) {

        $stmt->bind_param("si", $param_newFollowers,$param_profileToFollowId);
        $followersNew = array_filter($followersNew);
        $insertFollowersString = "[";

        foreach ($followersNew as $value) {

            if ((string)$value !== (string)$param_loggedInUserId) {
                $insertFollowersString = $insertFollowersString. "'".$value."',";
            }
        }

        $insertFollowersString = rtrim($insertFollowersString, ",");

        $insertFollowersString = $insertFollowersString ."]";
        $param_newFollowers = $insertFollowersString;
        $param_profileToFollowId = $profileUserId;
        if ($stmt->execute()) {

        }

    }
    $stmt->close();

    // update who logged in users follows
    $sql = "UPDATE users SET following = ? WHERE id = ?";
    $stmt = $dbConnect->stmt_init();
    if ($stmt->prepare($sql)) {

        $stmt->bind_param("si", $param_newFollowing,$param_loggedInUserId);
        $followingNew = array_filter($followingNew);
        $insertFollowersString = "[";

        foreach ($followingNew as $value) {
            if ((string)$value !== (string)$profileUserId) {
                $insertFollowersString = $insertFollowersString. "'".$value."',";
            }
        }

        $insertFollowersString = rtrim($insertFollowersString, ",");

        $insertFollowersString = $insertFollowersString ."]";

        $param_newFollowing = $insertFollowersString;
        $param_loggedInUserId = (int)$_SESSION["id"];
        if ($stmt->execute()) {
            if ($redirectTo === 'profile') {
                header("location: ../view/".$redirectTo.".php?user-id=".(string)$profileUserId);
            } else {
                header("location: ../view/".$redirectTo.".php");
            }
            exit();
        }
    }
    $stmt->close();

?>