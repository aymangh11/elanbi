<?php 
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['email'])) {

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>HOME</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
     <h1>Hello, <?php echo $_SESSION['name']; ?> Welcome to saad's website  </h1>
     <a href="logout.php"><button>Logout</button></a>
</body>
</html>

<?php 
}else{
     header("Location: 1234567890.php");
     exit();
}
 ?>