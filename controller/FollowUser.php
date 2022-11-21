<?php
    session_start();
    if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != TRUE) {
        header("location: ../view/index.php");
        exit;
    }

    require_once "../db.php";
    require_once "../functions/getParamsFromUrl.php";
    require_once "../models/User.php";

    // get url params: user-id and redirect
    $profileUserId = getParamsFromUrl("user-id");
    $redirectTo = getParamsFromUrl("redirect");

    // instantiate user to follow
    $userToFollow = new User($dbConnect);
    $userToFollow->getOne($profileUserId);

    // instantiate logged in user
    $loggedInUser = new User($dbConnect);
    $loggedInUser->getOne((int)$_SESSION["id"]);

    // if logged in user already follows user or tries to follow self, then exit
    if (in_array($userToFollow->getId(),$loggedInUser->getFollowing()) || (string)$userToFollow->getId() === (string)$loggedInUser->getId()) {
        if ($redirectTo == 'profile') {
            header ("location: ../view/".$redirectTo.".php?user-id=".(string)$userToFollow->getId());
        } else {
            header("location: ../view/".$redirectTo.".php");
        }
        exit;
    }

    // update followers of user that gets a new follow
    $userToFollow->addUserToList($loggedInUser->getId(), 'followers');

    // update following of user that is logged in
    $loggedInUser->addUserToList($userToFollow->getId(), 'following');

    header("location: ../view/".$redirectTo.".php?user-id=".(string)$profileUserId);

   // header("location ../view/".$redirectTo.".php?user-id=".(string)$userToFollow->getId());



?>