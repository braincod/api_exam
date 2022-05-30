
<!-- Bootstrap 4 CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">Dashboard</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
                    
                                        <!-- Admin menu -->
                            <?php   
                                /** 
                                * if user is an admin show them this navbar.
                                **/ 
                                if(isset($_SESSION['adminid']))
                                    {
                             ?>
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="reports.php">Reports</a>
      </li>      
      <li class="nav-item">
        <a class="nav-link" href="performance.php">Performance</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Profile
        </a>
       <!--- <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <!---  <a class="dropdown-item" href="changepassword.php"></a>
          <div class="dropdown-divider"></div>
          <!-- <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a> -->
        </div>
      </li>
      
    </ul>
    <form class="form-inline my-2 my-lg-0" action="../logout.php">
      <!-- <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search"> -->
      <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Log out </button>
    </form>
    
  </div>

  <!-- End admin Menu -->
  <?php } ?>
        
        <!--Teacher Menu-->
      <?php
                              /** 
                                * if user is a techer show them this navbar.
                                **/ 
                         //   if(isset($_SESSION['teacherid']))
                              // {
                                //   ?>

      <!---<li class="nav-item active">
        <a class="nav-link" href="view.php">Home <span class="sr-only">(current)</span></a>
      </li>
   <!---   <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="changepassword.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Profile
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="changepassword.php">Change password</a>
          <div class="dropdown-divider"></div>
          <!-- <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a> -->
        </div>
      </li>
      
    </ul>
  <!---  <form class="form-inline my-2 my-lg-0" action="../logout.php">
      <!-- <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search"> -->
   <!--   <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Log out </button>
    </form>
    
  </div>
                                <!-- end teacher memu -->
                              
</nav>
        