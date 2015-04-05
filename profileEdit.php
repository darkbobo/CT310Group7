<?php
	// need a way to determine if logged in user is the correct user to be able to edit this page.
	// need to add option to edit auth question in this location
	$title = "Edit Profile";
	error_reporting(-1);
	ini_set('display_errors', 'On');
	// end error reporting

	session_name("SocialNetwork");
	session_start();
	require_once "./user.php";
	require_once "./lib/dbhelper.php";
	include("lib/files.php");
	include("lib/userOperations.php");
	
	$dbh = new DBHelper();
	$userName = isset($_GET['user']) ? $_GET['user'] : "";
	$user = $dbh->getUserByUsername($userName);
	
	if(!isset($_SESSION['user_name']) && !$dbh->isUserLoggedIn($_SESSION['user_id'])){
		// cannot view edit page if not logged in
		header('Location:./login.php');
	}
	include("./inc/header.php");
	$errors = array();
?>
	<div class="leftContent"><?php
		if ($userName == "") {
			echo '<h2>Username not found!</h2>';
		} else {
			
			if ($user != "") {
				
				if(isset($_POST['message']) && isset($_POST['name'])){
					$description = util::sanitizeData($_POST['message']);
					$fullName = util::sanitizeData($_POST['name']);
					
					$fullName = explode(' ', $_POST['name']);
					
					$name = $fullName[0];
					$lastName = "";
					
					if (count($fullName) > 2) {
						unset($fullName[0]);
						$lastName = join(' ', $fullName);
					} else {
						$lastName = $fullName[1];
					}
					
					
					
					
				}
				
			
				echo '<h2>' . $user->first_name . ' ' . $user->last_name . '</h2>';
				echo '<img class="profile-pic" src="assets/img/'. $userName . '.jpg" alt="' . $userName . '\'s image profile">';
				/*$target_dir = "assets/img/";
				$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
				$uploadOk = 1;
				$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
				
				if (isset($_POST["submit"])) {
					$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
					if($check !== false){
						
					}
				}*/
				
				echo '<div class="wrap-textarea">';
				echo '<form id="form1" name="form1" method="post" action="profileEdit.php?user=' . $userName . '">';
				echo '<label for="name">Name</label>';
				echo '<input type="text" id="name" name="name" value="' . $user->first_name . ' ' . $user->last_name . '"/>';
				echo '<label for="message">Description</label>';
				echo '<textarea name="message" id="message" rows="25" cols="50">';

				$desc = $dbh->getDescriptionByUserID($user->user_id);
				echo $desc;

				echo '</textarea>';
				echo '<input type="submit" name="button" id="button" value="Save"/>';
				echo '<a href="profile.php?user=' . $userName . '" >Go back</a>';
					
				if (isset($isSaved) && $isSaved){ 
					echo '<div class="save-success"><h4>Successfully saved!</h4></div>';
				}
				echo '</form></div>';

			} else {
				echo '<h2>Profile not found!</h2>';
			}
		}
		?>

		<hr/>
	</div>
	
	
	<?php
		
	?>
			

<?php
	include_once("inc/rightContent.php");
	include_once("inc/footer.php");
?>
