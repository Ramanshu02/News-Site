<?php
include "config.php";

if(empty($_FILES['logo']['name'])){
    $file_name = $_POST['old_logo'];
}else{
    $errors = array();
    $file_name = $_FILES['logo']['name'];
    $file_size = $_FILES['logo']['size'];
    $file_tmp = $_FILES['logo']['tmp_name'];  
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $extensions = array("jpeg","jpg","png");

    if(!in_array($file_ext,$extensions)){
        $errors[] = "This extension file not allowed, Please choose a JPG or PNG file.";
    }
    if($file_size > 2097152){
        $errors[] = "File size must be 2mb or lower.";
    }

    if(empty($errors)){
        $new_file_name = uniqid("logo_", true) . "." . $file_ext;
        move_uploaded_file($file_tmp, "images/" . $new_file_name);
        $file_name = $new_file_name;
    }else{
        foreach ($errors as $err) {
            echo "<p style='color:red;'>$err</p>";
        }
        die();
    }
}

$website_name = mysqli_real_escape_string($conn, $_POST['website_name']);
$footer_desc  = mysqli_real_escape_string($conn, $_POST['footer_desc']);

$sql = "UPDATE settings SET websitename='{$website_name}', logo='{$file_name}', footerdesc='{$footer_desc}'";
$result = mysqli_query($conn, $sql);

if($result){
  header("location: {$hostname}/admin/post.php");
}else{
  echo "Query Failed";
}

?>
