<?php
include "config.php";
$sql = "SELECT footerdesc FROM settings LIMIT 1";
$result = mysqli_query($conn, $sql) or die("Query Failed.");
if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    $footer_desc = $row['footerdesc'];
} else {
    $footer_desc = "News Site | All Rights Reserved."; 
}
?>
<div id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <span>© <?php echo date("Y") . " " . $footer_desc; ?></span>
            </div>
        </div>
    </div>
</div>
</body>
</html>