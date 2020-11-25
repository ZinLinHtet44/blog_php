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
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

      if($_FILES['pic']['name'] != null){
        $file='images/'.($_FILES['pic']['name']);
        $imgType = pathinfo($file,PATHINFO_EXTENSION);

        if($imgType != 'png' && $imgType != 'jpeg' && $imgType != 'jpg'){
          echo "<script>alert('Image Type must be Png or Jpg or Jpeg')</script>";
        }else{
            $image = $_FILES['pic']['name'];
            move_uploaded_file($_FILES['pic']['tmp_name'],$file);

            $stmt = $pdo->prepare("UPDATE post SET title='$title',content='$content',image='$image' WHERE id=".$id);
            $result = $stmt->execute();
           if($result){
             echo "<script>alert('Value is Updated');window.location.href='index.php';</script>";
           }
        }
      }else {
        $stmt = $pdo->prepare("UPDATE post SET title='$title',content='$content' WHERE id=".$id);
        $result = $stmt->execute();
       if($result){
         echo "<script>alert('Value is Updated');window.location.href='index.php';</script>";
       }
      }
    }



$statement = $pdo->prepare("SELECT * FROM post WHERE id=".$_GET['id']);
$statement->execute();
$result = $statement->fetchAll();

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
              <form  action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $result[0]['id'];?>"/>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group">
                      <label for='title'>Title</label>
                      <input type="title" class="form-control" name="title" required value="<?php echo $result[0]['title'];?>">
                      <label for='content'>Content</label>
                      <textarea class="form-control" name="content" rows="6" cols="80" required><?php echo $result[0]['content'];?></textarea><br/>

                      <div class="form-group">
                      <img src="images/<?php echo $result[0]['image'];?>" width="120" height="100"/>
                      <label for='inputfile'>Select File</label>
                      <input type="file" name="pic">
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
