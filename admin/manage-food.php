<?php include ('partials/menu.php'); ?>

<div class="main-content">
	<div class="wrapper">
		<h1>Manage Food</h1><br><br>
		<?php
			if (isset($_SESSION['add']))
				{

					echo $_SESSION['add']; 
					unset($_SESSION['add']); 
				}
				if (isset($_SESSION['remove']))
				{

					echo $_SESSION['remove']; 
					unset($_SESSION['remove']); 
				}
			if (isset($_SESSION['delete']))
				{

					echo $_SESSION['delete']; 
					unset($_SESSION['delete']); 
				}
			if (isset($_SESSION['no-category-found']))
				{

					echo $_SESSION['no-category-found']; 
					unset($_SESSION['no-category-found']); 
				}
			if (isset($_SESSION['update']))
				{

					echo $_SESSION['update']; 
					unset($_SESSION['update']); 
				}
			if (isset($_SESSION['upload']))
				{

					echo $_SESSION['upload']; 
					unset($_SESSION['upload']); 
				}
			if (isset($_SESSION['failed-remove']))
				{

					echo $_SESSION['failed-remove']; 
					unset($_SESSION['failed-remove']); 
				}
			?>

		<!-- Button to add admin -->
		<br><br>
			<a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary">Add Food </a>
			<br/>
			<br/>
			
			<table class="table-full">
				<tr>
					<th>Serial No.</th>
					<th>Title</th>
					<th>Description</th>
					<th>Price</th>
					<th>Image</th>
					<th>Featured</th>
					<th>Active</th>
					<th>Actions</th>
				</tr>
			<?php 
				//Query to Get all Category
					$sql = "SELECT * FROM tbl_food";
					//Execute the query
					$res = mysqli_query($conn, $sql);
					//check whether the query is executed or not
					if($res==TRUE)
					{
						//count rows to check whether we have data in database or not
						$count = mysqli_num_rows($res); //function to get all the rows in database

						$sn=1; //Create a variable and Assign the value

						//check the num of rows
						if($count>0)
						{
							//we have data in database
							while ($rows = mysqli_fetch_assoc($res))
							{
								//using while loop to get all the data from database.
								//and while loop will run as long as we have data in database

								//Get individual data
								$id = $rows['id'];
								$title = $rows['title'];
								$description = $rows['description'];
								$price = $rows['price'];
								$image_name = $rows['image_name'];
								$featured = $rows['featured'];
								$active = $rows['active'];

								//display the values in our table

				?>

				<tr>
					<td><?php echo $sn++;?></td>
					<td><?php echo $title;?></td>
					<td><?php echo $description;?></td>
					<td>₱ <?php echo $price;?></td>
					<td>
						<?php 
						//check whether image name is available or not
						if($image_name!="")
						{
							?>
							<img src="<?php echo SITEURL; ?>images/Food/<?php echo $image_name; ?>" width="100px">
							<?php
						}
						else
						{
							echo "<div class ='error'>Image not added.</div>";
						}
						?>
					</td>
					<td><?php echo $featured;?></td>
					<td><?php echo $active;?></td>
					<td>
						<a href="<?php echo SITEURL;?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-success"><img src="../images/icon/update.png" width="15px"> Update </a> 
						<a href="<?php echo SITEURL;?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger"><img src="../images/icon/delete.png" width="15px"> Delete </a>
					</td>
				</tr>
<?php
							}
						}
						else
						{
							//we do not have the data in database
							//we'll display the message inside table

						}

					}


				?>
				
			</table>
	</div>
	
</div>
<?php include ('partials/footer.php'); ?>
