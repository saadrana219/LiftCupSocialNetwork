<?php
        require_once('load.php');
	$logged = $j->checkLogin();

	if ( $logged == false ) {
          $url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	  $redirect = str_replace('index.php', 'login.php', $url);

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


	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>LiftCup SoashalSpace</title>
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
		<h1 text-align=center>LiftCup SocialSpace - Home</h1>
		<div class="square">
		<h3>Profile</h3>
		<ul>
			<li><a href="profile-view.php">View Profile</a></li>
			<li><a href="profile-edit.php">Edit Profile</a></li>
		</ul>
		</div>
		<div class="square">
		<h3>Friends</h3>
			<ul>
			<li><a href="friends-directory.php">Member Directory</a></li>
			<li><a href="friends-list.php">Friends List</a></li>
		</ul>
		</div>
		<div class="square">
		<h3>News Feed</h3>
			<ul>
			<li><a href="feed-view.php">View Feed</a></li>
			<li><a href="feed-post.php">Post Status</a></li>
		</ul>
		</div>
		<div class="square">
		<h3>Messages</h3>
			<ul>
			<li><a href="messages-inbox.php">Inbox</a></li>
			<li><a href="messages-compose.php">Compose</a></li>
		</ul>
		</div>
		
		<div class="square">
			<h3>Your Profile</h3>
			<p><b>User Info</b></p>
			<table>
				<tr>
					<td>Profile ID: </td>
					<td><?php echo $results['ID']; ?></td>
				</tr>
                                
                                <tr>
					<td>Name: </td>
					<td><?php echo $results['user_name']; ?></td>
				</tr>

				<tr>
					<td>Username: </td>
					<td><?php echo $results['user_login']; ?></td>
				</tr>
				
				<tr>
					<td>Email: </td>
					<td><?php echo $results['user_email']; ?></td>
				</tr>
				
				<tr>
					<td>Registered: </td>
					<td><?php echo date('l, F jS, Y', $results['user_registered']); ?></td>
				</tr>

				<tr>
					<td>Profession: </td>
					<td><?php echo $results['user_profession']; ?></td>
				</tr>
				
				<tr>
					<td>Phone: </td>
					<td><?php echo $results['user_phone']; ?></td>
				</tr>
			</table>
			
			<p>This is a LiftCup Members-only area. Only logged in users can view this page. Please <a href="login.php?action=logout">click here to logout</a></p>

			
		</div>
	</body>
</html>

<?php?>