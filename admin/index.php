
<?php


session_start();
$pagetitle = 'login';
if(isset($_SESSION['username'])){
    header('Location:dashboard.php');
}
$nonavbar = '';
include 'init.php';
// checking if user coming from http post request
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $hashedpassword = sha1($pass);
  
    $stmt = $db->prepare("SELECT username,password,userid,groupid FROM `shop` WHERE username = ? AND password = ? AND groupid = 1");
    $stmt->execute(array($user,$hashedpassword));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count >= 1){
    
        
        $_SESSION['username'] = $user;
        $_SESSION['id'] = $row['userid'];
        header('Location:dashboard.php');
        exit();
        
    }
}

?>


<form class='login' action='<?php echo $_SERVER['PHP_SELF'] ?>' method='POST'>
    <h4 class='text-center'>admin login </h4>
<input type='text' class='form-control' name='user' autocomplete='off' placeholder='username' />
<input type='password'
class='form-control' name='pass' autocomplete='new-password' placeholder='password' />
<input type='submit' value='enter data' class='btn btn-primary btn-block'/>
</form>


<?php
include "includes/templates/footer.php";
?>



