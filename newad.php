
<?php
session_start();


include 'init.php';
if(isset($_SESSION['name'])){
print_r($_SESSION);
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
    
    $desc = filter_var($_POST['des'],FILTER_SANITIZE_STRING);
    $price = filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);

    $country = filter_var($_POST['country'],FILTER_SANITIZE_STRING);
    $status = filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
 
    $cats = filter_var($_POST['cats'],FILTER_SANITIZE_NUMBER_INT);
    $tags = filter_var($_POST['tags'],FILTER_SANITIZE_STRING);
    
    $stmt = $db->prepare("INSERT INTO item(name,des,price,country,status,tags,USERID,Cat_id,adddate,approve) VALUES(:zuser,:zpass,:zemail,:zfullname,:zstatus,:ztags,:zmembers,:zcat,now(),0)");
    $stmt->execute(array(
     "zuser" => $name,
     "zpass" => $desc,
     "zemail" => $price,
     "zfullname" => $country,
     "zstatus" => $status,
     "ztags" => $tags,
     "zmembers" => $_SESSION['josphid'],
     "zcat" => $cats
    )); 
    echo "item added";
   
    
  }
?>
<div class="create-ads py-5">
    <div class="container">
        <div class="card">
            <div class="card-header">create new ads</div>
            <div class="card-body">
             <div class="row">
                 <div class="col-md-8">
                 <h1 class='text-center x23'>add item</h1>
    <div class='container'>
    <form class='' action='<?php echo $_SERVER['PHP_SELF'];  ?>' method='POST'>
      
    <div class='form-group'>
    <label class=' control-label'>name</label>
    
    <input type='text' class='form-control live1  formjo5' name='name'    />
  
    </div>
    
   
    
    <div class='form-group'>
    <label class=' control-label'>description</label>
   
    <input type='text' class='form-control live2' name='des'  />

    </div>
    
    
    <div class='form-group'>
    <label class=' control-label'>price</label>
   
    <input type='text' class='form-control live3' name='price'  />
   
    </div>
    
    <div class='form-group'>
    <label class=' control-label'>country</label>
 
    <input type='text' class='form-control' name='country'  />
 
    </div>
    <div class='form-group'>
    <label class='col-sm-2 control-label'>tags</label>
    <div class='col-sm-12'>
    <input type='text' class='form-control' name='tags' placeholder='sepearate tage with comma(,)'  />
    </div>
    </div>
    
    <div class='form-group'>
    <label class=' control-label'>status</label>
   
   <select name ='status' class='form-control custom-select'>
        <option value="0">....</option>
        <option value="1">new</option>
        <option value="2">old</option>
        <option value="3">used</option>

</select>
    
    </div>


    

    <div class='form-group'>
    <label class=' control-label'>choose catagory</label>
   
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







    <div class='form-group'>
    
    
    <input type='submit' value='add item' class='btn btn-outline-dark btn-block' />
    </div>
    </div>
    </form>
    </div>
                 

                 <div class="col-md-4">
                  <div class="card mt-3 live-pre" style="width: 18rem;">
                <img class="card-img-top" src="img_avatar2.png" alt="Card image cap">
                <div class="card-body">
                  <h5 class="card-title">  title </h5>
                  <p class="card-text">description</p>
                  <h4> price </h4>
                
                </div>
              </div>               
          
                 </div>
             </div>

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



