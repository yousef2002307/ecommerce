<!DOCTYPE html>
<html>
<head>
<title><?php getTitle() ?></title>
<meta charset='UTF-8' />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
    integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
    integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
   
  <link rel="stylesheet" href="layout/css/style.css" type='text/css'/>
  
</head>
<body>

<?php

if(!isset($_SESSION['name'])){
?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="login.php">login</a></li>
    <li class="breadcrumb-item signup3"><a href="login.php">signup</a></li>
    <li class="breadcrumb-item active" aria-current="page">Data</li>
  </ol>
</nav>
<?php 
}else{
  ?>
  <div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  <?php echo "welcome" . $sessionname  ?>
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="profile.php">your profile</a>
    <a class="dropdown-item" href="newad.php">new ad</a>
    <a class="dropdown-item" href="logout.php">log out</a>
  </div>
</div>
 
 



<?php
$status =  checkmemberstatus($_SESSION['name']);
if($status == 1){
  echo "your membersip need to be activated by admin";
}
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php"><?php echo lang('home') ?> </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <?php
  foreach(cat('WHERE parent = 0') as $cat2 ){
    echo "<li class='nav-item'><a href='catagories.php?pageid=". $cat2['ID'] ."&pagename=". str_replace(" ","-",$cat2['NAME']) ."' class='nav-link'>" . $cat2['NAME'] . "</a></li>";
  }

  ?>

    </ul>
    
  </div>
</nav>










