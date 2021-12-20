<?php

///////////////////////////////////////
function cat($where = ''){
    global $db;
    $stmt = $db->prepare("SELECT * FROM `catagories` $where ORDER BY ID DESC");
    $stmt->execute();
    $row = $stmt->fetchAll();
    return $row;
};





















//////////////////////////////////////////////////////////////////////////
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

?>
