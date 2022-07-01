<?php

    include('connection.php');
    include('/partials/nav.php');
    session_start();
  // check if form submit
    if(isset($_POST['borrow'])){
         // store values ass String
        $ins = "INSERT into borrower_details(Book_Id,Student_id)values('$Book_id','".$_SESSION['User_ID']."');";
    // add query to connection and check 
        if(mysqli_query($conn,$ins)){
           $_SESSION['Borrower_ID']= $Book_id;
          echo "<div class='container alert alert-success alert-dismissible fade show' role='alert'>Book borrowed successfully</div>";
        }else{
            echo 'Error: '. mysqli_error($conn);
        }
        header('REFRESH:1;URL=home.php');
    }
    if(isset($_POST['return'])){
         $del="Delete from borrower_details where Borrower_Id= '".$_SESSION['Borrower_ID']."';";
        if(mysqli_query($conn,$del)){
            echo "<div class='container alert alert-success alert-dismissible fade show' role='alert'>Book returned successfully</div>";
        //  header('Location:home.php');
        }
        unset($_SESSION['Book_ID_Borrowed']);
        unset($_SESSION['Borrower_ID']);
        header('REFRESH:1;URL=home.php');
    }
?>
<div class="container" style="min-height: 85.3vh;">
    <?php
     if(!isset($_SESSION['User_ID']))
        {
          header('Location: logOut.php');
        }
    ?>
    <form class="needs-validation" method="post" novalidate>
        <div class="row">
            <?php 
                $result = $conn->query("select * from book_details where Book_id = '".$_SESSION['Search_Book']."' or Book_name= '".$_SESSION['Search_Book']."' or Author_name = '".$_SESSION['Search_Book']."' or Category_name = '".$_SESSION['Search_Book']."';");
                while($row=$result->fetch_assoc()){
                        $id = $row["Book_id"];
                        $name = $row["Book_name"];
                        $auth = $row["Author_name"];
                        $BookNumActual = $row["No_Copies_Actual"];
                        $BookNum = $row["No_Copies_Current"];
                        $Category_name= $row["Category_name"];
                        ?>
            <div class="col-sm-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $name ?></h5>
                        <p name="Book_id">Book ID: <?php echo $id; ?></p>
                        <p name="Category">Category: <?php echo $Category_name; ?></p>
                        <p name="Number_of_books">Number of books: <?php echo $BookNum; ?></p>
                        <?php
                            if($_SESSION['User_Type']==='Student')
                            {
                                if($BookNum != 0 && !isset($_SESSION['Borrower_ID']))
                                {
                                     echo'<button class="btn btn-success" type="submit" name="borrow" value="'; echo $id; echo '"
                                        style="float: right;">Borrow</button>';
                                }
                                 else
                                {
                                    if(isset($_SESSION['Borrower_ID']) && $_SESSION['Book_ID_Borrowed'] == $id)
                                    {
                                         echo'<button class="btn btn-success" type="submit" name="return" value="'; echo $id; echo '"
                                        style="float: right;">Return</button>';
                                    }
                                    else
                                    {
                                         echo'<button class="btn btn-danger" type="submit" name="borrow" value="'; echo $id; echo '"
                                         style="float: right;" disabled>Borrow</button>';
                                    }
                                   
                                }
                            }
                        ?>


                    </div>
                </div>
                <div class="card-footer">
                    <small class="text-muted">Author: <?php echo $auth ?></small>
                </div>
            </div>
            <?php } ?>
        </div>
    </form>
</div>
<?php 
        include('/partials/footer.php')
    ?>
