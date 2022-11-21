<?php
    session_start();
    if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != TRUE) {
        header("location: ../view/index.php");
        exit;
    }

    require_once "../db.php";

        // get user to unfollow id from url param 'user-id'
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $url_components = parse_url($actual_link);
        parse_str($url_components['query'], $urlParams);
        
        $profileUserId = $urlParams["user-id"];
        $redirectTo = $urlParams["redirect"];
    
        // get following list from database and convert to array
        $blockedNew = str_replace(array('[',']'),'',$oldBlocked);
        $blockedNew = str_replace("'",'',$blockedNew);
        $blockedNew = explode(",",$blockedNew);
    
        // update who logged in users blocks
        $sql = "UPDATE users SET blocked = ? WHERE id = ?";
        $stmt = $dbConnect->stmt_init();
        if ($stmt->prepare($sql)) {
    
            $stmt->bind_param("si", $param_newBlocked,$param_loggedInUserId);
            $blockedNew = array_filter($blockedNew);
            $insertBlockedString = "[";
    
            foreach ($blockedNew as $value) {
                if ((string)$value !== (string)$profileUserId) {
                    $insertBlockedString = $insertBlockedString. "'".$value."',";
                }
            }
            
            $insertBlockedString = rtrim($insertBlockedString, ",");
    
            $insertBlockedString = $insertBlockedString ."]";
    
            $param_newBlocked = $insertBlockedString;
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
    


    // get user to unblock id from url param 'user-id'
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $url_components = parse_url($actual_link);
    parse_str($url_components['query'], $urlParams);
    
    $profileUserId = $urlParams["user-id"];
    $redirectTo = $urlParams["redirect"];

    // get blocked list from database and convert to array
    $blockedNew = str_replace(array('[',']'),'',$oldBlocked);
    $blockedNew = str_replace("'",'',$blockedNew);
    $blockedNew = explode(",",$blockedNew);



?>