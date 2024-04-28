<?php
session_start();
require 'dbcon.php';

if(isset($_POST['delete_user']))
{
    $contact_id = mysqli_real_escape_string($con, $_POST['delete_user']);

    $query = "DELETE FROM contact WHERE id='$contact_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "User Deleted Successfully";
        header("Location: dashb.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "User Not Deleted";
        header("Location: dashb.php");
        exit(0);
    }
}

if(isset($_POST['update_user']))
{
    $signup_id = mysqli_real_escape_string($con, $_POST['signup_id']);

    $name = mysqli_real_escape_string($con, $_POST['signup_username']);
    $email = mysqli_real_escape_string($con, $_POST['signup_email']);
    

    $query = "UPDATE signup SET name='$signup_username', email='$signup_email' WHERE id='$signup_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "User Updated Successfully";
        header("Location: dash.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "User Not Updated";
        header("Location: dashb.php");
        exit(0);
    }

}


if(isset($_POST['save_user']))
{
    $signup_username= mysqli_real_escape_string($con, $_POST['signup_username']);
    $signup_email= mysqli_real_escape_string($con, $_POST['signup_email']);

    $query = "INSERT INTO signup (signup_username,signup_email) VALUES ('$signup_username','$signup_email')";

    $query_run = mysqli_query($con, $query);
    if($query_run)
    {
        $_SESSION['message'] = "New User Created Successfully";
        header("Location: add-user.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "User Not Created";
        header("Location: add-user.php");
        exit(0);
    }
}

?>