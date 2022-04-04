<?php include ('partials/menu.php'); ?>

<div class="main-content">
	<div class="wrapper">
		<h1>Manage Order</h1> <br>
		<!-- Button to add admin -->
		<?php
		if (isset($_SESSION['update_order'])) 
		{
			echo $_SESSION['update_order'];
			unset($_SESSION['update_order']);
		}
		if (isset($_SESSION['delete_order'])) 
		{
			echo $_SESSION['delete_order'];
			unset($_SESSION['delete_order']);
		}
		?>
			<br>
			<table class="table-full">
				<tr>
					<th>Serial No.</th>
					<th>Food</th>
					<th>Price</th>
					<th>Qty</th>
					<th>Total</th>
					<th>Order Date</th>
					<th>Status</th>
					<th>Customer Name</th>
					<th>Customer Contact</th>
					<th>Email</th>
					<th>Address</th>
					<th>Actions</th>
				</tr>
				<?php 
				//Query to Get all Orders
					$sql = "SELECT * FROM tbl_order";
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
								$food = $rows['food'];
								$price = $rows['price'];
								$qty = $rows['qty'];
								$total = $rows['total'];
								$order_date = $rows['order_date'];
								$status = $rows['status'];
								$customer_name = $rows['customer_name'];
								$customer_contact = $rows['customer_contact'];
								$customer_email = $rows['customer_email'];
								$customer_address = $rows['customer_address'];

								//display the values in our table

				?>

							<tr>
								<td><?php echo $sn++;?></td>
								<td><?php echo $food; ?></td>
								<td>₱ <?php echo $price; ?></td>
								<td><?php echo $qty; ?></td>
								<td>₱ <?php echo $total; ?></td>
								<td><?php echo $order_date; ?></td>

								<td>
									<?php
									
										if($status=="Ordered")
										{
											echo "<label>$status</label>";
										}
										else if ($status=="On Delivery") 
										{
											echo "<label style = 'color: orange;'>$status</label>";
										}
										else if ($status=="Delivered") {
											echo "<label style = 'color: green;'>$status</label>";
										}
										else if ($status=="Cancelled") {
											echo "<label style = 'color: red;'>$status</label>";
										}

									?>
								</td>

								<td><?php echo $customer_name; ?></td>
								<td><?php echo $customer_contact; ?></td>
								<td><?php echo $customer_email; ?></td>
								<td><?php echo $customer_address; ?></td>
								<td>
								<a href="<?php echo SITEURL;?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-success"><img src="../images/icon/update.png" width="15px"> Update  </a> 
								<a href="<?php echo SITEURL;?>admin/delete_order.php?id=<?php echo $id; ?>" class="btn-danger"><img src="../images/icon/delete.png" width="15px"> Delete </a>
								</td>
							</tr>
				<?php
							}
						}
						else
						{
							//we do not have the data in database
							echo "<tr><td colspan='2' class='error'>Orders not Available</td></tr>";
						}

					}


				?>

				
			</table>
	</div>
	
</div>
<?php include ('partials/footer.php'); ?>
