<?php
  session_start();
  require('../config/config.php');
  if(empty($_SESSION['user_id']) && empty($_SESSION['loged_in'])){
    header('Location: login.php');
  }
  if($_SESSION['role']!= 1){
    header('Location: login.php');
  }

  if($_POST){
    if($_POST){
      $file='images/'.($_FILES['pic']['name']);
      // Select file type
      $imgType = pathinfo($file,PATHINFO_EXTENSION);
      if($imgType != 'png' && $imgType != 'jpeg' && $imgType != 'jpg'){
        echo "<script>alert('Image Type must be Png or Jpg or Jpeg')</script>";
      }else{
          $image = $_FILES['pic']['name'];
          $title = $_POST['title'];
          $content = $_POST['content'];
          move_uploaded_file($_FILES['pic']['tmp_name'],$file);
          $stmt = $pdo->prepare("INSERT INTO post(title,content,image) VALUES (:title,:content,:image)");
          $result = $stmt->execute(
             array (':title'=>$title,':content'=>$content,':image'=>$image)
           );
         if($result){
           echo "<script>alert('Value is added');window.location.href='index.php';</script>";
         }
      }
    }
    }
 ?>

<?php include('header.php');?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
              <form class="" action="add.php" method="POST" enctype="multipart/form-data">
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group">
                      <label for='title'>Title</label>
                      <input type="title" class="form-control" name="title" required>
                      <label for='content'>Content</label>
                      <textarea class="form-control" name="content" rows="6" cols="80" required> </textarea><br/>
                      <label for='inputfile'>Select File</label>
                      <input type="file" name="pic" required>
                      <div class="form-group">
                      <input type="submit" class="btn btn-success" value="SUBMIT"/>
                      <a href="index.php" class="btn btn-primary">Cancel</a>
                      </div>
                    </div>
                </div>
              </form>
              </div>
            </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
  </div>
    <!-- /.content -->
  </div>
</div>
  <!-- /.content-wrapper -->

<?php
  include('footer.html');
?>
