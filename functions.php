<?php
//starts a session that binds this communication between the user and the server
session_start(); 
require_once "db.php";
$userTable = array();
mysqlConnect();


/**
 *  Checks to see if username and password are valid
 *  updates response message
 *  changes status
 *  TODO make a user table
 *  @param array takes the credentials that a user enters and
 *               determines if they are valid
 *  
 *  returns modified array
 **/
function Validate($v){
    
    $username = $v['user'];
    
    $query = "SELECT name, password, privilege, id ";
    $query .= "FROM users ";
    $query .= "WHERE name like '%$username%'";

    
    //grabs one username that matches exactly
    //ideally there will be no two usernames that
    if($results = mysqlQuery($query)){
        while ($row = $results->fetch_assoc() ){
            $hashed_password = $row['password'];
            $privilege = $row['privilege'];
            $id = $row['id'];
        }
    }
    //TODO add a check to see if results are empty
    else{
        $v['response'] = "Database Query Failed";
        $v['status'] = false;
        return $v;
    }
    
    $user_entered_password = $v['pass'];
    //checks to see if the entered password and username matches the one in the table
    if (password_verify($user_entered_password, $hashed_password)){
        $v['response'] = "Successfully logged in as {$username}";
        $v['status'] = true;
        $_SESSION['username'] = $username; //if validated setting user name
        $_SESSION['privilege'] = $privilege;
        $_SESSION['id'] = $id;
    }
    else{
        $v['response'] = "Logging Failed, credentials incorrect, try again";
        $v['status'] = false;
    }
    return $v;
}



