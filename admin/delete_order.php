<?php
	include ('../config/constants.php');

$id = $_GET['id'];

$sql = "DELETE FROM tbl_order WHERE id=$id";

$res = mysqli_query($conn, $sql);

if ($res==TRUE)
{
	$_SESSION['delete_order'] = "<div class='success'>Order deleted successfully!</div>";
	header ('location:'.SITEURL.'admin/manage-order.php');
}
else
{
	$_SESSION['delete_order'] = "<div class='error'>Failed to delete order!</div>";
	header ('location:'.SITEURL.'admin/manage-order.php');
}

?>