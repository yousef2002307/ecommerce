<?php
function getalltable($table,$where = ''){
    global $db;
    $stmt = $db->prepare("SELECT * FROM $table $where");
    $stmt->execute();
    $row = $stmt->fetchAll();
    return $row;
};

///////////////////////////////////////
function cat($where = ''){
    global $db;
    $stmt = $db->prepare("SELECT * FROM `catagories` $where ORDER BY ID DESC");
    $stmt->execute();
    $row = $stmt->fetchAll();
    return $row;
};

function item($value,$afterwhere = NULL){
    if($afterwhere == NULL){
    $sql = 'AND approve = 1';

    }else{
        $sql = NULL;
    }
    global $db;
    $stmt = $db->prepare("SELECT * FROM `item` WHERE cat_id = ? $sql ORDER BY itemid DESC");
    $stmt->execute(array($value));
    $row = $stmt->fetchAll();
    return $row;
};
function tags($value){
    global $db;
    $stmt = $db->prepare("SELECT * FROM `item` WHERE tags LIKE '%$value%'");
    $stmt->execute(array($value));
    $row = $stmt->fetchAll();
    return $row;
};
function member($value){
    global $db;
    $stmt = $db->prepare("SELECT * FROM `item` WHERE USERID  = ? ORDER BY itemid DESC");
    $stmt->execute(array($value));
    $row = $stmt->fetchAll();
    return $row;
};


function jo_comments($value){
    global $db;
    $stmt = $db->prepare("SELECT * FROM `comments` WHERE user_id = ? ORDER BY adddate DESC");
    $stmt->execute(array($value));
    $row = $stmt->fetchAll();
    return $row;
};









///////////////////////////////////////////////////////////////////////////////////////////
function getTitle(){
    global $pagetitle;
    if(isset($pagetitle)){
        echo $pagetitle;
    }else{
        echo 'default';
    }
};


/*
redirect function

*/
function errmsg($themassage, $url = null, $seconds = 3){
    if($url === null){
        $url = 'index.php';
    }else{
        if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){
        $url = $_SERVER['HTTP_REFERER'];
        }else{
            $url = "index.php";
        }
    }
    
  echo $themassage;
    echo "<div class='alert alert-info'>" . "you will be redirected in" . $seconds . " seconds" . "</div>";
    header("refresh:$seconds;url=$url");
    exit();
};










///////////////////

function calculateitems ($item,$table,$query=''){
  
    global $db;
    $stmt2 = $db->prepare("SELECT COUNT($item) FROM $table $query");
    $stmt2->execute();
    return $stmt2->fetchColumn();
};





















///////////////////////
////check items function
function checkitems($select,$from,$value){
    global $db;
    $stmt = $db->prepare("SELECT $select FROM $from WHERE $select = ?");
    $stmt->execute(array($value));
    $count = $stmt->rowCount();
   return $count;

};











////////////////////function get latest

function getlatest($select,$table,$order,$limit=5){
    global $db;
    $stmt = $db->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
    $stmt->execute();
    $row = $stmt->fetchAll();
    return $row;
}
//////////////////////////////////
function checkmemberstatus($user){
    global $db;
    $stmt = $db->prepare("SELECT username,password FROM `shop` WHERE username = ? AND regstatus= 0 ");
    $stmt->execute(array($user));
$count = $stmt->rowCount();
return $count;
}
?>
