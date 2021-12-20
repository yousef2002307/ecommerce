<?php
ob_start();
session_start();
$pagetitle = 'categories';
if(isset($_SESSION['username'])){
    include "init.php";
if(isset($_GET['do'])){
    $do = $_GET['do'];
}else{
    $do = 'manage';
}
if($do === 'manage'){
    $sortarr = array("DESC",'ASC');
    if(isset($_GET['sort']) && in_array($_GET['sort'], $sortarr)){
        $sort = $_GET['sort'];
    }else{
        $sort = $sortarr[1];
    }
    $stmt = $db->prepare("SELECT * FROM `catagories` WHERE parent = 0 ORDER BY ORDERING $sort");
    $stmt->execute();
   $row = $stmt->fetchAll();
  ?>
<h2 class='text-center mt-2 mb-3'> Manage Catagories</h2>
<div class="container">
    <div class="card">
        <div class="card-heading py-2" style="background-color:#ddd">
            Manage Catagories
            <aside>
                ORDERING :
                <a href='categories.php?sort=ASC' class='badge badge-success <?php if($sort == 'ASC'){echo 'active';}  ?>'> ASC </a>
                <a href='categories.php?sort=DESC' class='badge badge-danger'> DESC </a>
             </aside>
        </div>
        <div class="card-body">
            <?php
            foreach ($row as $key ) {
                echo "<div class='cat'>";
              echo "<h3>" . $key['NAME'] . "</h3>" ;
              echo "<p>";
                    if ($key['DESCRIPTION'] == '') {
                       echo 'this is empty';
                    }else{
                            echo $key['DESCRIPTION'];
                    }

              echo "</p>";
              if ($key['VISIBLITY'] == 1) {
                 echo "<span class='vis badge badge-primary mr-2'> Hidden</span>";
              }
              if ($key['ALLOW_COMMENT'] == 1) {
                echo "<span class='com badge badge-danger mr-2'> comments disabled</span>";
             }
             if ($key['ALLOW_ADS'] == 1) {
                echo "<span class='ads badge badge-info mr-2'> ADS disabled</span>";
             }
             echo "
             <aside>
                <a class='btn btn-success' href='categories.php?do=edit&catid=".$key['ID']."'> Edit </a>
                <a class='btn btn-danger confirm' href='categories.php?do=delete&catid=".$key['ID']."'> Delete </a>
             </aside>
             ";
             
              echo "</div>";
              if(!empty(cat('WHERE parent =  '.$key['ID'] . ''))){
                  echo "<h4 class='text-success'> child catagories </h4>";
              echo "<ol class='list-unstyled'>";
              foreach(cat('WHERE parent = '. $key['ID'].'') as $cat2 ){
                echo "<li>  <a class='' href='categories.php?do=edit&catid=".$cat2['ID']."'> " . $cat2['NAME'] . " </a>" .  " <a class=' confirm' href='categories.php?do=delete&catid=".$cat2['ID']."'> Delete </a></li>";
              }
              echo "</ol>";
            }
              echo "<hr />";
            
            
              
            }

?>
        </div>
    </div>
    <a href="categories.php?do=add" class='btn btn-success'>add catagory</a>
</div>


<?php
}elseif($do === 'delete'){
    $userid = isset($_GET['catid']) && is_numeric($_GET['catid']) ?  intval($_GET['catid']) :  "0";
    echo $userid;
    $stmt = $db->prepare("SELECT * FROM `catagories` WHERE ID = ? LIMIT 1");
    $stmt->execute(array($userid));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count > 0){
        $stmt = $db->prepare("DELETE FROM catagories WHERE ID = :zuser");
        $stmt->bindParam(":zuser",$userid);
        $stmt->execute();
        echo "1 user was deleted";
        $msg = "<div class='alert alert-danger'> catagory has been deleted succsesfuly</div>";
        errmsg($msg,"back");
    }else{
        echo "";
        $msg = "<div class='alert alert-danger'> your id not excist</div>";
        errmsg($msg,"back");
    }
}
elseif($do === 'edit'){

    $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ?  intval($_GET['catid']) :  "0";
 

    
    $stmt = $db->prepare("SELECT * FROM `catagories` WHERE ID = ? LIMIT 1");
    $stmt->execute(array($catid));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count > 0){
 
   ?>
<h1 class='text-center x23'>edit categories</h1>
<div class='container'>
<form class='form-horizontal form-rows' action='categories.php?do=update' method='POST'>
<input type='hidden' name='catid' value="<?php echo $row['ID']  ?>"/> 
<div class='form-group'>
<label class='col-sm-2 control-label'>catgname</label>
<div class='col-sm-12'>
<input type='text' class='form-control  formjo5' name='catgname' autocomplete='off'  required='required' value='<?php echo $row['NAME'];  ?>' />
</div>
</div>

<div class='form-group'>
<label class='col-sm-2 control-label'>description</label>
<div class='col-sm-12'>
<input type='text' class='form-control' name='desc'  required='required' value='<?php echo $row['DESCRIPTION'];  ?>'  />

</div>
</div>

<div class='form-group'>
<label class='col-sm-2 control-label'>ordering</label>
<div class='col-sm-12'>
<input type='number' class='form-control' name='ordering'  required='required' value='<?php echo $row['ORDERING'];  ?>'/>
</div>
</div>


<div class='form-group'>
<label class='col-sm-2 control-label'>visiblity</label>
<div class='col-sm-12'>
    <div>
<input type='radio'  name='visiblity' value='0' <?php if($row['VISIBLITY'] == 0){echo 'checked';} ?> /> YES
</div>
<div>
<input type='radio'  name='visiblity' value='1' <?php if($row['VISIBLITY'] == 1){echo 'checked';} ?> /> NO
</div>
</div>
</div>


<div class='form-group'>
<label class='col-sm-2 control-label'>comments</label>
<div class='col-sm-12'>
    <div>
<input type='radio'  name='comments' value='0' <?php if($row['ALLOW_COMMENT'] == 0){echo 'checked';} ?> /> YES
</div>
<div>
<input type='radio'  name='comments' value='1' <?php if($row['ALLOW_COMMENT'] == 1){echo 'checked';} ?>  /> NO
</div>
</div>
</div>


<div class='form-group'>
<label class='col-sm-2 control-label'>ADS</label>
<div class='col-sm-12'>
    <div>
<input type='radio'  name='ads' value='0' <?php if($row['ALLOW_ADS'] == 0){echo 'checked';} ?>  /> YES
</div>
<div>
<input type='radio'  name='ads' value='1' <?php if($row['ALLOW_ADS'] == 1){echo 'checked';} ?>  /> NO
</div>
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

}elseif($do === 'update'){
    echo "<div class='container'>";
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        echo "<h1 class='text-center x23'>update page </h1>";
        $id = $_POST['catid'];
        $name = $_POST['catgname'];
    
        $desc = $_POST['desc'];
        $ordering = $_POST['ordering'];
        $visibility = $_POST['visiblity'];
        $comments = $_POST['comments'];
        $ads = $_POST['ads'];

/////////////////validate form
$arroferrors = array();
if(empty($name)){
$arroferrors[] = "name can not be empty" . "<br/>";
}

    if(empty($ordering)){
        $arroferrors[] = "fullname can not be empty" . "<br/>";
        }
      
            if(strlen($name) > 20){
                $arroferrors[] = "name can not be larger than 20" . "<br/>";
                }
    foreach($arroferrors as $key){
        echo $key;
    }
 ///////////////////
 if(empty($arroferrors)){
        $stmt = $db->prepare("UPDATE catagories SET NAME = ?,DESCRIPTION=?,ORDERING = ?,VISIBLITY=?,ALLOW_COMMENT = ?,ALLOW_ADS=? WHERE ID = ?");
        $stmt->execute(array($name,$desc,$ordering,$visibility,$comments,$ads,$id));
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
elseif($do === 'add'){
?>
<h1 class='text-center x23'>add categories</h1>
<div class='container'>
<form class='form-horizontal form-rows' action='categories.php?do=insert' method='POST'>
  
<div class='form-group'>
<label class='col-sm-2 control-label'>catgname</label>
<div class='col-sm-12'>
<input type='text' class='form-control  formjo5' name='catgname' autocomplete='off'  required='required' />
</div>
</div>

<div class='form-group'>
<label class='col-sm-2 control-label'>description</label>
<div class='col-sm-12'>
<input type='text' class='form-control' name='desc'  required='required'  />

</div>
</div>

<div class='form-group'>
<label class='col-sm-2 control-label'>ordering</label>
<div class='col-sm-12'>
<input type='number' class='form-control' name='ordering'  required='required'/>
</div>
</div>

<div class='form-group'>
<label class='col-sm-2 control-label'>parent?</label>
<div class='col-sm-12'>
 <select class='form-control' name='parent'>
     <option value='0'>NONE </option>
<?php
$cats = cat('WHERE parent = 0');
foreach($cats as $cat){
    echo "<option value = ". $cat['ID'] .">". $cat['NAME'] . "</option>";
}

?>
</select>
</div>
</div>


<div class='form-group'>
<label class='col-sm-2 control-label'>visiblity</label>
<div class='col-sm-12'>
    <div>
<input type='radio'  name='visiblity' value='0' checked/> YES
</div>
<div>
<input type='radio'  name='visiblity' value='1' /> NO
</div>
</div>
</div>


<div class='form-group'>
<label class='col-sm-2 control-label'>comments</label>
<div class='col-sm-12'>
    <div>
<input type='radio'  name='comments' value='0' checked/> YES
</div>
<div>
<input type='radio'  name='comments' value='1' /> NO
</div>
</div>
</div>


<div class='form-group'>
<label class='col-sm-2 control-label'>ADS</label>
<div class='col-sm-12'>
    <div>
<input type='radio'  name='ads' value='0' checked/> YES
</div>
<div>
<input type='radio'  name='ads' value='1' /> NO
</div>
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
    
        $name = $_POST['catgname'];
        $parent = $_POST['parent'];
      
        $desc = $_POST['desc'];
        $ordering = $_POST['ordering'];

        $visibility = $_POST['visiblity'];
        $ads = $_POST['ads'];
        $comments = $_POST['comments'];
      
/////////////////validate form
$arroferrors = array();
if(empty($name)){
$arroferrors[] = "name can not be empty" . "<br/>";
}
if(empty($desc)){
    $arroferrors[] = "email can not be empty" . "<br/>";
    }
    
      
    foreach($arroferrors as $key){
        echo $key;
    }
 ///////////////////
 if(empty($arroferrors)){
 $check = checkitems("NAME","catagories",$name);
    if($check == 0){
       

       $stmt = $db->prepare("INSERT INTO catagories(NAME,DESCRIPTION,parent,ORDERING,VISIBLITY,ALLOW_COMMENT,ALLOW_ADS) VALUES(:zuser,:zdesc,:zparent,:zorder,:zvis,:zcom,:zads)");
       $stmt->execute(array(
        "zuser" => $name,
        "zdesc" => $desc,
        "zparent" => $parent,
        "zorder" => $ordering,
        "zvis" =>   $visibility,
        "zcom" =>  $comments,
        "zads" =>  $ads 
       )); 
       echo "";
       $msg = "<div class='alert alert-success'> 1 row inserted</div>";
       errmsg($msg,"back");
    }else{
            
            $msg = "<div class='alert alert-danger'> categorey already excisted</div>";
            errmsg($msg,"back");
            
    }
 }
        
    }else{
        $msg = "<div class='alert alert-danger'> you are not authorized to go there</div>";
        errmsg($msg);
    }
    echo "</div>";
}
else{
    echo "you are not authorized to be here";
}
include "includes/templates/footer.php";
}else{
    echo "please leave";
}
ob_end_flush();






?>