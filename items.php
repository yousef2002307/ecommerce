
<?php
ob_start();
session_start();


include 'init.php';
   
$userid = isset($_GET['id']) && is_numeric($_GET['id']) ?  intval($_GET['id']) :  "0";
 

    
$stmt = $db->prepare("SELECT item.*,catagories.NAME,shop.username FROM item INNER JOIN catagories ON item.cat_id = catagories.ID INNER JOIN shop ON shop.userid = item.USERID WHERE item.itemid = ? AND item.approve = 1");
$stmt->execute(array($userid));
$row = $stmt->fetch();
$count = $stmt->rowCount();
if($count > 0){
?>
<h1 class='text-center mb-3 mt-4'><?php echo $row['name'] ?></h1>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <img src='img_avatar.png ' class='img-thumbnail center-block' style='max-width:100%' />
        </div>
        <div class="col-md-8 mt-4">
            <h4><?php echo $row['name']  ?></h4>
            <p><?php echo $row['des']  ?> </p>
            <span>addin-date : <?php echo $row['adddate']  ?> </span>
            <p>price is : <?php echo $row['price'] ?>$</p>
            <p>country of manufactrion : <?php echo $row['country']  ?></p>
            <p> catagory  :<?php echo $row['NAME'] ?> </p>
            <p> addedBY:<?php echo $row['username'] ?> </p>
            <p>tags:<?php
            $alltags = explode(",",$row['tags']);
            foreach($alltags as $tag){
                $replacedtag = str_replace(" ","",$tag);
                echo "<a href='tags.php?name=". $replacedtag ."'>" . $tag . "</a>" . " | ";
            }
            
            ?> </p>
        </div>
    </div>
    <hr />
    <?php
if(isset($_SESSION['name'])){
    ?>
    <div class="comment-jo" class=' mx-auto' style="width:85%">
<h3 class='text-center'> add your comment </h3>
<form action="<?php echo $_SERVER['PHP_SELF'] . "?id=" . $row['itemid']  ?>" method='POST'>
    <textarea name='com' class='form-control mb-3'></textarea>
    <input type='submit' class='btn btn-info btn-block' />
</form>
    </div>
    <?php
    ////////////manage members
  $stmt2 = $db->prepare("SELECT comments.*,item.name,shop.username FROM `comments` INNER JOIN item ON item.itemid = comments.item_id INNER JOIN shop ON shop.userid = comments.user_id WHERE item.itemid = ? AND comments.status = 1 ORDER BY c_id DESC ");
  $stmt2->execute(array($userid));
 $row2 = $stmt2->fetchAll();
 echo "<hr />";
 foreach($row2 as $row3){
    echo "<div class='row'>";
    echo "<div class='col-md-3'>" . $row3['username'] . "</div>";
echo "<div class='col-md-3'>" . $row3['comment'] . "</div>";

    echo"</div>";
    echo "<hr />";
 }
 ?>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $com = filter_var($_POST['com'],FILTER_SANITIZE_STRING);
    $userid = $row['USERID'];
    $itemid = $row['itemid'];
    if(!empty($com)){
        $stmt = $db->prepare("INSERT INTO comments(comment,item_id,adddate,user_id,status) VALUES(:zcom,:zitem,now(),:zuser,0)");
        $stmt->execute(array(
            "zcom" => $com,
            "zitem" => $itemid,
            "zuser" =>  $_SESSION['josphid']
        ));
      
    }
        
}

}
 
?>

 
 
</div>
<?php
}else{
    echo "<div class='alert alert-danger'>item not approved yet</div>";
}
?>

<?php

include "includes/templates/footer.php";
ob_end_flush();
?>



