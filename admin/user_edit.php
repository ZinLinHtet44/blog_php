    <?php
      session_start();
      require('../config/config.php');
      if(empty($_SESSION['user_id']) && empty($_SESSION['loged_in'])){
        header('Location: login.php');
      }
      if($_SESSION['role']!= 1){
        header('Location: login.php');
      }
     ?>
    <?php

      $statement = $pdo->prepare("SELECT * FROM user WHERE id=".$_GET['id']);
      $statement->execute();
      $result = $statement->fetchAll();

   if($_POST){
      $email = $_POST['email'];
      $password = $_POST['password'];
      $name = $_POST['name'];
      $id = $_POST['id'];

      if(!empty($_POST['check'])){
        $admin = 1;
      }else {
        $admin =0;
      }

      $stmt = $pdo->prepare("SELECT * FROM user WHERE email=:email");
      $stmt->bindValue(':email',$email);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if($user){
        echo "<script>alert('Already Exit')</script>";
      }else{
        $stmt = $pdo->prepare("UPDATE user SET name='$name',email='$email',password='$password',role='$admin' WHERE id='$id'");
        $result =   $stmt->execute();
        if($result){
          echo "<script>alert('Edit User Successful');window.location.href='user_info.php';</script>";
        }
      }
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
                    <h3 class="card-title">User Edit</h3>
                  </div>

                  <div class="card-body login-card-body">
                    <p class="login-box-msg">Edit User</p>

                    <form action="" method="post">
                      <div class="input-group mb-3">
                        <input  name="name" type="text" class="form-control" value="<?php echo $result[0]['name'];?>">
                        <div class="input-group-append">
                          <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                          </div>
                        </div>
                      </div>
                      <div class="input-group mb-3">
                        <input  name="email" type="email" class="form-control" value="<?php echo $result[0]['email'];?>">
                        <div class="input-group-append">
                          <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                          </div>
                        </div>
                      </div>
                      <div class="input-group mb-3">
                        <input name="password" type="password" class="form-control" value="<?php echo $result[0]['password'];?>">
                        <div class="input-group-append">
                          <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                          </div>
                        </div>
                      </div>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="checkbox" name="check" class="form-check-input" value="1" <?php echo $result[0]['role']==1 ? 'checked':'';?>><b>Admin:User</b>
                        </label>
                      </div><br/>
                      <div>
                        <input type="hidden" name="id" value="<?php echo $result[0]['id'];?>"/>
                      </div>
                        <div class="row">
                          <div class="col-12">
                              <button type="submit" class="btn btn-primary btn-block">Edit</button>
                              <a href="user_info.php" class="btn btn-default btn-block">Cancle</a>
                          </div>
                        </div>
                      </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
<?php
include('footer.html');
?>
