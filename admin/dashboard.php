
<?php
ob_start();
session_start();
$pagetitle = 'dashboard';
if(isset($_SESSION['username'])){
   include 'init.php';
 


   ?>
        <!-- start dashboard design -->
        <div class="container home-stats">

        <h1 class='text-center'> dashboard </h1>

        <div class="row">
            <div class="col-md-3">
                <div class="stat" style="background-color:#ff6b6b">
                    total members
                    <span><a href='members.php'><?php echo calculateitems('userid','shop') ?></a></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat" style="background-color:#f368e0">
                   pending members
                   <span><a href='members.php?do=manage&page=pending'><?php echo calculateitems('userid','shop',"WHERE regstatus = 0") ?></a></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat" style="background-color:#10ac84">
                    total items
                    <span>
                    <a href='items.php'><?php echo calculateitems('itemid','item') ?></a>
                    </span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat" style="background-color:#341f97">
                    total comments
                    <span>
                    <a href='comments.php'><?php echo calculateitems('c_id','comments') ?></a>
                    </span>
                </div>
            </div>
        </div>
</div>

<div class="container latest mt-5">
    <div class="row">
        <div class="col-md-6">
<div class="card">
    <div class="card-heading bg-dark py-3 text-white">
        latest registerd users
    </div>
    <div class="card-body">
      <?php

$thelatest = getlatest('*','shop','date',5);
foreach ($thelatest as $item ) {
    echo "<ul class='list-unstyled'>";
   echo "<li>" .$item['username'] ."<span class='py-1 px-2 ml-2 bg-success text-white float-right' style='cursor:pointer'>";
   echo '<a class="text-white" href="members.php?do=edit&userid=' . $item["userid"] . '"> edit </a>';
    echo  "</span>";
    if($item['regstatus'] == 0){
        echo '<a href="members.php?do=activate&userid='. $item['userid'].'" class="btn btn-info float-right">Activate</a>';
    }
    echo  "</li>";
   echo "</ul>";
}
?>
    </div>
</div>
        </div>
        <div class="col-md-6">
        <div class="card">
    <div class="card-heading bg-dark py-3 text-white">
        latest items
    </div>
    <div class="card-body">
    <?php

$thelatest = getlatest('*','item','adddate',5);
foreach ($thelatest as $item ) {
    echo "<ul class='list-unstyled'>";
   echo "<li>" .$item['name'] ."<span class='py-1 px-2 ml-2 bg-success text-white float-right' style='cursor:pointer'>";
   echo '<a class="text-white" href="items.php?do=edit&id=' . $item["itemid"] . '"> edit </a>';
    echo  "</span>";
    if($item['approve'] == 0){
        echo '<a href="items.php?do=approve&id='. $item['itemid'].'" class="btn btn-info float-right">Activate</a>';
    }
    echo  "</li>";
   echo "</ul>";
}
?>
    </div>
</div>
        </div>
        
    </div>
</div>
   <?php
   
include "includes/templates/footer.php";



}else{
    header("Location:index.php");
    exit();
}
ob_end_flush();

?>

