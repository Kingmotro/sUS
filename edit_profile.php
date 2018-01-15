<?php
/*========================================================================
| sUS (simpleUserSystem) - A simple user system developed in OOP PHP
| This system also uses the full Bootstrap and jQuery libraries
| ########################################################################
| Copyright (C) 2012, Mark Eriksson
| http://www.mark-eriksson.com
| ########################################################################
| This program is free software: you can redistribute it and/or modify
| it under the terms of the GNU General Public License as published by
| the Free Software Foundation, either version 3 of the License, or
| (at your option) any later version.
| ########################################################################
| This program is distributed in the hope that it will be useful,
| but WITHOUT ANY WARRANTY; without even the implied warranty of
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
| GNU General Public License for more details.
\=======================================================================*/

ob_start();
define("CURRENT_PAGE", "ME");
include_once("inc/global.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Edit Profile &middot; <?php echo $Core->GetString("Title"); ?></title>
	<?php include_once("inc/inc.head.php"); ?>
</head>

<body>
	<div id="drop_down_bar">&nbsp;</div>
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="brand" href="<?php echo $Core->GetString("URL"); ?>/index.php"><?php echo $Core->GetString("Title"); ?></a>
				<div class="nav-collapse collapse">
					<?php include_once("inc/inc.navigation.php"); ?>
				</div>
			</div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span3">
				<div class="well">
					<?php include_once("inc/inc.sidebar.php"); ?>
				</div>
			</div>
			
			<div class="span9 well">
				<div class="page-header">
					<h1>Edit Profile</h1>
				</div>
				
				<?php
				if ($User->LoggedIn) //User IS logged in.
				{
					?>
					<p id="sUS_EditProfileText1">
						The information below is the information that will be displayed on your profile. Any fields you leave blank will not appear on your profile.
					</p>
					
					<form method="post" id="sUS_EditProfileForm" name="sUS_EditProfileForm" class="form-horizontal">
						<ul class="nav nav-tabs" id="sUS_EditProfileTabs">
							<li class="active"><a data-toggle="tab" href="#about">About</a></li>
							<li><a data-toggle="tab" href="#interact">Interact</a></li>
						</ul>
						
						<div class="tab-content">
							<div class="tab-pane active" id="about">
								<div class="control-group">
									<label for="sUS_EditProfileGender" class="control-label">Gender</label>
									<div class="controls">
										<select name="sUS_EditProfileGender" id="sUS_EditProfileGender">
											<?php
											$Gender_Opts = array("Male", "Female");
											
											foreach ($Gender_Opts as $Gender_Opt) {
												echo "<option"; if ($User->Get("Sex") == $Gender_Opt) { echo " selected=\"yes\""; } echo ">{$Gender_Opt}</option>";
											}
											?>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label for="sUS_EditProfileDate" class="control-label">Date of Birth</label>
									<div class="controls">
										<?php $DOB = $User->Get("BirthDate"); ?>
										<select name="sUS_EditProfileDate" id="sUS_EditProfileDate">
											<?php
											for ($i=1; $i<=31; $i++) {
												echo "<option"; if (date("j", $DOB) == $i) { echo " selected=\"yes\""; } echo ">{$i}</option>";
											}
											?>
										</select>
										
										<select name="sUS_EditProfileMonth" id="sUS_EditProfileMonth">
											<?php
											$Months = array("1" => "January", "2" => "February", "3" => "March", "4" => "April", "5" => "May", "6" => "June", "7" => "July", "8" => "August", "9" => "September", "10" => "October", "11" => "November", "12" => "December");
											foreach ($Months as $MonthID => $MonthName) {
												echo "<option value=\"{$MonthID}\""; if (date("n", $DOB) == $MonthID) { echo " selected=\"yes\""; } echo ">{$MonthName}</option>";
											}
											?>
										</select>
										
										<select name="sUS_EditProfileYear" id="sUS_EditProfileYear">
											<?php
											for ($i=1950; $i<=(date("Y")-5); $i++) {
												echo "<option"; if (date("Y", $DOB) == $i) { echo " selected=\"yes\""; } echo ">{$i}</option>";
											}
											?>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label for="sUS_EditProfileLocation" class="control-label">Location</label>
									<div class="controls">
										<input type="text" name="sUS_EditProfileLocation" id="sUS_EditProfileLocation" maxlength="25" value="<?php echo $User->Get("Location"); ?>" placeholder="Tell us where you live&hellip;" />
									</div>
								</div>
								<div class="control-group">
									<label for="sUS_EditProfileMusic" class="control-label">Music</label>
									<div class="controls">
										<textarea name="sUS_EditProfileMusic" id="sUS_EditProfileMusic" rows="4" style="width: 300px;" placeholder="Tell us what music you like&hellip;"><?php echo $User->Get("Music"); ?></textarea>
									</div>
								</div>
								<div class="control-group">
									<label for="sUS_EditProfileMovies" class="control-label">Movies</label>
									<div class="controls">
										<textarea name="sUS_EditProfileMovies" id="sUS_EditProfileMovies" rows="4" style="width: 300px;" placeholder="Tell us what movies you like&hellip;"><?php echo $User->Get("Movies"); ?></textarea>
									</div>
								</div>
							</div>
							
							<div class="tab-pane" id="interact">
								<div class="control-group">
									<label for="sUS_EditProfileWebsite" class="control-label">Website</label>
									<div class="controls">
										<div class="input-prepend">
											<span class="add-on">www.</span>
											<input type="text" name="sUS_EditProfileWebsite" id="sUS_EditProfileWebsite" maxlength="300" value="<?php echo $User->Get("Website"); ?>" placeholder="What is your website URL?" />
										</div>
									</div>
								</div>
								<div class="control-group">
									<label for="sUS_EditProfileFacebook" class="control-label">Facebook</label>
									<div class="controls">
										<div class="input-prepend">
											<span class="add-on">/</span>
											<input type="text" name="sUS_EditProfileFacebook" id="sUS_EditProfileFacebook" maxlength="35" value="<?php echo $User->Get("Facebook"); ?>" placeholder="What is your Facebook username?" />
										</div>
									</div>
								</div>
								<div class="control-group">
									<label for="sUS_EditProfileTwitter" class="control-label">Twitter</label>
									<div class="controls">
										<div class="input-prepend">
											<span class="add-on">@</span>
											<input type="text" name="sUS_EditProfileTwitter" id="sUS_EditProfileTwitter" maxlength="35" value="<?php echo $User->Get("Twitter"); ?>" placeholder="What is your Twitter username?" />
										</div>
									</div>
								</div>
								<div class="control-group">
									<label for="sUS_EditProfileXbox" class="control-label">Xbox</label>
									<div class="controls">
										<input type="text" name="sUS_EditProfileXbox" id="sUS_EditProfileXbox" maxlength="35" value="<?php echo $User->Get("Xbox"); ?>" placeholder="What is your Xbox Gamertag?" />
									</div>
								</div>
								<div class="control-group">
									<label for="sUS_EditProfilePS3" class="control-label">PS3</label>
									<div class="controls">
										<input type="text" name="sUS_EditProfilePS3" id="sUS_EditProfilePS3" maxlength="35" value="<?php echo $User->Get("PS3"); ?>" placeholder="What is your PS3 username?" />
									</div>
								</div>
							</div>
						</div>
						
						<div class="form-actions">
							<button type="submit" name="sUS_EditProfileSubmit" id="sUS_EditProfileSubmit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Submit</button>
							<button type="reset" name="sUS_EditProfileReset" id="sUS_EditProfileReset" class="btn"><i class="icon-trash"></i> Reset</button>
						</div>
					</form>
					<?php
				}
				else //User is NOT logged in.
				{
					$Core->Alert("Oops!", "It appears you are not logged in and therefore cannot edit your password.", "error");
					echo "<div class=\"form-actions\">
						<a href=\"{$Core->GetString("URL")}/index.php\" class=\"btn btn-primary\">Return Home</a>
					</div>";
				}
				?>
			</div>
		</div>

		<hr />

		<footer>
			<?php include_once("inc/inc.footer.php"); ?>
		</footer>
	</div>
	
	<?php include_once("inc/inc.scripts.php"); ?>
	<?php require_once(SUS_INCLUDES . "/useralerts.php"); ?>
</body>
</html>
<?php
ob_flush();
?>