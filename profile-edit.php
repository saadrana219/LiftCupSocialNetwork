<?php
        error_reporting(E_ALL);
        ini_set('display_errors', 'Off');

        require_once('includes/class-query.php');
	require_once('includes/class-insert.php');
	require_once('load.php');

        $logged = $j->checkLogin();

	if ( $logged == false ) {

		$url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		$redirect = str_replace('profile-edit.php', 'login.php', $url);
		

		header("Location: $redirect?msg=login");
		exit;
	} else {

		$cookie = $_COOKIE['soashallogauth'];
		

		$user = $cookie['user'];
		$authID = $cookie['authID'];


		$table = 't_users';
		$sql = "SELECT * FROM $table WHERE user_login = '" . $user . "'";
		$results = $jdb->select($sql);



		if (!$results) {
			die('Sorry, that username does not exist!');
		}


		$results = mysql_fetch_assoc( $results );
		$logged_user_id = $results['ID'];



	
	if ( !empty ( $_POST ) ) {
		$update = $insert->update_user($logged_user_id, $_POST);
	}

	$user = $query->load_user_object($logged_user_id);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Edit Profile</title>
		<link rel="stylesheet" href="css/style.css" />
	</head>
	<body>
		<div id="navigation">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="profile-view.php">View Profile</a></li>
				<li><a href="profile-edit.php">Edit Profile</a></li>
				<li><a href="friends-directory.php">Member Directory</a></li>
				<li><a href="friends-list.php">Friends List</a></li>
				<li><a href="feed-view.php">View Feed</a></li>
				<li><a href="feed-post.php">Post Status</a></li>
				<li><a href="messages-inbox.php">Inbox</a></li>
				<li><a href="messages-compose.php">Compose</a></li>
			</ul>
		</div>
		<h1>Edit Profile</h1>
		<div class="content">
			<form method="post">
				<p>
					<label class="labels" for="name">Full Name:</label>
					<input name="user_name" type="text" value="<?php echo $user->user_name; ?>" />
				</p>
				<p>
					<label class="labels" for="email">Email Address:</label>
					<input name="user_email" type="text" value="<?php echo $user->user_email; ?>" />
				</p>
				<p>
					<label class="labels" for="password">For password change please contact administrator at admin@saadrana.student.rit.edu</label>

				</p>
				<p>
					<input type="submit" value="Submit" />
				</p>
			</form>
			
			<p>This is a LiftCup Members-only area. Only logged in users can view this page. Please <a href="login.php?action=logout">click here to logout</a></p>
		</div>
	</body>
</html>
<?php } ?>