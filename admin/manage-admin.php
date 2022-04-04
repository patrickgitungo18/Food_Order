<?php 
include('partials/menu.php'); 
?>

	<!-- Main content section starts -->
	<div class="main-content">
		<div class="wrapper">
			<h1>Manage Admin</h1><br><br>

			<?php 
				if (isset($_SESSION['add']))
				{

					echo $_SESSION['add']; //deplaying session message
					unset($_SESSION['add']); //removing session message
				}

				if (isset($_SESSION['delete']))
				{

					echo $_SESSION['delete']; 
					unset($_SESSION['delete']); 
				}

				if (isset($_SESSION['update']))
				{

					echo $_SESSION['update']; 
					unset($_SESSION['update']); 
				}

				if (isset($_SESSION['user-not-found']))
				{

					echo $_SESSION['user-not-found']; 
					unset($_SESSION['user-not-found']); 
				}


				if (isset($_SESSION['pwd-not-match']))
				{

					echo $_SESSION['pwd-not-match']; 
					unset($_SESSION['pwd-not-match']); 
				}

				if (isset($_SESSION['change-pwd']))
				{

					echo $_SESSION['change-pwd']; 
					unset($_SESSION['change-pwd']); 
				}



			?>

			<br><br>
			<!-- Button to add admin -->
			<a href="add-admin.php" class="btn-primary">Add Admin </a>
			<br/>
			<br/>
			<table class="table-full">
				<tr>
					<th>Serial No.</th>
					<th>Full Name</th>
					<th>Username</th>
					<th>Actions</th>
				</tr>
				<?php 
				//Query to Get all admin
					$sql = "SELECT * FROM tbl_admin";
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
								$full_name = $rows['full_name'];
								$username = $rows['username'];

								//display the values in our table

				?>
								<tr>
									<td><?php echo $sn++;?></td>
									<td><?php echo $full_name;?></td>
									<td><?php echo $username;?></td>
									<td>
										<a href="<?php echo SITEURL;?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary"><img src="../images/icon/changepass.png" width="15px"> Change Pass </a> 
										<a href="<?php echo SITEURL;?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-success"><img src="../images/icon/update.png" width="15px"> Update </a> 
										<a href="<?php echo SITEURL;?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger"><img src="../images/icon/delete.png" width="15px"> Delete </a>
									</td>
								</tr>

								<?php
							}
						}
						else
						{
							//we do not have the data in database
						}

					}


				?>
				

				
			</table>
		</div>
	</div>
	<!-- Main content section ends -->


<?php include ('partials/footer.php'); ?>

</body>
</html>