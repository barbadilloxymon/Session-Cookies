<?php
session_start();
require 'dbcon.php';

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Edit User Details</title>
</head>
<body>
<div class="container mt-5">
    <?php include('message.php'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit User Details 
                        <a href="contact.php" class="btn btn-danger float-end">BACK</a>
                    </h4>
                </div>
                <div class="card-body">
                    <?php 
                    if(isset($_GET['contact_id']))
                    {
                        $info_id = mysqli_real_escape_string($con, $_GET['contact_id']);
                        $query = "SELECT * FROM contact WHERE contact_id='$info_id'";
                        $query_run = mysqli_query($con, $query);

                        if(mysqli_num_rows($query_run) > 0)
                        {
                            $information = mysqli_fetch_assoc($query_run);
                            ?>
                            <form action="code.php" method="POST">
                                <input type="hidden" name="info_id" value="<?= $information['contact_id']; ?>">
                                <div class="mb-3">
                                    <label>First Name</label>
                                    <input type="text" name="firstName" value="<?= $information['firstName']; ?>" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Last Name</label>
                                    <input type="text" name="lastName" value="<?= $information['lastName']; ?>" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="text" name="email" value="<?= $information['email']; ?>" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Phone</label>
                                    <input type="text" name="phone" value="<?= $information['phone']; ?>" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <button type="submit" name="update_user" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                            <?php
                        }
                        else
                        {
                            echo "<h4>No Such User ID Found</h4>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
