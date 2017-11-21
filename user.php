<?php
	session_start();

	$dbservername = 'dbhome.cs.nctu.edu.tw';
	$dbname='tsejui210129_cs_DB_HW1';
	$dbaccount='tsejui210129_cs';
	$dbpassword='ltes123456';
	if(isset($_SESSION['Authenticated']) and $_SESSION['Authenticated'] == true and isset($_SESSION['Account']))
	{
		$account = $_SESSION['Account'];
		try
		{
			$connect = new PDO("mysql:host=".$dbservername.";dbname=".$dbname, $dbaccount, $dbpassword);
			$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt=$connect->prepare("SELECT * FROM Account WHERE account = :account");
			$stmt->execute(array('account' => $account));
			if ($stmt->rowCount() == 1)
			{
				$row = $stmt->fetch();
				$name = $row[1];
				$account = $row[2];
				$email = $row[3];
			}
		}
		catch(PDOException $e)
		{
			$msg = $e->getMessage();
			echo $msg;
			session_unset();
			session_destroy();
			echo <<<"EOT"
				<!DOCTYPE html>
				<html>
					<body>
						<script>
							alert("Internal Error");
							window.location.replace("index.php");
						</script>
					</body>
				</html>
EOT;
		}

	}
	else
	{
		session_unset();
		session_destroy();
		echo <<<"EOT"
			<!DOCTYPE>
			<html>
				<script>
					alert("Redirect to the login page.");
					windows.location.replace("index.php");
				</script>
			</html>
EOT;
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>User Interface</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link type="text/css" rel="stylesheet" href="index.css">
	</head>
	<body>
		<div class="board">
			使用者資訊: 
			<br>
			<br>
			　　姓名: <?php echo $name; ?> 
			<br>
			<br>
			　　帳號: <?php echo $account; ?> 
			<br>
			<br>
			電子郵件: <?php echo $email; ?> 
			<br>
			<br>
			<form action="logout.php" method="post">
				<input type="submit" value="登出">
			</form>
		</div>
	</body>
</html>