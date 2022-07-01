<?php
include('/partials/nav.php');
    // include Connection
  include('connection.php');
  session_start();
    
  // Errors array
    $errors = ['user'=>'',
              'pass'=>''];
  // check if form submit
    if(isset($_POST['submit'])){
    // store values ass String
      $user = mysqli_real_escape_string($conn,$_POST['user']);
      $pass = mysqli_real_escape_string($conn,$_POST['pass']);
    // check if inputs empty 
      if(empty($user)){
        $errors['user'] = "Enter your user Id";
      }
      if(empty($pass)){
        $errors['pass'] = "Enter your Password";
      }
    // check if no errors and create query
      if(!array_filter($errors)){
        $st = "SELECT * from Student_Details";
        $ma ="SELECT * from Manger_Details";
        $stresult = mysqli_query($conn,$st);
        $maresult = mysqli_query($conn,$ma);
        if( $stresult && $maresult){
          
          $users = mysqli_fetch_all($stresult,MYSQLI_ASSOC);
          $manegars = mysqli_fetch_all($maresult,MYSQLI_ASSOC);
          $go = 0;
          foreach($users as $std){
              if($std['Student_Id'] === $user && $std['Student_Password'] === $pass){
                $_SESSION['User_ID']=$std['Student_Id'];
                $_SESSION['User_Name']=$std['Student_Name'];
                $_SESSION['User_Type']='Student';
                $_SESSION['Student_Tax']= $std['Student_Tax'];
                  header("Location:home.php");
                  $go = 1;
              }
            }
          foreach($manegars as $manegar){
              if($manegar['Manger_Id'] === $user && $manegar['Manger_Password'] === $pass){
                $_SESSION['User_ID']=$manegar['Manger_Id'];
                $_SESSION['User_Name']=$manegar['Manger_Name'];
                $_SESSION['User_Type']='Manger';
                header("Location:home.php");
                $go = 1;
              }
            }
        }
        else{
          echo 'Error: '. mysqli_error($conn);
        }
        if(!$go){
          echo "<div class='container alert alert-danger alert-dismissible fade show' role='alert'>Id or password aren't correct, Please enter valid data</div>";
        }
      }
    }  
?>
<div class="container" style="min-height: 85.3vh;">
    <?php
     if(isset($_SESSION['User_ID']))
        {
          header('Location: home.php');
        }
    ?>
    <form class="needs-validation" method="post" novalidate>
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="validationCustom01">User Id</label>
                <input type="text" name="user" class="form-control" id="validationCustom01" placeholder="User Id"
                    required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please Enter a valid User Id.
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <label for="validationCustom02">Password</label>
                <input type="password" name="pass" class="form-control" id="validationCustom02" placeholder="Password"
                    required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please enter your password.
                </div>
            </div>
        </div>
        <input class="btn btn-primary" type="submit" value="Sign In" name="submit">

    </form>

    <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
    </script>
</div>
<?php 
    include('/partials/footer.php')
?>
