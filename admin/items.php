<?php
ob_start();
session_start();
$pagetitle = 'items';
if(isset($_SESSION['username'])){
    include "init.php";
if(isset($_GET['do'])){
    $do = $_GET['do'];
}else{
    $do = 'manage';
}
if($do == 'manage'){
  
   
      ////////////manage members
      $stmt = $db->prepare("SELECT item.*,catagories.NAME AS catagory_name,shop.username FROM item INNER JOIN catagories ON catagories.ID = item.cat_id INNER JOIN shop ON shop.userid = item.USERID ORDER BY adddate DESC");
      $stmt->execute();
     $row = $stmt->fetchAll();
 
   ?>
   <div class="container">
   <div class="table-responsive mt-5">
       <table class="table table-bordered table-hover table-striped">
           <tr>
           <td>#ID</td>
           <td>name</td>
           <td>description</td>
           <td>price</td>
           <td>adding date</td>
           <td>catagory name</td>
           <td>username</td>
           <td>control</td>
           </tr>
           <?php
        foreach($row as $row1){
            echo "<tr>";
               echo "<td>" . $row1['itemid'] . "</td>";
               echo "<td>" . $row1['name'] . "</td>";
               echo "<td>" . $row1['des'] . "</td>";
               echo "<td>" . $row1['price'] . "</td>";
               echo "<td>" . $row1['adddate']."</td>";
               echo "<td>" . $row1['catagory_name']."</td>";
               echo "<td>" . $row1['username']."</td>";
               echo '<td>';
               echo '<a href="items.php?do=delete&id='. $row1['itemid'].'" class="btn btn-danger mr-2 confirm">delete</a>';
               echo  '<a href="items.php?do=edit&id='. $row1['itemid'].'" class="btn btn-success">edit</a>' ;
               if($row1['approve'] == 0){
                echo '<a href="items.php?do=approve&id='. $row1['itemid'].'" class="btn btn-info ml-2">Approve</a>';
            }
                     
               
               echo "</td>"; 
            echo"</tr>";
        }

        ?>
           <!--
           <tr>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td>
                       <a href="#" class='btn btn-danger'>delete</a>
                       <a href="#" class='btn btn-success'>edit</a>
                   </td>
           </tr>

-->
       </table>
   </div>
  
</div>

   <?php
   
    echo "<a href='?do=add' class='btn btn-danger'> add member </a>";
    echo "</div>";
}elseif($do == 'approve'){
    $id = $_GET['id'];
    $stmt = $db->prepare("UPDATE item SET approve = 1 WHERE itemid = ?");
    $stmt->execute(array($id));
    $msg = "<div class='alert alert-success'> 1 item has been approved</div>";
    errmsg($msg,"back");
}
elseif($do == 'edit'){
    
    $userid = isset($_GET['id']) && is_numeric($_GET['id']) ?  intval($_GET['id']) :  "0";
 

    
    $stmt = $db->prepare("SELECT * FROM `item` WHERE itemid = ? LIMIT 1");
    $stmt->execute(array($userid));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count > 0){
  
   ?>
  <h1 class='text-center x23'>edit item</h1>
    <div class='container'>
    <form class='form-horizontal form-rows' action='items.php?do=update' method='POST'>
    <input type='hidden' name='itemid' value="<?php echo $row['itemid']  ?>"/> 
    <div class='form-group'>
    <label class='col-sm-2 control-label'>name</label>
    <div class='col-sm-12'>
    <input type='text' class='form-control  formjo5' name='name' value="<?php echo $row['name'];  ?>"   />
    </div>
    </div>
    
   
    
    <div class='form-group'>
    <label class='col-sm-2 control-label'>description</label>
    <div class='col-sm-12'>
    <input type='text' class='form-control' name='des' value="<?php echo $row['des'];  ?>"   />
    </div>
    </div>
    
    
    <div class='form-group'>
    <label class='col-sm-2 control-label'>price</label>
    <div class='col-sm-12'>
    <input type='text' class='form-control' name='price' value="<?php echo $row['price'];  ?>"   />
    </div>
    </div>
    
    <div class='form-group'>
    <label class='col-sm-2 control-label'>country</label>
    <div class='col-sm-12'>
    <input type='text' class='form-control' name='country' value="<?php echo $row['country'];  ?>"   />
    </div>
    </div>
    
    <div class='form-group'>
    <label class='col-sm-2 control-label'>status</label>
    <div class='col-sm-12'>
   <select name ='status' class='form-control custom-select'>
        <option value="0" <?php if($row['status'] == 0){echo "selected";}  ?>>....</option>
        <option value="1" <?php if($row['status'] == 1){echo "selected";}  ?>>new</option>
        <option value="2" <?php if($row['status'] == 2){echo "selected";}  ?>>old</option>
        <option value="3" <?php if($row['status'] == 3){echo "selected";}  ?>>used</option>

</select>
    </div>
    </div>


    <div class='form-group'>
    <label class='col-sm-2 control-label'>choose member</label>
    <div class='col-sm-12'>
   <select name ='members' class='form-control custom-select'>
        <option value="0">....</option>
      <?php

        $stmt = $db->prepare("SELECT * FROM `shop`");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        foreach ($rows as $key ) {
            if($key['userid'] == $row['USERID']){
          echo "<option  value='". $key['userid']."' selected>" . $key['username'] . "</option>";
            }else{
                echo "<option  value='". $key['userid']."' >" . $key['username'] . "</option>";
            }
        }

?>

</select>
    </div>
    </div>

    <div class='form-group'>
    <label class='col-sm-2 control-label'>choose catagory</label>
    <div class='col-sm-12'>
   <select name ='cats' class='form-control custom-select'>
        <option value="0">....</option>
      <?php

        $stmt = $db->prepare("SELECT * FROM `catagories`");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        foreach ($rows as $key ) {
            if($key['ID'] == $row['cat_id']){
            echo "<option value='". $key['ID']."' selected>" . $key['NAME'] . "</option>";
        }else{
            echo "<option value='". $key['ID']."'>" . $key['NAME'] . "</option>";
        }
    }

?>

</select>
    </div>
    </div>







    <div class='form-group'>
    
    
    <input type='submit' value='add item' class='btn btn-outline-dark btn-block' />
    </div>
    </div>
    </form>
    
 
    <h6 class='text-center'>welcome to manage</h6>

  
  <?php

    ////////////manage members
    $stmt = $db->prepare("SELECT comments.*,item.name,shop.username FROM `comments` INNER JOIN item ON item.itemid = comments.item_id INNER JOIN shop ON shop.userid = comments.user_id WHERE itemid = ?");
    $stmt->execute(array($userid));
   $row = $stmt->fetchAll();
 
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

    $msg = "<div class='alert alert-danger'> your not authorized to be here id man</div>";
    errmsg($msg,"back");
}
}elseif($do == 'delete'){
    $userid = isset($_GET['id']) && is_numeric($_GET['id']) ?  intval($_GET['id']) :  "0";
    echo $userid;
    $stmt = $db->prepare("SELECT * FROM `item` WHERE itemid = ? LIMIT 1");
    $stmt->execute(array($userid));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count > 0){
        $stmt = $db->prepare("DELETE FROM item WHERE itemid = :zuser");
        $stmt->bindParam(":zuser",$userid);
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
elseif($do == 'update'){
    echo "<div class='container'>";
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        echo "<h1 class='text-center x23'>update page </h1>";
        $id = $_POST['itemid'];
        $name = $_POST['name'];
    
        $desc = $_POST['des'];
        $price = $_POST['price'];
        $country = $_POST['country'];
        $status = $_POST['status'];
        $cats = $_POST['cats'];
        $members= $_POST['members'];
     

/////////////////validate form
$arroferrors = array();

 ///////////////////
 if(empty($arroferrors)){
        $stmt = $db->prepare("UPDATE item SET name = ?, DES= ? , price = ?,country=?,status = ?, cat_id = ? , USERID = ? WHERE itemid = ?");
        $stmt->execute(array($name,$desc,$price,$country,$status,$cats,$members,$id));
        $count = $stmt->rowcount();
   
        $msg = "<div class='alert alert-danger'>". $count . " has been updated" . "</div>";
        errmsg($msg,"back");
 }
        
    }else{
        $msg = "<div class='alert alert-danger'> you not authorized to be here</div>";
        errmsg($msg,"back");
       
    }
    echo "</div>";
}
elseif($do == 'add'){
    ?>
    <h1 class='text-center x23'>add item</h1>
    <div class='container'>
    <form class='form-horizontal form-rows' action='items.php?do=insert' method='POST'>
      
    <div class='form-group'>
    <label class='col-sm-2 control-label'>name</label>
    <div class='col-sm-12'>
    <input type='text' class='form-control  formjo5' name='name'    />
    </div>
    </div>
    
   
    
    <div class='form-group'>
    <label class='col-sm-2 control-label'>description</label>
    <div class='col-sm-12'>
    <input type='text' class='form-control' name='des'  />
    </div>
    </div>
    
    
    <div class='form-group'>
    <label class='col-sm-2 control-label'>price</label>
    <div class='col-sm-12'>
    <input type='text' class='form-control' name='price'  />
    </div>
    </div>
    
    <div class='form-group'>
    <label class='col-sm-2 control-label'>country</label>
    <div class='col-sm-12'>
    <input type='text' class='form-control' name='country'  />
    </div>
    </div>
    <div class='form-group'>
    <label class='col-sm-2 control-label'>tags</label>
    <div class='col-sm-12'>
    <input type='text' class='form-control' name='tags' placeholder='sepearate tage with comma(,)'  />
    </div>
    </div>
    <div class='form-group'>
    <label class='col-sm-2 control-label'>status</label>
    <div class='col-sm-12'>
   <select name ='status' class='form-control custom-select'>
        <option value="0">....</option>
        <option value="1">new</option>
        <option value="2">old</option>
        <option value="3">used</option>

</select>
    </div>
    </div>


    <div class='form-group'>
    <label class='col-sm-2 control-label'>choose member</label>
    <div class='col-sm-12'>
   <select name ='members' class='form-control custom-select'>
        <option value="0">....</option>
      <?php

        $stmt = $db->prepare("SELECT * FROM `shop`");
        $stmt->execute();
        $row = $stmt->fetchAll();
        foreach ($row as $key ) {
          echo "<option value='". $key['userid']."'>" . $key['username'] . "</option>";
        }

?>

</select>
    </div>
    </div>

    <div class='form-group'>
    <label class='col-sm-2 control-label'>choose catagory</label>
    <div class='col-sm-12'>
   <select name ='cats' class='form-control custom-select'>
        <option value="0">....</option>
      <?php

        $stmt = $db->prepare("SELECT * FROM `catagories`");
        $stmt->execute();
        $row = $stmt->fetchAll();
        foreach ($row as $key ) {
            echo "<option value='". $key['ID']."'>" . $key['NAME'] . "</option>";
        }

?>

</select>
    </div>
    </div>







    <div class='form-group'>
    
    
    <input type='submit' value='add item' class='btn btn-outline-dark btn-block' />
    </div>
    </div>
    </form>
    </div>
    
    <?php
}elseif($do == 'insert'){
    echo "<div class='container'>";
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        echo "<h1 class='text-center x23'>insert  item </h1>";
    
        $name = $_POST['name'];
    
        $desc = $_POST['des'];
        $price = $_POST['price'];

        $country = $_POST['country'];
        $status = $_POST['status'];
        $members = $_POST['members'];
        $cats = $_POST['cats'];
        $tags = $_POST['tags'];
      
/////////////////validate form
$arroferrors = array();
if(empty($name)){
$arroferrors[] = "name can not be empty" . "<br/>";
}
if(empty($price)){
    $arroferrors[] = "email can not be empty" . "<br/>";
    }
    if(empty($country)){
        $arroferrors[] = "fullname can not be empty" . "<br/>";
        }
        if($status == 0){
            $arroferrors[] = "passwordcan not be empty" . "<br/>";
            }
        if(strlen($name) < 5){
            $arroferrors[] = "name can not be less than 5" . "<br/>";
            }
            if(strlen($name) > 20){
                $arroferrors[] = "name can not be larger than 20" . "<br/>";
                }
    foreach($arroferrors as $key){
        echo $key;
    }
 ///////////////////
 if(empty($arroferrors)){
 
    
       

       $stmt = $db->prepare("INSERT INTO item(tags,name,des,price,country,status,USERID,Cat_id,adddate) VALUES(:ztags,:zuser,:zpass,:zemail,:zfullname,:zstatus,:zmembers,:zcat,now())");
       $stmt->execute(array(
        "ztags" => $tags,
        "zuser" => $name,
        "zpass" => $desc,
        "zemail" => $price,
        "zfullname" => $country,
        "zstatus" => $status,
        "zmembers" => $members,
        "zcat" => $cats
       )); 
       echo "";
       $msg = "<div class='alert alert-success'> 1 row inserted</div>";
       errmsg($msg,"back");
       
    
 }
        
    }else{
        $msg = "<div class='alert alert-danger'> you are not authorized to go there</div>";
        errmsg($msg);
    }
    echo "</div>";
}
else{
    echo "you not authorized to be here";
}







/////////////////////////////

include "includes/templates/footer.php";
}else{
    header("Location:index.php");
    exit();
}
ob_end_flush();
?>