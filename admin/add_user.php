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
   if($_POST){
     $name = $_POST['name'];
     $password = $_POST['password'];
     $email = $_POST['email'];


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
     $stmt = $pdo->prepare("INSERT into user(name,email,password,role) VALUES (:name,:email,:password,:role)");
     $result = $stmt->execute(
       array(':name' => $name , ':email' => $email , ':password' => $password,':role'=>$admin)
     );
     if($result){
       echo "<script>alert('Sucessfuly Added');window.location.href='user_info.php';</script>";
     }
   }

   }
 ?>
<?php include('header.php');?>
    <!-- Main content -->
          <div class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body login-card-body">
                      <p class="login-box-msg">Add New User</p>

                      <form action="" method="post">
                        <div class="input-group mb-3">
                          <input  name="name" type="text" class="form-control" placeholder="Name">
                          <div class="input-group-append">
                            <div class="input-group-text">
                              <span class="fas fa-envelope"></span>
                            </div>
                          </div>
                        </div>
                        <div class="input-group mb-3">
                          <input  name="email" type="email" class="form-control" placeholder="Email">
                          <div class="input-group-append">
                            <div class="input-group-text">
                              <span class="fas fa-envelope"></span>
                            </div>
                          </div>
                        </div>
                        <div class="input-group mb-3">
                          <input name="password" type="password" class="form-control" placeholder="Password">
                          <div class="input-group-append">
                            <div class="input-group-text">
                              <span class="fas fa-lock"></span>
                            </div>
                          </div>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="checkbox" name="check" class="form-check-input" value="1"><b>Admin:User</b>
                          </label>
                        </div><br/>
                          <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">Add</button>
                                <a href="user_info.php" class="btn btn-default btn-block">Cancle</a>
                            </div>
                          </div>
                        </div>
                      </form>
                  </div>
                </div>
              </div>
            </div>
          </div>

<?php
  include('footer.html');
 ?>
