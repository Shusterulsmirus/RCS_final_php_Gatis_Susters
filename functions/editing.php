<?php

function editTitle($param_Title) {
    if (empty(trim($_POST["title"]))) {
        $title_err = "This has to contain some text";
    } else if (strlen(trim($_POST["title"])) > 200) {
        $title_err = "This is too long!";
    } else {
        $title_err = FALSE;        
    }
    return $title_err;
}

function editServings($param_Servings) {
    if (empty(trim($_POST["servings"]))) {
        $servings_err = "This has to contain some numbers";
    } else if (strlen(trim($_POST["servings"])) > 200) {
        $servings_err = "This is too long!";
    } else {
       $servings_err = FALSE;
    }
    return $servings_err;
}

function editDuration ($param_Duration) {
    if (empty(trim($_POST["duration"]))) {
        $duration_err = "This has to contain some time";
    } else if (strlen(trim($_POST["duration"])) > 200) {
        $duration_err = "This is too long!";
    } else {
        $duration_err = FALSE;
    }
    return $duration_err;
}

function editIngredients ($param_Ingredients) {
    if (empty(trim($_POST["ingredients"]))) {
        $ingredients_err = "This has to contain some text";
    } else if (strlen(trim($_POST["ingredients"])) > 250) {
        $ingredients_err = "This is too long!";
    } else {
        $ingredients_err = FALSE;
    }
    return $ingredients_err;
}

function editPreparation ($param_Preparation) {
    if (empty(trim($_POST["preparation"]))) {
        $preparation_err = "This has to contain some text";
    } else if (strlen(trim($_POST["preparation"])) > 250) {
        $preparation_err = "This is too long!";
    } else {
        $preparation_err = FALSE;
    }
    return $preparation_err;
}
