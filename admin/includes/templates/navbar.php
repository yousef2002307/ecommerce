<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="dashboard.php"><?php echo lang('home') ?> </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="categories.php"><?php echo lang('catg') ?> <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="members.php"><?php echo lang('items') ?> </a>
      </li>
      <li class="nav-item ">
        <a class="nav-link " href="items.php">
        items
        </a>
      
      </li>
      <li class="nav-item">
        <a class="nav-link" href="comments.php">comments</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         osama
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="members.php?do=edit&userid=<?php echo $_SESSION['id'] ?>">edit profile</a>
          <a class="dropdown-item" href="../index.php" target="_blank">visit shop</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php">log out</a>
        </div>
      </li>
    </ul>
    
  </div>
</nav>











