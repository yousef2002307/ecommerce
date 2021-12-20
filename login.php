
<?php
session_start();
if(isset($_SESSION['name'])){
    header('Location:index.php');
}

include 'init.php';

// checking if user coming from http post request
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['login'])){
    $user = $_POST['username'];
  
    $pass = $_POST['password'];
    $hashedpassword = sha1($pass);
  
    $stmt = $db->prepare("SELECT username,userid,password FROM `shop` WHERE username = ? AND password = ? ");
    $stmt->execute(array($user,$hashedpassword));
$row = $stmt->fetch();

    $count = $stmt->rowCount();
    if($count >= 1){
    
        
        $_SESSION['name'] = $user;
        $_SESSION['josphid'] = $row['userid'];
    
     
       header('Location:index.php');
        exit();
        
    }
}else{
$arrforms = array();
if(isset($_POST['username'])){
    $santaizeusername = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
    echo $santaizeusername;
    if(strlen($santaizeusername) <= 4){
        $arrforms[] = "you have errors man";
    }
}
if(isset($_POST['password']) && isset($_POST['password2'])){
    $pass1 = sha1($_POST['password']);
    $pass2 = sha1($_POST['password2']);
  
    if($pass1 != $pass2  ){
        $arrforms[] = "password do not match";
    }
    if(empty($_POST['password'])){
        $arrforms[] = "you can leave password field empty";
    }
}
if(isset($_POST['email'])){
    $santaizeuseremail = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);

   if(filter_var($santaizeuseremail,FILTER_VALIDATE_EMAIL) ==  false){
       $arrforms[] = "your email is inncorrect";
    }
  
}
if(empty($arrforms)){
    $check = checkitems("username","shop",$_POST['username']);
       if($check === 0){
          
   
          $stmt = $db->prepare("INSERT INTO shop(username,password,email,regstatus,date) VALUES(:zuser,:zpass,:zemail,0,now())");
          $stmt->execute(array(
           "zuser" => $_POST['username'],
           "zpass" => sha1($_POST['password']),
           "zemail" => $_POST['email']
          )); 
        
       $success = "congrats you are now a member";
       }else{
               
             $arrforms[] = "username already excist";
               
       }
    }
}

}


?>
<div class="container xyz">
    <h1 class="text-center mt-5"> <span class="loginup">login</span>  <span>|</span > <span class='signup2'>signup</span> </h1>
    <form action="" class="login" action='<?php echo $_SERVER['PHP_SELF'] ?>' method='POST'>
        
        <input type="text" name="username"  class='form-control'/> 

        <input type="password" name="password"  class='form-control ' />


        <input type="submit"  class='btn btn-danger btn-block ' value='login' name='login' /> 


    </form>
    <form action="" class="signup" action='<?php echo $_SERVER['PHP_SELF'] ?>' method='POST'>
 
        <input type="text" name="username"  class='form-control' pattern='.{4,12}' title="dhdghjh dhjdgdh" /> 


        <input type="password" name="password"  class='form-control' minlength="4"  /> 

        <input type="password" name="password2"  class='form-control' /> 

        <input type="text" name="email"  class='form-control' /> 

        <input type="submit"  class='btn btn-success btn-block' value='sign up' name='signup' /> 
    </form>
    <div class="errors text-center">
        <?php
            if(!empty($arrforms)){
                foreach($arrforms as $key){
                    echo $key . "<br />";
                }
            }
            if(isset($success)){
                echo "<div>" . $success . "</div>";
            }
        ?>
    </div>
</div>
<?php
include "includes/templates/footer.php";
?>



