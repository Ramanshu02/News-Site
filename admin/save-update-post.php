<?php
include "config.php";

if(empty($_FILES['new-image']['name'])) {
    $image_name = $_POST['old-image'];
} else {
    $errors = array();

    $file_name = $_FILES['new-image']['name'];
    $file_size = $_FILES['new-image']['size'];
    $file_tmp = $_FILES['new-image']['tmp_name'];
    
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $extensions = array("jpeg","jpg","png");

    if(!in_array($file_ext,$extensions)) {
        $errors[] = "This extension file is not allowed, Please choose a JPG or PNG file.";
    }

    if($file_size > 2097152)  {
        $errors[] = "File size must be 2 MB or lower";
    }

    $new_name = time(). "-" .basename($file_name);
    $target = "upload/".$new_name;
    $image_name = $new_name;

    if(empty($errors)) {
        move_uploaded_file($file_tmp, $target);
    } else {
        print_r($errors);
        die();
    }
}

// escape user inputs
$title = mysqli_real_escape_string($conn, $_POST['post_title']);
$description = mysqli_real_escape_string($conn, $_POST['postdesc']);
$category = mysqli_real_escape_string($conn, $_POST['category']);
$post_id = $_POST['post_id'];

// main update query
$sql = "UPDATE post SET title='{$title}', description='{$description}', category={$category}, post_img='{$image_name}'
WHERE post_id={$post_id};";

// category count adjustment if category changed
if ($_POST['old_category'] !=  $_POST['category']) {
    $sql .= "UPDATE category SET post = post - 1 WHERE category_id = {$_POST['old_category']} ;";
    $sql .= "UPDATE category SET post = post + 1 WHERE category_id = {$_POST['category']} ;";
}

$result = mysqli_multi_query($conn, $sql);

if($result) {
    header("location: {$hostname}/admin/post.php");
} else {
    echo "Query Failed.";
}
?>