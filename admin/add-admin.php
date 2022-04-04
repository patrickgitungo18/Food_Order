<?php include ('partials/menu.php'); ?>

<div class="main-content">

	<div class="wrapper">
		<h1>Add Admin</h1> <br><br>

		<?php 
			if (isset($_SESSION['add'])) //checking whether the session is set or not
			{

				echo $_SESSION['add']; //display the session message if set
				unset ($_SESSION['add']); //remove session message

			}
		?>
		<br><br>
		<form action="" method="POST">
			
			<table class="table-30">
				<tr>
					<td>Full Name:</td>
					<td><input type="text" name="full_name" placeholder="Enter your name"></td>
				</tr>
				<tr>
					<td>Username:</td>
					<td><input type="text" name="username" placeholder="Enter your username"></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="Password" name="password" placeholder="Enter your password"></td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" name="submit" value="Add Admin" class="btn-success">
					</td>
					
				</tr>
			</table>


		</form>
	</div>

</div>

<?php 

 //process the value from Form and Save it in Database
//check whether the submit button is clicked or not

if (isset($_POST['submit'])){

	//Button clicked

	//1. Get the data from Form
	$full_name = $_POST['full_name'];
	$username = $_POST['username'];
	$password = md5($_POST['password']); //Password Encryption with MD5

	//2. SQL Query to save the data into database

	$sql = "INSERT INTO tbl_admin SET 
		full_name = '$full_name',
		username = '$username',
		password = '$password'
	";
	
	//3. Executing Query and Saving Data into Database
	$res = mysqli_query($conn, $sql) or die (mysqli_error());

	//4. Check whether the (Query is executed) data is inserted or not display appropriate message

	if ($res==TRUE)
	{
		//create a variable to display message
		$_SESSION['add'] = "<div class'success'>Admin Added successfully!!</div>";
		//redirect page to manage admin
		header("location:".SITEURL.'admin/manage-admin.php');
	}
	else
	{
		$_SESSION['add'] = "<div class='error'>Failed to add admin!!</div>";
		//redirect page to Add admin
		header("location:".SITEURL.'admin/add-admin.php');

	}
}

?>
	
<?php include ('partials/footer.php'); ?>