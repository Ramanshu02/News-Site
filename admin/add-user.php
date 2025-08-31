<?php include "header.php";

if($_SESSION["user_role"] == '0')  {
    header("Location: {$hostname}/admin/post.php");
}

if(isset($_POST['save'])) {                                         //check if the form was submitted using the 'save' button
    
    include "config.php";                                           //includes the config file that connects to the database

    $fname = mysqli_real_escape_string($conn, $_POST['fname']);     //handle user input (First Name) safely for SQL Queries
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $user = mysqli_real_escape_string($conn, $_POST['user']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); //convert the plain password into hashed string
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $sql = "SELECT username FROM user WHERE username = '{$user}'";  //SQL query to search if the entered username already exists in the database 
    $result = mysqli_query($conn, $sql) or die("Query Failed.");    //run the SQL query and if it fails then display an error message

    if(mysqli_num_rows($result)>0) {                                //function to check how many rows were returned by the query
        echo "<p style='color:red;text-align:center;margin:10px 0;'>Username already exists!</p>";   //display error message if username already exists
    } 
    else{
        $sql1 = "INSERT INTO user (first_name,last_name,username,password,role) VALUES ('{$fname}','{$lname}','{$user}','{$hashed_password}','{$role}')";
        //SQL Query to insert the new user data into the database
        
        if(mysqli_query($conn, $sql1)) {                            //runs the insert query and check if it was successful
            header("Location: {$hostname}/admin/users.php");        //redirects to the users page after successful insertion
        }
    }
}

?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Add User</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form Start & type in action -->
                  
                  <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method ="POST" autocomplete="off">
                      <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                      </div>
                      <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="user" class="form-control" placeholder="Username" required>
                      </div>
                      <div class="form-group">
                          <label>Password</label>
                          <input type="password" name="password" class="form-control" placeholder="Password" required>
                      </div>
                      <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role" >
                              <option value="0">Normal User</option>
                              <option value="1">Admin</option>
                          </select>
                      </div>
                      <input type="submit"  name="save" class="btn btn-primary" value="Save" required />
                  </form>
                   <!-- Form End-->
               </div>
           </div>   <!-- /.row -->
       </div>      <!-- /.container -->
   </div>         <!-- /#admin-content -->
<?php include "footer.php"; ?>
