<?php
session_start();
require 'config/config.php';
if(empty($_SESSION['user_id']) && empty($_SESSION['loged_in'])){
  header('Location: login.php');
}
 ?>
<?php
  $stmt = $pdo->prepare("SELECT * FROM post WHERE id=".$_GET['id']);
  $stmt->execute();
  $result = $stmt->fetchAll();

  $blogId = $_GET['id'];

  $stmtcmt = $pdo->prepare("SELECT * FROM comment WHERE post_id=$blogId");
  $stmtcmt->execute();
  $resultcmt = $stmtcmt->fetchAll();
  //$authorId = $_SESSION['user_id'];
  $auResult = [];
  if ($resultcmt) {
    foreach ($resultcmt as $key => $value) {
      $authorId = $resultcmt[$key]['author_id'];
      $stmtau = $pdo->prepare("SELECT * FROM user WHERE id=$authorId");
      $stmtau->execute();
      $auResult[] = $stmtau->fetchAll();
    }
  }

 if($_POST){
  $comment = $_POST['comment'];
  $stmt = $pdo->prepare("INSERT INTO comment(content,author_id,post_id) VALUES (:comment,:author_id,:post_id)");
  $result = $stmt->execute(
     array (':comment'=>$comment,':author_id'=>$_SESSION['user_id'],':post_id'=>$blogId)
   );
   if($result){
     header('Location:blogdetails.php?id='.$_GET['id']);
   }
 }

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
<div class="">

  <!-- Content Wrapper. Contains page content -->
  <div class="">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2" style="text-align:center">
          <div class="col-sm-12">
            <h1>Welcome To Details Page</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


        <div class="row">
          <div class="col-md-12">
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-header" style="text-align:center">
                <h4><?php echo $result[0]['title'];?></h4>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <img class="img-fluid pad" src="admin/images/<?php echo $result[0]['image'];?>" style="width:600px;height:300px;margin-left:330px" alt="Photo">
                <br/><br/>
                <p><?php echo $result[0]['content'];?></p>
                <h3>Comment</h3>
                <hr/>
              </div>
              <!-- /.card-body -->
              <div class="card-footer card-comments">
                <div class="card-comment">
                  <!-- User image -->
                <?php if($resultcmt){?>
                  <div class="comment-text" style="margin-left:0px !important">
                    <?php foreach ($resultcmt as $key => $value) {?>

                      <span class="username">
                        <?php echo $auResult[$key][0]['name'];?>
                        <span class="text-muted float-right"><?php echo $value['created_at'];?></span>
                      </span><!-- /.username -->
                          <?php echo $value['content'];?>
                  <?php
                    }
                    ?>
                  </div>
                <?php
                }
                ?>
                  <!-- /.comment-text -->
                  <div class="card-footer">
                    <form action="" method="post">
                      <div class="img-push">
                        <input type="text" name="comment" class="form-control form-control-sm" placeholder="Press enter to post comment">
                      </div>
                    </form>
                  </div>
                </div>
                <!-- /.card-comment -->
                  <!-- /.comment-text -->
                </div>
                <!-- /.card-comment -->
              </div>

              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer" style="margin-left:0px !important">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      <a href="index.php" type="button" class="btn btn-default" name=""> Cancle </a>
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
