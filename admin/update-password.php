<?php include ('partials/menu.php')?>
<div class="main-content">
		<div class="wrapper">
			<h1>Change Password</h1><br><br>

			<?php

				if(isset($_GET['id']))
				{
						$id = $_GET['id'];
				}

			?>

			<form action="" method="POST">
				

				<table class="table-30">
				
				<tr>
					<td>Current Password:</td>
					<td><input type="password" name="current_password" placeholder="Current Password" "></td>
				</tr>

				<tr>
					<td>New Password:</td>
					<td><input type="password" name="new_password" placeholder="New Password" "></td>
				</tr>

				<tr>
					<td>Confirm Password:</td>
					<td><input type="password" name="confirm_password" placeholder="Confirm Password" "></td>
				</tr>
				
				<tr>
					<td colspan="2">
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						<input type="submit" name="submit" value="Change Password" class="btn-success">
					</td>
					
				</tr>
			</table>


			</form>
		</div>
</div>

<?php
	//Check whether the submit button is clicked or not
	if(isset($_POST['submit']))
	{

		//1. Get the data from form
		$id=$_POST['id'];
		$current_password = md5($_POST['current_password']);
		$new_password = md5($_POST['new_password']);
		$confirm_password = md5($_POST['confirm_password']);

		//2. Check whether the user with current ID and current passqord exists or not
		$sql = "SELECT * FROM tbl_admin WHERE id='$id' AND password='$current_password'";

		//Execute the query
		$res = mysqli_query($conn, $sql);

		if ($res == TRUE) {
			//check whether data is available
			$count=mysqli_num_rows($res);

			if ($count==1) 
			{
				//user exists and password can be changed
				//check whether the new password and confirm match or not
				if($new_password == $confirm_password)
				{
					//update the password
					$sql_pass="UPDATE tbl_admin set
					password='$new_password'
					WHERE id=$id
					";

					//Execute the query
					$res_pass=mysqli_query($conn, $sql_pass);

					//check whether the query executed or not
					if($res_pass==TRUE)
					{

					//Display success message
					$_SESSION['change-pwd'] = "<div class='success'>Password changed successfully. </div>";

					//Redirect to manage admin page with success message
					header('location:'.SITEURL.'admin/manage-admin.php');
				}
					else
					{
						//Display error Message
						//Redirect to manage admin with error message
					$_SESSION['change-pwd'] = "<div class='error'>Failed to change password. </div>";

					//Redirect to manage admin page
					header('location:'.SITEURL.'admin/manage-admin.php');
				}
				}
				else
				{
					//Redirect to manage admin with error message
					$_SESSION['pwd-not-match'] = "<div class='error'>Password did not match. </div>";

					//Redirect to manage admin page
					header('location:'.SITEURL.'admin/manage-admin.php');
				}
			}
			else
			{
				//user does not exist set message and redirect
				$_SESSION['user-not-found'] = "<div class='error'>User not found. </div>";

				//Redirect to manage admin page
				header('location:'.SITEURL.'admin/manage-admin.php');
			}
		}

		//3. Check whether the new password and confirm password match or not

		//4. Change password if all above is true
	}


?>

<?php include ('partials/footer.php')?>