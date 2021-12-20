<?php
session_start(); 
include 'init.php';
 ?>
<section class="cats2">
    <div class="container">
        <h1 class="text-center text-uppercase text-muted">
            <?php echo str_replace("-"," ",$_GET['name'])  ?>
        </h1>
        <div class="row">
        <?php
        $items = tags($_GET['name']);
        if(empty($items)){
            echo "there is no items";
        }else{
            foreach ($items as $key ) {
             echo "<div class='col-md-4'>";
                echo '
                <div class="card mt-3" style="width: 18rem;">
                <img class="card-img-top" src="img_avatar.png" alt="Card image cap">
                <div class="card-body">
                  <h5 class="card-title"> <a href="items.php?id='. $key['itemid'] .'">  '.  $key['name'] .' </a> </h5>
                  <p class="card-text">'. $key['des'] .'</p>
                  <h4> '. $key['price'] .'$ </h4>
                
                </div>
              </div>               
                ';
             echo "</div>";
            }
        }
?>
</div>
    </div>
</section>
<?php
include "includes/templates/footer.php";
?>