
<?php
session_start();


include 'init.php';
if(isset($_SESSION['name'])){
    $stmt = $db->prepare("SELECT * FROM shop WHERE username = ?");
    $stmt->execute(array($_SESSION['name']));
    $info = $stmt->fetch();
 
?>
<div class="information py-5">
    <div class="container">
        <div class="card">
            <div class="card-header">my information</div>
            <div class="card-body">
                name : <?php echo $sessionname . "<br />";  ?>
                email : <?php echo $info['email'] . "<br />";  ?>
                fullname : <?php echo $info['fullname'] . "<br />";  ?>
                register date : <?php echo $info['date'] . "<br />";  ?>
                edit profile : <?php echo "<a class='btn btn-primary'> edit </a>";  ?>


            </div>
        </div>
    </div>
</div>
<div class="ads py-5">
    <div class="container">
        <div class="card">
            <div class="card-header">my advirtisment</div>
            <div class="card-body">
                <?php
                echo "<div class='row'>";
            foreach (member($info['userid']) as $key ) {
                
                echo "<div class='col-md-4'>";
                echo '
                <div class="card mt-3" style="width: 18rem;">
                <img class="card-img-top" src="img_avatar.png" alt="Card image cap">
                <div class="card-body">
              
                  <h5 class="card-title"> <a href="items.php?id='. $key['itemid'] .'">   '.  $key['name'] .' </a> </h5>
                  <p class="card-text">'. $key['des'] .'</p>
                  <h4> '. $key['price'] .'$ </h4>
                
                </div> ';
                if($key['approve'] == 0){
              echo '<span class = "badge badge-primary"> item not approved yet  </span>';
                }
                echo "</div>";               
                
             echo "</div>";
            }
            echo "</div>";
            ?>
            </div>
        </div>
    </div>
</div>
<div class="information py-5">
    <div class="container">
        <div class="card">
            <div class="card-header">my comments</div>
            <div class="card-body">
            <?php
                echo "<div class='row'>";
            foreach (jo_comments($info['userid']) as $key ) {
                
                echo "<div class='col-md-4'>";
                echo '
                <div class="card mt-3" style="width: 18rem;">
              
                <div class="card-body">
                  <h5 class="card-title">  '.  $key['comment'] .'  </h5>
                <span> ' . $key["adddate"] . ' </span>
                </div>
              </div>               
                ';
             echo "</div>";
            }
            echo "</div>";
            ?>
            </div>
        </div>
    </div>
</div>
<?php
}else{
   header("Location:index.php");
   exit();
}
?>
<?php

include "includes/templates/footer.php";
?>



