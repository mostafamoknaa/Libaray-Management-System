<?php
include('/partials/nav.php');
    // include Connection
  include('connection.php');
  session_start();
?>
<div class="container" style="min-height: 85.3vh;">
    <?php
     if(!isset($_SESSION['User_ID']) || $_SESSION['User_ID'] == 'Student')
        {
          header('Location: logOut.php');
        }
    ?>
    <form class="needs-validation" method="post" novalidate>
        <div class="row">
            <?php 
                $result = $conn->query("select * from student_details;");
                while($row=$result->fetch_assoc()){
                        $id = $row["Student_Id"];
                        $name = $row["Student_Name"];
                        $Gender = $row["Student_Gender"];
                        $Tax = $row["Student_Tax"];
                        ?>
            <div class="col-sm-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $name ?></h5>
                        <p name="Student_Id">Student ID: <?php echo $id; ?></p>
                        <p name="Gender">Gender: <?php echo $Gender; ?></p>
                    </div>
                </div>
                <div class="card-footer">
                    <small class="text-muted">Tax: <?php echo $Tax ?></small>
                </div>
            </div>
            <?php } ?>
        </div>
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
