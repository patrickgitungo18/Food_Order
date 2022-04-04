<?php include ('partials-front/menu.php'); ?>
   

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

                <?php

                    //Getting foods from database that are active and featured
                    //SQL query
                    $sql2 = "SELECT * FROM tbl_food WHERE active='YES' and featured='Yes'";
                    //Execute the Query
                    $res2=mysqli_query($conn, $sql2);
                    //Count rows to check whether the category is available or not
                    $count2 = mysqli_num_rows($res2);

                    //Check whether food available or not
                    if($count2 > 0)
                    {
                        //Food available
                        while($row=mysqli_fetch_assoc($res2))
                        {
                            //Get the values like the title, image_name
                            $id = $row['id'];
                            $title = $row['title'];
                            $price = $row['price'];
                            $description = $row['description'];
                            $image_name = $row['image_name'];

                            ?>
                             <div class="food-menu-box">
                                <div class="food-menu-img">
                                <?php 
                                    //Check whether image available or not
                                    if ($image_name == "")
                                    {
                                       //Image not Available 
                                       echo "<div class='error'>Image not Added.</div>";
                                    }
                                    else
                                    {
                                        //Image Available
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/Food/<?php echo $image_name; ?>" alt="<?php echo $description; ?>" class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>
                                
                                </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price">₱ <?php echo $price; ?></p>
                                <p class="food-detail">
                                        <?php echo $description; ?>
                                </p>
                                <br>

                                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id;?>" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>
                            <?php
                        }
                    }
                        else
                        {
                            //Food not available
                            echo "<div class='error'>Food not available</div>";
                        }
                ?>


        
            <div class="clearfix"></div>

            

        </div>
           

    </section>
    <!-- fOOD Menu Section Ends Here -->

       <?php include ('partials-front/footer.php') ?>