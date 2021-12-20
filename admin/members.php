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

    <form action="members.php?do=search" method='POST' class='subimt'>
        <div class="form-group">
            <input type='text' name='name' class='form-control mb-2' placeholder="enter username you want to find" />
            <input type='submit'  class='btn btn-info btn-block' value='search' />
        </div>
    </form>
  <?php
  }
    ////////////manage members
    $stmt = $db->prepare("SELECT * FROM `shop` WHERE groupid != 1 $query");
    $stmt->execute();
   $row = $stmt->fetchAll();
 
  ?>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <tr>
            <td>#ID</td>
            <td>username</td>
            <td>email</td>
            <td>fullname</td>
            <td>registered date</td>
            <td>control</td>
            </tr>
            <?php
         foreach($row as $row1){
             echo "<tr>";
                echo "<td>" . $row1['userid'] . "</td>";
                echo "<td>" . $row1['username'] . "</td>";
                echo "<td>" . $row1['email'] . "</td>";
                echo "<td>" . $row1['fullname'] . "</td>";
                echo "<td>" . $row1['date']."</td>";
                echo '<td>' . '<a href="members.php?do=delete&userid='. $row1['userid'].'" class="btn btn-danger mr-2 confirm">delete</a>'. '<a href="members.php?do=edit&userid='. $row1['userid'].'" class="btn btn-success">edit</a>' ;
                      
                if($row1['regstatus'] == 0){
                    echo '<a href="members.php?do=activate&userid='. $row1['userid'].'" class="btn btn-info ml-2">Activate</a>';
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
    <a href='members.php?do=add' class='btn btn-primary'> add member </a>
</div>

    <?php
    ////////////////////////////////////////////////////////////////
}elseif($do === 'search'){
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = $_POST['name'];
    $name2 =  $name . '%' ;
  $arrmsg = [];
  if(empty($name)){
      $arrmsg[] = 'you can not leave the field empty';
  }
  if(empty($arrmsg)){
$stmt = $db->prepare("SELECT * FROM `shop` WHERE username LIKE ? AND groupid = 0");

$stmt->execute(array($name2));
$count = $stmt->rowCount();
$row = $stmt->fetchAll();


if($count >= 1){
    ?>
    <table class="table table-bordered mt-3">
    <tr>
    <td>#ID</td>
    <td>username</td>
    <td>email</td>
    <td>fullname</td>
    <td>registered date</td>
    <td>control</td>
    </tr>

    <?php
    foreach($row as $row2){
  
     echo "<tr>";
     echo "<td>" . $row2['userid'] . "</td>";
     echo "<td>" . $row2['username'] . "</td>";
     echo "<td>" . $row2['email'] . "</td>";
     echo "<td>" . $row2['fullname'] . "</td>";
     echo "<td>" .$row2['date']. "</td>";
     echo '<td>' . '<a href="members.php?do=delete&userid='. $row2['userid'].'" class="btn btn-danger mr-2 confirm">delete</a>'. '<a href="members.php?do=edit&userid='. $row2['userid'].'" class="btn btn-success">edit</a>' ."</td>";               
     
  echo"</tr>";
    }
}else{
    $msg = "<div class='alert alert-danger'> there is no such name</div>";
    errmsg($msg,"back");
}
  }else{
      foreach($arrmsg as $msg){
          echo $msg."<br/>";
      }
  }
}else{
       
    $msg = "<div class='alert alert-danger'> you not authorized to be here</div>";
    errmsg($msg,"back",6);
}

}
elseif($do === 'add'){


?>
<h1 class='text-center x23'>add members</h1>
<div class='container'>
<form class='form-horizontal form-rows' action='members.php?do=insert' method='POST'>
  
<div class='form-group'>
<label class='col-sm-2 control-label'>username</label>
<div class='col-sm-12'>
<input type='text' class='form-control  formjo5' name='username' autocomplete='off'  required='required' />
</div>
</div>

<div class='form-group'>
<label class='col-sm-2 control-label'>password</label>
<div class='col-sm-12'>
<input type='password' class='form-control' name='password' autocomplete='new-password' required='required'  />

</div>
</div>

<div class='form-group'>
<label class='col-sm-2 control-label'>email</label>
<div class='col-sm-12'>
<input type='email' class='form-control' name='email'  required='required'/>
</div>
</div>


<div class='form-group'>
<label class='col-sm-2 control-label'>fullname</label>
<div class='col-sm-12'>
<input type='text' class='form-control' name='fullname'  required='required'/>
</div>
</div>


<div class='form-group'>


<input type='submit' class='btn btn-outline-dark btn-block' />
</div>
</div>
</form>
</div>

<?php


}elseif($do === 'insert'){
    echo "<div class='container'>";
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        echo "<h1 class='text-center x23'>insert  page </h1>";
    
        $name = $_POST['username'];
    
        $email = $_POST['email'];
        $fullname = $_POST['fullname'];

        $pass = $_POST['password'];
        $haspass = sha1($_POST['password']);
/////////////////validate form
$arroferrors = array();
if(empty($name)){
$arroferrors[] = "name can not be empty" . "<br/>";
}
if(empty($email)){
    $arroferrors[] = "email can not be empty" . "<br/>";
    }
    if(empty($fullname)){
        $arroferrors[] = "fullname can not be empty" . "<br/>";
        }
        if(empty($pass)){
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
 $check = checkitems("username","shop",$name);
    if($check === 0){
       

       $stmt = $db->prepare("INSERT INTO shop(username,password,email,fullname,regstatus,date) VALUES(:zuser,:zpass,:zemail,:zfullname,1,now())");
       $stmt->execute(array(
        "zuser" => $name,
        "zpass" => $haspass,
        "zemail" => $email,
        "zfullname" => $fullname
       )); 
       echo "";
       $msg = "<div class='alert alert-success'> 1 row inserted</div>";
       errmsg($msg,"back");
    }else{
            
            $msg = "<div class='alert alert-danger'> username already excisted</div>";
            errmsg($msg,"back");
            
    }
 }
        
    }else{
        $msg = "<div class='alert alert-danger'> you are not authorized to go there</div>";
        errmsg($msg);
    }
    echo "</div>";
}
elseif($do === 'edit'){

    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ?  intval($_GET['userid']) :  "0";
 

    
    $stmt = $db->prepare("SELECT * FROM `shop` WHERE userid = ? LIMIT 1");
    $stmt->execute(array($userid));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count > 0){
  
   ?>
<h1 class='text-center x23'>edit member </h1>
<div class='container'>
<form class='form-horizontal form-rows' action='members.php?do=update' method='POST'>
    <input type='hidden' name='userid' value="<?php echo $row['userid']  ?>"/> 
<div class='form-group'>
<label class='col-sm-2 control-label'>username</label>
<div class='col-sm-12'>
<input type='text' class='form-control  formjo5' name='username' autocomplete='off' value="<?php echo $row['username']  ?>" required='required' />
</div>
</div>

<div class='form-group'>
<label class='col-sm-2 control-label'>password</label>
<div class='col-sm-12'>
<input type='password' class='form-control' name='new-password' autocomplete='new-password'  />
<input type='hidden' class='form-control' name='old-password'  value="<?php echo $row['password']  ?>"  />
</div>
</div>

<div class='form-group'>
<label class='col-sm-2 control-label'>email</label>
<div class='col-sm-12'>
<input type='email' class='form-control' name='email' value="<?php echo $row['email']  ?>" required='required'/>
</div>
</div>


<div class='form-group'>
<label class='col-sm-2 control-label'>fullname</label>
<div class='col-sm-12'>
<input type='text' class='form-control' name='fullname' value="<?php echo $row['fullname']  ?>" required='required'/>
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
        $id = $_POST['userid'];
        $name = $_POST['username'];
    
        $email = $_POST['email'];
        $fullname = $_POST['fullname'];

/////////////////////check if password field are empty or not
$pass = empty($_POST['new-password']) ?  $_POST['old-password'] :  sha1($_POST['new-password']);
/////////////////validate form
$arroferrors = array();
if(empty($name)){
$arroferrors[] = "name can not be empty" . "<br/>";
}
if(empty($email)){
    $arroferrors[] = "email can not be empty" . "<br/>";
    }
    if(empty($fullname)){
        $arroferrors[] = "fullname can not be empty" . "<br/>";
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
     $stmt2 = $db->prepare("SELECT * FROM `shop` WHERE username = ? AND userid != ?");
     $stmt2->execute(array($name,$id));
     $count = $stmt2->rowCount();
     echo $count;
     if($count == 1){
        $msg = "<div class='alert alert-danger'> user already excist </div>";
        errmsg($msg,"back");
     }else{
     
        $stmt = $db->prepare("UPDATE shop SET username=?,email=?,password = ?,fullname=? WHERE userid = ?");
        $stmt->execute(array($name,$email,$pass,$fullname,$id));
        $count = $stmt->rowcount();
   
        $msg = "<div class='alert alert-danger'>". $count . " has been updated" . "</div>";
        errmsg($msg,"back");
     }
 }
        
    }else{
        $msg = "<div class='alert alert-danger'> you not authorized to be here</div>";
        errmsg($msg,"back");
       
    }
    echo "</div>";
}elseif($do === 'activate'){
    $id = $_GET['userid'];
    $stmt = $db->prepare("UPDATE shop SET regstatus = 1 WHERE userid = ?");
    $stmt->execute(array($id));
    $msg = "<div class='alert alert-success'> 1 member has been activated</div>";
    errmsg($msg,"back");
}
elseif($do === 'delete'){
   
    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ?  intval($_GET['userid']) :  "0";
    echo $userid;
    $stmt = $db->prepare("SELECT * FROM `shop` WHERE userid = ? LIMIT 1");
    $stmt->execute(array($userid));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count > 0){
        $stmt = $db->prepare("DELETE FROM shop WHERE userid = :zuser");
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