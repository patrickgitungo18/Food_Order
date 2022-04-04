<?php include ('partials-front/menu.php'); ?>
  <!-- CAtegories Section Starts Here -->
  <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>
            <?php
                //Create SQL query to display categories from database
                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                //Execute the Query
                $res=mysqli_query($conn, $sql);
                //Count rows to check whether the category is available or not
                $count = mysqli_num_rows($res);
                
                if($count>0)
                {
                    //Categories available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //Get the values like the title, image_name
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];

                        ?>
                            <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">
                            <?php 
                                 //check whether image is available or not
                                if ($image_name =="")
                                {
                                    //Display the image
                                    echo "<div class='error'>Image not available</div>";
                                }
                                else
                                {
                                    //Image available
                                    ?>
                                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="" class="img-responsive img-curve">
                                    <?php
                                }
                             ?>
                            
                            <h3 class="float-text text-white"><?php echo $title; ?></h3>
                            </div>
                            </a>
                        <?php
                    }
                }
                else
                {
                    //categories not available
                    echo "<div class='error'>Category not Added.</div>";
                }
            
            ?>
            

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->
   

    <?php include ('partials-front/footer.php') ?>