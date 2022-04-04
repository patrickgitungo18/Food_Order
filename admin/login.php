<?php include ('../config/constants.php')?>

<!DOCTYPE html>
<html>
<head>
	<title>Login - Food Order System</title>
	<link rel="stylesheet" type="text/css" href="../css/admin.css">
</head>
<body background="../images/bg.jpg">
	<div class="login">
		<h1 class="text-center">Please Login</h1>
		<br><br>
		<?php
		if (isset($_SESSION['login']))
				{

					echo $_SESSION['login']; 
					unset($_SESSION['login']); 
				}

		if (isset($_SESSION['no-login-message']))
				{

					echo $_SESSION['no-login-message']; 
					unset($_SESSION['no-login-message']); 
				}

		?>


		<br><br>
		<form action="" method="POST" class="text-center">
			
			Username: <br>
			<input type="text" name="username" placeholder="Enter your Username"><br><br>
			Password: <br>
			<input type="password" name="password" placeholder="Enter your Password"><br><br>

			<input type="submit" name="submit" value="Login" class="btn-primary">
		</form>
		<br><br><br>
		<p class="text-center">Created by - <br><a href="https://www.facebook.com/patrickjangitungo">Patrick Jan E. Gitungo</a></p>
	</div>

</body>
</html>

<?php
	//check whether the submit button is clicked or not
	if (isset($_POST['submit']))
	{
		//1. Get the data from Login form
		$username = $_POST['username'];
		$password = md5($_POST['password']);

		//2. SQL to check whether the suer with username and password exist or not
		$sql="SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

		//3. Execute the query
		$res=mysqli_query($conn, $sql); 

		//4. Count rows to check whether the user exist or not

		$count = mysqli_num_rows($res);

		if ($count==1)
		{
			//user available and Login success
			$_SESSION['login'] = "<div class='success'>Login Successful </div>";

			$_SESSION['user'] = $username; //to check whether the user is logged in or not and logout will unset it

			//Redirect to Home page/ Dashboard
			header ('location:'.SITEURL.'admin/');

		}
		else
		{
			//user not available and Login fail
			$_SESSION['login'] = "<div class='error text-center'>Username or Password did not match. </div>";

			//Redirect to Home page/ Dashboard
			header ('location:'.SITEURL.'admin/login.php');
		}
	}

?>