  <?php
    session_start();
    require('../config/config.php');
    if(empty($_SESSION['user_id']) && empty($_SESSION['loged_in'])){
      header('Location: login.php');
    }
    if($_SESSION['role']!= 1){
      header('Location: login.php');
    }

    if(!empty($_POST['search'])){
      setcookie('search',$_POST['search'],time()+(8600*30),"/");
    }else{
      if(empty($_GET['pageno'])){
        unset($_COOKIE['search']);
        setcookie('search',null,-1,'/');
      }
    }
   ?>
  <?php
  if(!empty($_GET['pageno'])){
    $pageno = $_GET['pageno'];
  }else{
    $pageno = 1;
  }
  $numberOfrec = 2;
  $offset = ($pageno-1)*$numberOfrec;

  if(empty($_POST['search']) && empty($_COOKIE['search'])){
    $statement = $pdo->prepare("SELECT * FROM user ORDER BY id DESC");
    $statement->execute();
    $rawResult = $statement->fetchAll();
    $total_pages = ceil(count($rawResult)/$numberOfrec);

    $statement = $pdo->prepare("SELECT * FROM user ORDER BY id DESC LIMIT $offset,$numberOfrec");
    $statement->execute();
    $result = $statement->fetchAll();

  }else{
    $searchKey = !empty($_POST['search']) ? $_POST['search'] : $_COOKIE['search'];
    $statement = $pdo->prepare("SELECT * FROM user WHERE name LIKE '%$searchKey%' ORDER BY id DESC");
    $statement->execute();
    $rawResult = $statement->fetchAll();
    $total_pages = ceil(count($rawResult)/$numberOfrec);

    $statement = $pdo->prepare("SELECT * FROM user WHERE name LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numberOfrec");
    $statement->execute();
    $result = $statement->fetchAll();
  }
  ?>
 <?php include('header.php')?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">

              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">User Information</h3>
                </div>

                <!-- /.card-header -->
                <div class="card-body">
                  <a class="btn btn-success" type="submit" name="edit" href="add_user.php">Add New User</a><br/><br/>
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 10px">ID</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th style="width: 40px">Button</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                          $i=1;
                          foreach ($result as $value) {
                        ?>

                       <tr>
                       <td><?php echo $i;?></td>
                       <td><?php echo $value['name'];?></td>
                       <td><?php echo $value['email'];?></td>
                       <td><?php echo $value['role'];?></td>
                       <td>
                       <div class="btn-group">
                       <div class="container">
                         <a class="btn btn-warning" type="submit" name="edit" href="user_edit.php?id=<?php echo $value['id'];?>"">Edit</a>
                       </div>
                       <div class="container">
                         <a class="btn btn-danger" type="submit" name="delete"
                         onclick="return confirm('Delete?')"
                         href="user_delete.php?id=<?php echo $value['id'];?>">Delete</a>
                       </div>
                       </div>
                       </td>
                      </tr>
                      <?php
                        $i++;
                        }
                     ?>
                    </tbody>
                  </table><br/><br/>
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

                    </div>
                    <!-- /.row -->
                    </div><!-- /.container-fluid -->
                    </div>
                      <!-- /.content -->
              </div>
            </div>
          </div>

<?php
  include('footer.html');
 ?>
