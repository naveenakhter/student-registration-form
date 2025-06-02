<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete image file
    $getImg = $conn->query("SELECT image FROM students WHERE id=$id")->fetch_assoc();
    if ($getImg) {
        unlink("images/" . $getImg['image']);
    }

    $conn->query("DELETE FROM students WHERE id=$id");
    header('Location: view.php');  // Stay on view page after delete
}
?>