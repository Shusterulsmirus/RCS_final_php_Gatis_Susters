<?php

require_once "../functions/convertToArray.php";

class User {

    private $id;
    private $email;
    private $username;
    private $followers;
    private $following;
    private $blocked;
    
    private $dbConnect;

    public function __construct($dbConnect)
    {
        $this->dbConnect = $dbConnect;
    }

    

    public function getOne($userId)
    {
        $sql = "SELECT username,email,password,following,followers,blocked FROM users WHERE id = ?";
        $stmt = $this->dbConnect->stmt_init();

        $this->id = (int)$userId;

        if ($stmt->prepare($sql)) {
            $stmt->bind_param("i", $param_userId);
            $param_userId = $this->id;
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($db_username,$db_email,$db_password,$db_following,$db_followers,$db_blocked);
                    $stmt->fetch();

                    $this->username = $db_username;
                    $this->email = $db_email;
                    $this->password = $db_password;
                    $this->following = convertToArray($db_following);
                    $this->followers = convertToArray($db_followers);
                    $this->blocked = convertToArray($db_blocked);
                }
            }
        }
        $stmt->close();

    }

    public function isOwner($sessionUserId) {
        return ((int)$sessionUserId === $this->id);
    }

    public function isFollowingMe($userId) {
        if (in_array($userId, $this->followers)) {
            return TRUE;
        }
        return FALSE;
    }

    public function getId() {

        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getFollowing() {

        return $this->following;
    }

    public function getFollowers() {

        return $this->followers;
    }

    public function getBlocked() {

        return $this->blocked;
    }

    public function addUserToList($userToAddToList, $listToUpdate) {
        $sql = 'UPDATE users SET '.$listToUpdate.' = ? WHERE id = ' . $this->id;
        $stmt = $this->dbConnect->stmt_init();
        if ($stmt->prepare($sql)) {

            $stmt->bind_param("s", $param_newList);
            $listNew = $this->$listToUpdate;
            $insertString = "[";

            foreach ($listNew as $value) {
                $insertString = $insertString. "'".$value."',";
            }

            $insertString = $insertString . "'".$userToAddToList."']";
            $param_newList = $insertString;
            if ($stmt->execute()) {

            }
        }
        $stmt->close();
    }

    public function removeUserFromList($userToRemoveFromList, $listToUpdate) {
        $sql = 'UPDATE users SET '.$listToUpdate.' = ? WHERE id = ' . $this->id;
        $stmt = $this->dbConnect->stmt_init();
        
        if ($stmt->prepare($sql)) {

            $stmt->bind_param("i", $param_newList);
            $insertString = "[";

            foreach ($this->$listToUpdate as $value) {
                if ((string)$value !== (string)$userToRemoveFromList) {
                $insertString = $insertString. "'".$value."',";
            }
        }
        $insertString = rtrim($insertString, ",");
        $insertString = $insertString ."]";
        $param_newList = $insertString;

            if ($stmt->execute()) {
            }
        }
        $stmt->close();
    }
    
}
?>
    

