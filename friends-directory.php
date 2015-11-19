<?php
	error_reporting(E_ALL);
        ini_set('display_errors', 'Off');
        require_once('includes/class-query.php');
	require_once('load.php');

        $logged = $j->checkLogin();

	if ( $logged == false ) {

		$url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		$redirect = str_replace('friends-directory.php', 'login.php', $url);
		

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
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Members Directory</title>
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
		<h1>Members Directory</h1>
		<div class="content">
			<?php $query->do_user_directory(); ?>
		<p>This is a LiftCup Members-only area. Only logged in users can view this page. Please <a href="login.php?action=logout">click here to logout</a></p>
                </div>
	</body>
</html>
<?php } ?>