<?php
	session_start();

	$username = "";
	$email = "";
	$errors = array();

	// connect to DB
	$db = mysqli_connect('localhost', 'root', '', 'registration');

	// if the registration button is clicked
	if (isset($_POST['register'])) {
		$username = mysqli_real_escape_string($_POST['username']);
		$email = mysqli_real_escape_string($_POST['email']);
		$password_1= mysqli_real_escape_string($_POST['password_1']);
		$password_2 = mysqli_real_escape_string($_POST['password_2']);

		//ensure that form fields are filled properly
		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($email)) {
			array_push($errors, "Email is required");
		}
		if (empty($password_1)) {
			array_push($errors, "Password is required");
		}

		if ($password_1 != $password_2 ) {
			array_push($errors, "Password do not match");
		}

		// if there are no errors, save user to database
		if (count($errors) == 0) {
			$password = md5($password_1); // Encrypt password before storing in database
			$sql = "INSERT INTO users (username, email, password) 
						VALUES ('$username', '$email', '$password')";
			mysqli_query($db, $sql);
			$_SESSION['username'] = $username;
			$_SESSION['success'] = "You are now logged in";
			header('location: index.php'); // Redirect to homepage
		}
	}

	// log user in from login page
	if (isset($_POST['login'])) {
		$username = mysql_real_escape_string($_POST['username']);
		$password= mysql_real_escape_string($_POST['password']);

		//ensure that form fields are filled properly
		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		if (cout($errors) == 0) {
			$password = md5($password);
			$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
			$result = mysql_query($db, $query);
			if (mysqli_num_rows($result) == 1) {
				// log users in
				$_SESSION['username'] = $username;
				$_SESSION['success'] = "You are now logged in";
				header('location: index.php'); // Redirect to homepage
			}else{
				array_push($erros, "wrong username/password");
			}
		}
	}





	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header('location: login.php');
	}



?>