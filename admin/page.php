<?php
include 'init.php';
$do = '';
if(isset($_GET['do'])){
    $do = $_GET['do'];
}else{
    $do = 'manage';
}
if($do === 'manage'){
    echo "<h6>welcome to manage</h6>";
    echo "<a href='page.php?do=add'> add category </a>";
}elseif($do === 'add'){
    echo "welcome to add";
}
elseif($do === 'insert'){
    echo "welcome to insert";
}
else{
    echo"ERROR there is no page with such name";
}
include "includes/templates/footer.php";
?>