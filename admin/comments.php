<?php
ob_start();
session_start();
$pagetitle = 'members';
if(isset($_SESSION['username'])){
   include 'init.php';
   $do = '';
if(isset($_GET['do'])){
    $do = $_GET['do'];
}else{
    $do = 'manage';
}
if($do === 'manage'){
  $query = '';
  if(isset($_GET['page']) && $_GET['page'] == 'pending'){
      $query = "AND regstatus = 0";
  }else{
    ?>
    <div class='container'>
    <h6 class='text-center'>welcome to manage</h6>

  
  <?php
  }
    ////////////manage members
    $stmt = $db->prepare("SELECT comments.*,item.name,shop.username FROM `comments` INNER JOIN item ON item.itemid = comments.item_id INNER JOIN shop ON shop.userid = comments.user_id");
    $stmt->execute();
   $row = $stmt->fetchAll();
 if(!empty($row)){
  ?>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <tr>
            <td>#ID</td>
            <td>comment</td>
            <td>adddate</td>
            <td>item name</td>
            <td>user date</td>
            <td>control</td>
            </tr>
            <?php
         foreach($row as $row1){
             echo "<tr>";
                echo "<td>" . $row1['c_id'] . "</td>";
                echo "<td>" . $row1['comment'] . "</td>";
                echo "<td>" . $row1['adddate'] . "</td>";
                echo "<td>" . $row1['name'] . "</td>";
                echo "<td>" . $row1['username']."</td>";
                echo '<td>' . '<a href="comments.php?do=delete&c_id='. $row1['c_id'].'" class="btn btn-danger mr-2 confirm">delete</a>'. '<a href="comments.php?do=edit&c_id='. $row1['c_id'].'" class="btn btn-success">edit</a>' ;
                      
                if($row1['status'] == 0){
                    echo '<a href="comments.php?do=approve&c_id='. $row1['c_id'].'" class="btn btn-info ml-2">Activate</a>';
                }
                echo "</td>"; 
             echo"</tr>";
         }

         ?>
        </table>
    </div>
 
</div>

    <?php
 }else{
     echo "there is no rechod";
 }
    ////////////////////////////////////////////////////////////////
}

elseif($do === 'edit'){

    $comid = isset($_GET['c_id']) && is_numeric($_GET['c_id']) ?  intval($_GET['c_id']) :  "0";
 

    
    $stmt = $db->prepare("SELECT * FROM `comments` WHERE c_id = ? LIMIT 1");
    $stmt->execute(array($comid));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count > 0){
  
   ?>
<h1 class='text-center x23'>edit comment </h1>
<div class='container'>
<form class='form-horizontal form-rows' action='?do=update' method='POST'>
    <input type='hidden' name='id' value="<?php echo $row['c_id']  ?>"/> 
<div class='form-group'>
<label class='col-sm-2 control-label'>username</label>
<div class='col-sm-12'>
<textarea class='form-control' name="comment" id="" cols="30" rows="10"><?php echo $row['comment'];  ?></textarea>
</div>
</div>



<div class='form-group'>


<input type='submit' class='btn btn-outline-dark btn-block' />
</div>
</div>
</form>
</div>

<?php
  }else{

    $msg = "<div class='alert alert-danger'> your not authorized to be here</div>";
    errmsg($msg,"back");
}
}
elseif($do === 'update'){

  echo "<div class='container'>";
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        echo "<h1 class='text-center x23'>update page </h1>";
        $id = $_POST['id'];
        $name = $_POST['comment'];
    

/////////////////////check if password field are empty or not

/////////////////validate form
$arroferrors = array();

 ///////////////////
 if(empty($arroferrors)){
        $stmt = $db->prepare("UPDATE comments SET comment=? WHERE c_id = ?");
        $stmt->execute(array($name,$id));
        $count = $stmt->rowcount();
   
        $msg = "<div class='alert alert-danger'>". $count . " has been updated" . "</div>";
        errmsg($msg,"back");
 }
        
    }else{
        $msg = "<div class='alert alert-danger'> you not authorized to be here</div>";
        errmsg($msg,"back");
       
    }
    echo "</div>";
}elseif($do === 'approve'){
    $comid = $_GET['c_id'];
    $stmt = $db->prepare("UPDATE comments SET status = 1 WHERE c_id = ?");
    $stmt->execute(array($comid));
    $msg = "<div class='alert alert-success'> 1 member has been activated</div>";
    errmsg($msg,"back");
}
elseif($do === 'delete'){
   
    $comid = isset($_GET['c_id']) && is_numeric($_GET['c_id']) ?  intval($_GET['c_id']) :  "0";
 
    $stmt = $db->prepare("SELECT * FROM `comments` WHERE c_id = ? LIMIT 1");
    $stmt->execute(array($comid));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count > 0){
        $stmt = $db->prepare("DELETE FROM comments WHERE c_id = :zuser");
        $stmt->bindParam(":zuser",$comid);
        $stmt->execute();
        echo "1 user was deleted";
        $msg = "<div class='alert alert-danger'> user has been deleted succsesfuly</div>";
        errmsg($msg,"back");
    }else{
        echo "";
        $msg = "<div class='alert alert-danger'> your id not excist</div>";
        errmsg($msg,"back");
    }
}
else{
    echo"";
    $msg = "<div class='alert alert-danger'>ERROR there is no page with such name</div>";
    errmsg($msg,"back");
}
   
include "includes/templates/footer.php";



}else{
    header("Location:index.php");
    exit();
}

ob_end_flush();
?>