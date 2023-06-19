<?php
require_once "functions.php";


/**
 *  connects with database
 *  ready for mySQL queries
 *    
 *  returns nothing
 **/
function mysqlConnect(){
    global $mysql_Connection, $mysql_response;
    $mysql_Connection = new mysqli("localhost", "root", "", "library_system");
    if($mysql_Connection->connect_error){
        $mysql_response[] = "Connect Error ({$mysql_Connection->connect_errno}) {$mysql_Connection->connect_error}";
        echo json_encode($mysql_response); // Removed the extra empty string and third parameter
        die();
    }
}
/**
 *  echos out the mySQL query response from global data and status array
 * 
 *  @param array mySQL query to send to the data base 
 *  returns results of query or false if unsuccessful
 **/
function mysqlQuery($query){
    global $mysql_Connection, $mysql_response, $mysql_status;
    $results = false;
    //check to see if we have an active connection
    if($mysql_Connection == null){
        $mysql_status = "No database connection active";
        return $results;
    }
    if(!($results = $mysql_Connection->query( $query))){ //assigning things to results while checking if null
        $mysql_response[] = "Query Error {$mysql_Connection->errno} : {$mysql_Connection->error}";
    }
    return $results;
}

function mysqlNonQuery($query){
    global $mysql_Connection, $mysql_response;

    $results = 0;
    
    //check to see if we have an active connection
    if($mysql_Connection == null){
        $mysql_status = "No database connection active";
        return $results;
    }

    if(!($results = $mysql_Connection->query($query))){
        $mysql_response[] = "Query Error {$mysql_Connection->errno} : {$mysql_Connection->error}";
        return -1;
    }
    return $mysql_Connection->affected_rows;
}


