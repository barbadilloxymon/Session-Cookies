<?php
session_start();
require 'dbcon.php';

// Delete user functionality
if(isset($_POST['delete_user'])) {
    $contact_id = $_POST['delete_user'];
    
    // Using prepared statements to prevent SQL injection
    $stmt = $con->prepare("DELETE FROM contact WHERE contact_id = ?");
    $stmt->bind_param("i", $contact_id);
    if($stmt->execute()) {
        $_SESSION['success'] = "User deleted successfully";
    } else {
        $_SESSION['error'] = "Failed to delete user";
    }
    $stmt->close();
}

// Check if logout button is clicked
if(isset($_POST["logout"])){
    session_unset();
    session_destroy();
    header("Location: http://localhost/Elias%20resort/Admin/");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Information</title>
    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    
<div class="sidebar">
    <div class="logo">
        <ul class="menu">
            <li class="active">
                <a href="../Dashboard/dashb.php">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- <li>
            <a href="../Users/dashb.php">
                <i class="fas fa-user"></i>
                <span>User</span>
            </a>
            </li> -->

            <li>
            <a href="../Registration/registration.php">
                <i class="fas fa-users"></i>
                <span>Client</span>
            </a>
            </li>

            <li>
            <a href="contact.php">
                <i class="fas fa-address-book"></i>
                <span>Contact</span>
            </a>
            </li>

            <li class="logout">
            <form action="" method="POST">
            <input type="hidden" name="logout" value="true" >
             <button type="submit" name="logout" style="color:white; border: none; background: none; cursor: pointer;" onclick="confirmLogout()">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
             </button>
             </form>
            </li>
        </ul>
    </div>
</div>

<!-- Content -->

<div class="main--content">
    <div class="header--wrapper">
        <div class="header--title">
            <span>Primary</span>
            <h2>Contact-Info</h2>
        </div>
        <div class="user--info">
            <div class="search--box">
                <i class="fa-solid fa-search"></i>
                <input type="text" placeholder="Search here..."> 
            </div>
            <img src="../Login-form/img/avatar.svg" alt="">
        </div>
    </div>


    <div class="container mt-4">
        
        <?php include('message.php'); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Manage Contact
                            <a href="add-user.php" class="btn btn-primary float-end">Add New</a>
                        </h3>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>Email</th>
                                    <th>Phone No.</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $query = "SELECT * FROM contact";
                                $query_run = mysqli_query($con, $query);

                                if(mysqli_num_rows($query_run) > 0)
                                {
                                    while($contact = mysqli_fetch_assoc($query_run)) // Fetch rows from the result resource
                                    {
                                ?>
                                <tr>
                                    <td><?= $contact['contact_id']; ?></td>
                                    <td><?= $contact['firstName']; ?></td>
                                    <td><?= $contact['lastName']; ?></td>
                                    <td><?= $contact['email']; ?></td>
                                    <td><?= $contact['phone']; ?></td>
                                    <td>

                                        <a href="edit-user.php?contact_id=<?= $contact['contact_id']; ?>" class="btn btn-primary">Edit</a>
                                        <form action="" method="POST" class="d-inline">
                                            <input type="hidden" name="delete_user" value="<?= $contact['contact_id']; ?>">
                                            <button type="submit" name="delete_user_submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php
                                    }
                                }
                                else
                                {
                                    echo "<h5> No Record Found </h5>";
                                }
                                ?>

                            </tbody>
                        </table> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="hOver.js"></script>
<script>
    function confirmLogout() {
        if (confirm("Are you sure you want to logout?")) {
            window.location.href = "http://localhost/Elias%20resort/Admin/";
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

