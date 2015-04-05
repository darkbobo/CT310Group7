<?php
	$title = "Profile Page";
	
	$userName = isset($_GET['user']) ? $_GET['user'] : "";
	//$profile = isset($_POST['profile']) ? $_POST['profile'] : "";
	
	session_name("SocialNetwork");
	session_start();
	include("inc/header.php");
	include("lib/files.php");
	include("lib/userOperations.php");
	
	$helper = new DBHelper();
	$util = new util();
	$user = $dbh->getUserByUsername($userName);  //test db usage... Lisa
	
?>

			<div class="leftContent">
				<?php
				echo "This is the profile page for $user->first_name $user->last_name";
				
				//print_r($userName);						
				if ($userName == "") {
					echo '<h2>username not received!</h2>';
				} else {
					
					if ($user != "") {
						
						echo '<h2>' . $user->first_name . ' ' . $user->last_name . '</h2>';
						echo '<img class="img" src="assets/img/' . $userName . '.jpg" alt="' . $userName . '\'s profile pic">';
						
						if (isset($_SESSION['user_name']) && $dbh->isUserLoggedIn($_SESSION['user_id'])){
							echo '<h4><b>Description: </b></h4>';
							$desc = $helper->getDescriptionByUserID($user->user_id);
							echo $desc;
							$gender = $helper->getGenderByUsername($user->user_name);
							echo '<h5>Gender: ' . $gender . '</h5>';
							$mobile = $helper->getMobileByUsername($user->mobile);
							echo '<h5>Mobile: ' . $mobile . '</h5>';
							$email = $helper->getEmailByUsername($user->email);
							echo '<h5>Email: ' . $email . '</h5>';
							
						} else {
							echo '<h2>Only logged in users can view profile information!</h2>';
						}
						
						//$op = new userOperations($file);
						//$fileContents = $file->readFile();
						//print_r($fileContents);
						//$userInfo = $fileContents[$userName-1];
						//echo '<h2>' . $userInfo[1] . ' ' . $userInfo[2] . '</h2>';
						//echo '<img class="profile-pic" src="assets/img/profile'. $userName . '.jpg" alt="' . $fileContents[0][2] . '\'s image profile">';					
						//$description = $op->getDescription();
						// foreach($description as $value) {
						// 	echo '<p>' . $value . '</p><br/>';
						// }	
						//echo '<p>' . $userInfo[3] . '</p>';

					} else {
						echo '<h2>Profile not found!</h2>';
					}
				}
				?>

				
				<hr/>
				<?php
					if($util->isIpValid()){
						if($_SESSION['user_name'] == $user->user_name){
						echo '<p><a href="profileEdit.php?user=' . $userName . '">Edit information</a></p>';
						}
					}
				?>
			</div>
			
			<?php
				include_once("inc/rightContent.php")
			?>

<?php
	include("inc/footer.php")
?>
