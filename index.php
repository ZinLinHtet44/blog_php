<?php
session_start();
require 'config/config.php';
if(empty($_SESSION['user_id']) && empty($_SESSION['loged_in'])){
  header('Location: login.php');
}
 ?>
      <?php
      if(!empty($_GET['pageno'])){
        $pageno = $_GET['pageno'];
      }else{
        $pageno = 1;
      }
      $numberOfrec = 3;
      $offset = ($pageno-1)*$numberOfrec;

        $statement = $pdo->prepare("SELECT * FROM post ORDER BY id DESC");
        $statement->execute();
        $rawResult = $statement->fetchAll();
        $total_pages = ceil(count($rawResult)/$numberOfrec);

        $statement = $pdo->prepare("SELECT * FROM post ORDER BY id DESC LIMIT $offset,$numberOfrec");
        $statement->execute();
        $result = $statement->fetchAll();
      ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Widgets</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" >
  <!-- Navbar -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left:0px !important">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
          <h2 style="text-align:center"> BLOG SITE </h2>
      </div><!-- /.container-fluid -->
    </section>

        <section class='content'>
        <div class="row">
            <?php
              if($result){
              $i=1;
              foreach ($result as $value) {
            ?>
              <div class="col-md-4">
                <!-- Box Comment -->
                <div class="card card-widget">
                  <div class="card-header">
                    <h4 style="text-align:center"><?php echo $value['title'];?></h4>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">

                  <a href="blogdetails.php?id=<?php echo $value['id'];?>"> <img class="img-fluid pad" src="admin/images/<?php echo $value['image'];?>" style="width:500px;height : 300px" alt="Photo"> </a>
                  </div>
                  </div>
                </div>
                <?php
                  $i++;
                  }
                }
                 ?>



            <!-- /.card -->
          </div>
            <br/><br/>
          <nav aria-label="Page navigation example" style="float:right">
              <ul class="pagination">
              <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
              <li class="page-item <?php if($pageno <= 1){echo "disabled";} ?>">
                <a class="page-link" href="<?php if($pageno <= 1){ echo "#";}else{echo "?pageno=".($pageno-1);} ?>">Previous</a>
              </li>
              <li class="page-item"><a class="page-link" href="#"><?php echo "$pageno";?></a></li>
              <li class="page-item" <?php if($pageno >= $total_pages){echo "disabled";} ?>>
                <a class="page-link" href="<?php if($pageno >= $total_pages){ echo "#";}else{echo "?pageno=".($pageno+1);} ?>">Next</a>
              </li>
              <li class="page-item"><a class="page-link" href="?pageno=<?php echo "$total_pages";?>">Last</a></li>
              </ul>
           </nav>
        </div>


        <!-- /.row -->
      </div><!-- /.container-fluid -->
    <!-- /.content -->
  </section>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer" style="margin-left:0px !important">
    <!-- To the right -->
   <div class="float-right d-none d-sm-inline">
      <a href="logout.php" type="button" class="btn btn-default" name=""> Log Out </a>
      </tbody>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2020 <a href="https://adminlte.io">Zin Lin Htet</a>.</strong> All rights reserved.
  </footer>
  </div>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
