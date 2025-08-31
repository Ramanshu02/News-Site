<?php include 'header.php'; ?>
    <div id="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-8">
                
                <div class="post-container">        <!-- post-container -->
                  
                    <?php
                    include "config.php";

                    if(isset($_GET['search'])) {
                      $search_term = mysqli_real_escape_string($conn, $_GET['search']);
                    
                    echo "<h2 class='page-heading'>Search : $search_term</h2>";

                    /* Calculate Offset Code */
                    $limit = 3;                
                    if(isset($_GET['page']))  {
                      $page = $_GET['page'];
                    }   
                    else {
                      $page = 1;
                    }               
                    $offset = ($page - 1) * $limit;
             
                    // First SQL Query to fetch posts matching the search term with pagination 
                    $sql = "SELECT * FROM post
                            LEFT JOIN category ON post.category = category.category_id
                            LEFT JOIN user ON post.author = user.user_id
                            WHERE post.title LIKE '%{$search_term}%' OR post.description LIKE '%{$search_term}%'
                            ORDER BY post.post_id DESC LIMIT {$offset},{$limit}";

                    $result = mysqli_query($conn, $sql) or die("Query Failed: Search Post");                
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {  
                
                    ?>
                        <div class="post-content">    <!-- post-content start-->
                            <div class="row">
                                <div class="col-md-4">
                                    <a class="post-img" href="single.php?id=<?php echo $row['post_id']; ?>"><img src="admin/upload/<?php echo $row['post_img']; ?>" alt=""/></a>
                                </div>
                                <div class="col-md-8">
                                    <div class="inner-content clearfix">
                                        <h3><a href='single.php?id=<?php echo $row['post_id']; ?>'><?php echo $row['title']; ?></a></h3>
                                        <div class="post-information">
                                            <span>
                                                <i class="fa fa-tags" aria-hidden="true"></i>
                                                <a href='category.php?cid=<?php echo $row['category']; ?>'><?php echo $row['category_name']; ?></a>
                                            </span>
                                            <span>
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                <a href='author.php?search=<?php echo $row['author']; ?>'><?php echo $row['username']; ?></a>
                                            </span>
                                            <span>
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                <?php echo $row['post_date']; ?>
                                            </span>
                                        </div>
                                        <p class="description">
                                            <?php echo substr($row['description'],0,150) . "..."; ?>
                                        </p>
                                        <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id']; ?>'>Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>       <!-- /post-content end -->
                        <?php
                            }
                        } else {
                            echo "<h2>No Record Found.</h2>";   // Shown when nothing matched in the database on searching (typed in the search box)
                        }
                        
                        // Second SQL query to count total number of matched posts to generate correct pagination links
                        $sql1 = "SELECT * FROM post 
                                WHERE post.title LIKE '%{$search_term}%'";
                        $result1 = mysqli_query($conn, $sql1) or die("Query Failed: Count Search Posts");
                         
                        if(mysqli_num_rows($result1)  >  0) {
                    
                            $total_records = mysqli_num_rows($result1); 

                            $total_page = ceil($total_records/$limit);

                            echo '<div class="bottom-pagination"><ul class="pagination admin-pagination">';
                  
                            if($page > 1)   {
                            echo '<li><a href="search.php?search='.$search_term .'&page='.($page - 1).'">Prev</a></li>';
                            }                   
                            for($i = 1; $i <= $total_page; $i++) {
                                if($i == $page) {
                                    $active = "active";
                                }   
                                else {
                                    $active = "";
                                }                       
                                echo '<li class="'.$active.'"><a href="search.php?search='.$search_term .'&page='.$i.'">'.$i.'</a></li>';
                            }
                            if($total_page > $page)   {
                                echo '<li><a href="search.php?search='.$search_term .'&page='.($page + 1).'">Next</a></li>';
                            }                   
                            echo '</ul> </div>';
                        }
                     } else {
                        echo "<h2>No Search Found.</h2>";   // Shown when the page is accessed without any search term (typed in the URL)
                      }              
                        ?>
                </div>      <!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
      </div>
    </div>
<?php include 'footer.php'; ?>
