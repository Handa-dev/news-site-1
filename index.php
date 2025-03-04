<?php include 'header.php'; 

?>
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!-- post-container -->
                    <div class="post-container">
                        <?php
                        include "config.php";
                      
                        $limit = 3;         //how many records display on one page 
                       if(isset($_GET['page'])){
                          $page = $_GET['page'];
                       }else{
                          $page = 1;
                       }
                       
                        $offset = ($page - 1) * $limit; 
                         
                       $sql = "SELECT post.post_id, post.title, post.description,post.post_date,post.author, category.category_name,user.username,post.category,post.post_img FROM post LEFT JOIN category ON post.category =category.category_id LEFT JOIN user ON post.author = user.user_id ORDER BY post.post_id DESC LIMIT {$offset},{$limit}";                       ;
                        
                        //echo "<br>hi2";
                       // exit;
                        $result = mysqli_query($conn,$sql) or die("query failed. "); //querry run use fun 
                        if(mysqli_num_rows($result) > 0 )
                        {
                            while($row = mysqli_fetch_assoc($result))
                            {
                           
                       
                        ?>
                        <div class="post-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <a class="post-img" href="single.php?id=<?php echo $row['post_id'] ?>"><img src="admin/upload/<?php echo $row['post_img'] ?>" alt=""/></a>
                                </div>  <!---single.php use echo $row['post_id']post and read more option id show in url bar-->
                             
                               <div class="col-md-8">
                                    <div class="inner-content clearfix">
                                        <h3><a href='single.php?id=<?php echo $row["post_id"] ?>'><?php echo $row['title'] ?></a></h3>
                                        <div class="post-information">
                                            <span>
                                                <i class="fa fa-tags" aria-hidden="true"></i>

                                                <a href='category.php?cid=<?php echo $row['category']?>'><?php echo $row['category_name'] ?></a>
                                            </span> <!---cid pas in line 44 click on home category page opn user click on which category type-->
                                            <span>
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                <a href='author.php?aid=<?php echo $row['author']?>'><?php echo $row['username'] ?></a>
                                            </span>
                                            <span>
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                <?php echo $row['post_date'] ?>
                                            </span>
                                        </div>
                                        <p class="description">
                                        <?php echo substr($row['description'],0,130) . "..." ;?> <!--use substring function for data show only 130 characters -->
                                        </p>
                                        <a class='read-more pull-right' href='single.php?id=<?php echo $row["post_id"] ?>'>read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <?php
                            }
                        }
                        else
                        {
                            echo "<h2>No Record Found.</h2>";
                        }
                         
                       
                         $sql1 = "SELECT * FROM post";//user tables say record fetch krke leker ane k liye
                         
                         $result1 = mysqli_query($conn,$sql1) or die("query failed");
                       
                        if(mysqli_num_rows($result1) > 0)
                        {
                            $total_records = mysqli_num_rows($result1);
                           
                           
                            $total_page = ceil($total_records / $limit);
                           echo '<ul class="pagination admin-pagination">';
                           if($page > 1){
                           echo '<li><a href="index.php?page='.($page - 1). '">Prev</a></li>'; //list create
                           }
                            for($i = 1; $i <= $total_page; $i++)
                            {
                                if($i == $page)
                                {
                                    $active = 'active';
                                }
                                else{
                                    $active = "";
                                }
                              echo'<li class=" '.$active. '"><a href ="index.php?page=' .$i.'">' .$i.'</a></li>';
      
                            }
                            if($total_page > $page){
                              echo '<li><a href="index.php?page='.($page + 1). '">Next</a></li>';//list create
                              }
                            
                            echo '</ul>';
                        }
                        ?>
                   <!--     <ul class='pagination'>
                            <li class="active"><a href="">1</a></li>
                            <li><a href="">2</a></li>
                            <li><a href="">3</a></li>
                        </ul> -->
                    </div><!-- /post-container -->
                </div>
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>
