<?php
	error_reporting(E_ALL);
        ini_set('display_errors', 'Off');
        require_once('includes/class-insert.php');
	require_once('includes/class-query.php');
	
	require_once('load.php');

        $logged = $j->checkLogin();

	if ( $logged == false ) {

		$url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		$redirect = str_replace('messages-compose.php', 'login.php', $url);
		

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
		$send_message = $insert->send_message($_POST);
	}
	
	$friend_ids = $query->get_friends($logged_user_id);
	
	foreach ( $friend_ids as $friend_id ) {
		$friend_objects[] = $query->load_user_object($friend_id);
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Compose Message</title>
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
		<h1>Compose Message</h1>
		<div class="content">
			<form method="post">
				<input name="message_time" type="hidden" value="<?php echo time(); ?>" />
				<input name="message_sender_id" type="hidden" value="<?php echo $logged_user_id; ?>" />
				<p>
					<label for="message_recipient_id">To:</label>
					<select name="message_recipient_id">
						<option value="">--Select a Friend--</option>
						<?php foreach ( $friend_objects as $friend ) : ?>
							<option value="<?php echo $friend->ID; ?>"><?php echo $friend->user_name; ?></option>
						<?php endforeach; ?>
					</select>
				</p>
				<p>
					<label class="labels" for="message_subject">Subject:</label>
					<input name="message_subject" type="text" />
				</p>
				<p>
					<label for="message_content">Message:</label>
					<textarea name="message_content"></textarea>
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