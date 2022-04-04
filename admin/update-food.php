<?php include ('partials/menu.php'); ?>

<div class="main-content">
		<div class="wrapper">
			<h1>Update Food</h1><br><br>
			<?php
			//Check whether the ID is set or not
			if(isset($_GET['id']))
			{	
				//Get the ID and all other details
				$id = $_GET['id'];
				//Create sql query to get all other details
				$sql = "SELECT * FROM tbl_food WHERE id=$id";

				//Execute the query
				$res=mysqli_query($conn, $sql);

				//count the rows to check whether the id is valid or not

				$count =mysqli_num_rows($res);

				if($count==1)
				{
					//Get all the data
					$row = mysqli_fetch_assoc($res);
					$title = $row['title'];
					$description = $row['description'];
					$price = $row['price'];
					$current_image = $row['image_name'];
					$featured = $row['featured'];
					$active = $row['active'];
				}
				else
				{
					//Redirect to manage food with session message
					$_SESSION['no-food-found'] = "<div class='error'>Food not found!</div>";
					header('location:'.SITEURL.'admin/manage-food.php');
				}

			}
			else
			{
				//Redirect to Manage Food
				header ('location:'.SITEURL.'admin/manage-food.php');

			}
			?>
			<form action="" method="POST" enctype="multipart/form-data">
			
			<table class="table-30">
				<tr>
					<td>Title:</td>
					<td><input type="text" name="title" value="<?php echo $title; ?>"></td>
				</tr>
				<tr>
				<td>Description: </td>
				<td><textarea name="description" cols="40" rows="6"><?=$description ?></textarea></td>
			</tr>
				<tr>
					<td>Price:</td>
					<td><input type="number" name="price" value="<?php echo $price; ?>"></td>
				</tr>
				<tr>
					<td>Current Image:</td>
					<td>
						<?php
							if ($current_image != "")
							{
								//Display the image
								?>
								<img src="<?php echo SITEURL; ?>images/Food/<?php echo $current_image; ?>" width="150px" heigh="150px">
								<?php
							}
							else
							{
								//Display error message
								echo "<div class='error'>Image not added!</div>";
							}
						?>
					</td>
				</tr>
				<tr>
					<td>New Image:</td>
					<td>
						<input type="file" name="image" value="">
					</td>
				</tr>
				<tr>
					<td>Featured:</td>
					<td>
						<input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
						<input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No">	No
					</td>
				</tr>
				<tr>
					<td>Active:</td>
					<td>
						<input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
						<input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No"> No
					</td>
				</tr>
				
				<tr>
					<td colspan="2">
						<input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						<input type="submit" name="submit" value="Update Food" class="btn-success">
					</td>
					
				</tr>
			</table>


		</form>
		<?php

			if(isset($_POST['submit']))
			{
				//1. Get all the values from our Form
				$id = $_POST['id'];
				$title = $_POST['title'];
				$description = $_POST['description'];
				$price = $_POST['price'];
				$current_image = $_POST['current_image'];
				$featured = $_POST['featured'];
				$active = $_POST['active'];

				//2. Updating New Image if Selected
				//Check whether the image is selected or not
				if(isset($_FILES['image']['name']))
				{
					//Get the image details
					$image_name = $_FILES['image']['name'];

					//Check whther the image is available or not
					if($image_name != "")
					{
						$title = $_POST['title'];
						//image available

						// A. Upload the new image
						//auto rename our image
						//Get the exension of our image (jpg, png, gif, etc) e.g. "food1.jpg"
						$ext = end(explode('.', $image_name));

						//Rename the image
						$image_name = $title."_".rand(000, 999).'.'.$ext; //e.g. Food_Category 834.jpg
						

						$source_path = $_FILES['image']['tmp_name'];

						$destination_path = "../images/Food/".$image_name;

						//Finally upload the image
						$upload = move_uploaded_file($source_path, $destination_path);
						
						//check whether the image is uploaded or not
						//and if the image is not uploaded then we will stop the process and redirect with error message
						
						if ($upload==false)
						{
							//Set message
							$_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
							//Redirect to add category page
							header ('location:'.SITEURL.'admin/manage-food.php');
							//stop the process
							die ();
						}

						//B. REmove the current image if available
						if ($current_image != "")
						{
							$remove_path = "../images/Food/".$current_image;
							$remove = unlink($remove_path);

							//Check whether the image is removed or not
							//If failed to remove then display message and stop the process

							if($remove == FALSE)
							{
								//Failed to remove image
								$_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image.</div>";
								header ('location:'.SITEURL.'admin/manage-food.php');
								die ();	//Stop the process
							}
						}
						
					}
					else
					{
						$image_name = $current_image; //Default image when image is not selected
					}
				}
				else
				{
					$image_name = $current_image; //Default image when button is not clicked
				}


				//3. Update the database
				$sql2 = "UPDATE tbl_food SET
					title = '$title',
					description = '$description',
					price = $price,
					image_name = '$image_name',
					featured = '$featured',
					active = '$active'
					WHERE id = $id;
					";
				//Execute the query
				$res2 = mysqli_query($conn, $sql2);

				//4. Redirect to manage category with message
				//Check whether executed or not

				if(res2 == TRUE)
				{
					//Category Updated
					$_SESSION['update'] = "<div class='success'>Food updated successfuly!</div>";
					header ('location:'.SITEURL.'admin/manage-food.php');
				}
				else
				{
					//Failed to update query
					$_SESSION['update'] = "<div class='error'>Failed to update Food!</div>";
					header ('location:'.SITEURL.'admin/manage-food.php');
				}


			}

		?>
		</div>
</div>

<?php include ('partials/footer.php'); ?>