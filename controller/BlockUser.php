<?php
    session_start();
    if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != TRUE) {
        header("location: ../view/index.php");
        exit;
    }

    require_once "../db.php";
    require_once "../functions/convertToArray.php";
    require_once "../functions/getParamsFromUrl.php";
    require_once "../models/User.php";

    // get followers of the user that is logged in
    $loggedInUser = new User($dbConnect);
    $blockedUser = new User($dbConnect);

    $loggedInUser->getOne((int)$_SESSION["id"]);

    // get user to unfollow id from url param 'user-id'
    $blockedUserId = getParamsFromUrl("user-id");
    $redirectTo = getParamsFromUrl("redirect");

    // if logged in user doesn't follow this user or tries to unfollow self, then exit
    if (!in_array($blockedUserId,$loggedInUser->getFollowers()) || (string)$blockedUser->getId() === (string)$loggedInUser->getId()) {
        if ($redirectTo == 'profile') {
            header ("location: ../view/".$redirectTo.".php?user-id=".(string)$blockedUserId);
        } else {
            header("location: ../view/".$redirectTo.".php");
        }
        exit;
    }

    $blockedUser->getOne($blockedUserId);

   // UPDATE logged in user

   $loggedInUser->removeUserFromList($blockedUser->getId(),'followers');
   $loggedInUser->addUserToList($blockedUser->getId(), 'blocked');
   $loggedInUser->removeUserFromList($blockedUser->getId(),'following');

   // UPDATE blocked user

   $blockedUser->removeUserFromList($loggedInUser->getId(),'following');
   $blockedUser->removeUserFromList($loggedInUser->getId(),'followers');

   if ($redirectTo == 'profile') {
        header ("location: ../view/".$redirectTo.".php?user-id=".(string)$blockedUserId);
    } else {
        header("location: ../view/".$redirectTo.".php");
    }
    exit;

?>

