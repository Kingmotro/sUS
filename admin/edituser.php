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
define("CURRENT_PAGE", "ADMIN");
include_once("../inc/global.php");

if (isset($_GET["user"])) {
	$_User = $_GET["user"];
	if ($User->Exists($_User)) {
		$EditName = $User->Get("Username", $_User);
		$EditID   = $User->Get("UserID", $_User);
		$Title    = " - {$EditName}";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin CP &middot; Edit User<?php echo $Title; ?> &middot; <?php echo $Core->GetString("Title"); ?></title>
	<?php include_once(SUS_INCLUDES . "/inc.head.php"); ?>
</head>

<body>
	<div id="drop_down_bar">&nbsp;</div>
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="brand" href="<?php echo $Core->GetString("URL"); ?>/index.php"><?php echo $Core->GetString("Title"); ?></a>
				<div class="nav-collapse collapse">
					<?php include_once(SUS_INCLUDES . "/inc.navigation.php"); ?>
				</div>
			</div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span3">
				<div class="well sidebar-nav">
					<ul class="nav nav-list">
						<li class="nav-header">GENERAL</li>
						<li class=""><a href="index.php">Dashboard</a></li>
						<li class=""><a href="sitesettings.php">Site Settings</a></li>
						<li class=""><a href="contactforms.php">Contact Forms</a></li>
						<li class=""><a href="adminlogs.php">Admin Logs</a></li>
						<li class=""><a href="mysql.php">MySQL Connection Details</a></li>
						
						<li class="nav-header">USERS</li>
						<li class=""><a href="adduser.php">Add User</a></li>
						<li class="active"><a href="edituser.php">Edit User</a></li>
						<li class=""><a href="deleteuser.php">Delete User</a></li>
						<li class=""><a href="banuser.php">Ban User</a></li>
						<li class=""><a href="unbanuser.php">Unban User</a></li>
						<li class=""><a href="alertuser.php">Alert User</a></li>
						
						<li class="divider"></li>
						
						<li class=""><a href="#">Help</a></li>
					</ul>
				</div>
			</div>
			
			<div class="span9">
				<div class="page-header">
					<h1>Edit User<?php echo $Title; ?></h1>
				</div>
				
				<?php
				if ($User->Get("Rank") == "Administrator")
				{
					if ($EditName)
					{
						if (($EditID == "1" && $User->ID !== "1") XOR $EditID !== "1")
						{
						?>
							<p class="lead">To edit <?php echo $EditName; ?>'s details, simply edit the fields below. Any information left blank will not be shown on his/her profile.</p>
							
							<form method="post" id="sUS_AdminEditUserForm" name="sUS_AdminEditUserForm" class="form-horizontal">
								<input type="hidden" id="sUS_AdminEditUserUserID" name="sUS_AdminEditUserUserID" value="<?php echo $EditID; ?>" />
								<ul class="nav nav-tabs" id="sUS_AdminEditUserTab1">
									<li class="active"><a href="#settings" data-toggle="tab">Settings</a></li>
									<li><a href="#information" data-toggle="tab">Information</a></li>
								</ul>
								
								<div class="tab-content">
									<div class="tab-pane active" id="settings">
										<div class="control-group">
											<label for="sUS_AdminEditUserUsername" class="control-label">Username</label>
											<div class="controls">
												<input type="text" name="sUS_AdminEditUserUsername" id="sUS_AdminEditUserUsername" value="<?php echo $EditName; ?>" maxlength="18" class="input-xxlarge" />
											</div>
										</div>
										<div class="control-group">
											<label for="sUS_AdminEditUserPassword" class="control-label">Password</label>
											<div class="controls">
												<input type="password" name="sUS_AdminEditUserPassword" id="sUS_AdminEditUserPassword" value="" placeholder="Leave this field blank to keep the same password" maxlength="30" class="input-xxlarge" />
											</div>
										</div>
										<div class="control-group">
											<label for="sUS_AdminEditUserEmail" class="control-label">Email</label>
											<div class="controls">
												<input type="text" name="sUS_AdminEditUserEmail" id="sUS_AdminEditUserEmail" value="<?php echo $User->Get("Email", $EditName); ?>" maxlength="150" class="input-xxlarge" />
											</div>
										</div>
										<div class="control-group">
											<label for="sUS_AdminEditUserRank" class="control-label">Rank</label>
											<div class="controls">
												<select name="sUS_AdminEditUserRank" id="sUS_AdminEditUserRank">
													<?php
													$Rank_Opts = array("Member", "Administrator");
													
													foreach ($Rank_Opts as $Rank_Opt) {
														echo "<option"; if ($Rank_Opt == $User->Get("Rank", $EditName)) { echo " selected=\"yes\""; } echo ">{$Rank_Opt}</option>";
													}
													?>
												</select>
											</div>
										</div>
										<div class="control-group">
											<label for="sUS_AdminEditUserBanned" class="control-label">Banned</label>
											<div class="controls">
												<select name="sUS_AdminEditUserBanned" id="sUS_AdminEditUserBanned">
													<?php
													$Banned_Opts = array("1" => "Yes", "0" => "No");
													
													foreach ($Banned_Opts as $BannedID => $BannedVal) {
														echo "<option value=\"{$BannedID}\""; if ($BannedID == $User->Get("Banned", $EditName)) { echo " selected=\"yes\""; } echo ">{$BannedVal}</option>";
													}
													?>
												</select>
											</div>
										</div>
									</div>
									
									<div class="tab-pane" id="information">
										<ul class="nav nav-tabs" id="sUS_AdminEditUserTab2">
											<li class="active"><a href="#about" data-toggle="tab">About</a></li>
											<li><a href="#interact" data-toggle="tab">Interact</a></li>
										</ul>
										
										<div class="tab-content">
											<div class="tab-pane active" id="about">
												<div class="control-group">
													<label for="sUS_AdminEditUserGender" class="control-label">Gender</label>
													<div class="controls">
														<select name="sUS_AdminEditUserGender" id="sUS_AdminEditUserGender">
															<?php
															$Gender_Opts = array("Male", "Female");
															
															foreach ($Gender_Opts as $Gender_Opt) {
																echo "<option"; if ($Gender_Opt == $User->Get("Sex", $EditName)) { echo " selected=\"yes\""; } echo ">{$Gender_Opt}</option>";
															}
															?>
														</select>
													</div>
												</div>
												<div class="control-group">
													<label for="sUS_AdminEditUserDate" class="control-label">Date of Birth</label>
													<div class="controls">
														<?php $BirthDate = $User->Get("BirthDate", $EditName); ?>
														<select name="sUS_AdminEditUserDate" id="sUS_AdminEditUserDate">
															<?php
																for ($i=1; $i<=31; $i++) {
																	echo "<option"; if ($i == date("j", $BirthDate)) { echo " selected=\"yes\""; } echo ">{$i}</option>";
																}
															?>
														</select>
														
														<select name="sUS_AdminEditUserMonth" id="sUS_AdminEditUserMonth">
															<?php
																$Months = array("1" => "January", "2" => "February", "3" => "March", "4" => "April", "5" => "May", "6" => "June", "7" => "July", "8" => "August", "9" => "September", "10" => "October", "11" => "November", "12" => "December");
																foreach ($Months as $MonthID => $MonthName) {
																	echo "<option value=\"{$MonthID}\""; if ($MonthID == date("n", $BirthDate)) { echo " selected=\"yes\""; } echo ">{$MonthName}</option>";
																}
															?>
														</select>
														
														<select name="sUS_AdminEditUserYear" id="sUS_AdminEditUserYear">
															<?php
																for ($i=1950; $i<=(date("Y")-5); $i++) {
																	echo "<option"; if ($i == date("Y", $BirthDate)) { echo " selected=\"yes\""; } echo ">{$i}</option>";
																}
															?>
														</select>
													</div>
												</div>
												<div class="control-group">
													<label for="sUS_AdminEditUserLocation" class="control-label">Location</label>
													<div class="controls">
														<input type="text" name="sUS_AdminEditUserLocation" id="sUS_AdminEditUserLocation" value="<?php echo $User->Get("Location", $EditName); ?>" maxlength="25" />
													</div>
												</div>
												<div class="control-group">
													<label for="sUS_AdminEditUserMusic" class="control-label">Music</label>
													<div class="controls">
														<textarea name="sUS_AdminEditUserMusic" id="sUS_AdminEditUserMusic" rows="4" style="width: 300px;" placeholder=""><?php echo $User->Get("Music", $EditName); ?></textarea>
													</div>
												</div>
												<div class="control-group">
													<label for="sUS_AdminEditUserMovies" class="control-label">Movies</label>
													<div class="controls">
														<textarea name="sUS_AdminEditUserMovies" id="sUS_AdminEditUserMovies" rows="4" style="width: 300px;" placeholder=""><?php echo $User->Get("Movies", $EditName); ?></textarea>
													</div>
												</div>
											</div>
											
											<div class="tab-pane" id="interact">
												<div class="control-group">
													<label for="sUS_AdminEditUserWebsite" class="control-label">Website</label>
													<div class="controls">
														<div class="input-prepend">
															<span class="add-on">www.</span>
															<input type="text" name="sUS_AdminEditUserWebsite" id="sUS_AdminEditUserWebsite" maxlength="300" value="<?php echo $User->Get("Website", $EditName); ?>" />
														</div>
													</div>
												</div>
												<div class="control-group">
													<label for="sUS_AdminEditUserFacebook" class="control-label">Facebook</label>
													<div class="controls">
														<div class="input-prepend">
															<span class="add-on">/</span>
															<input type="text" name="sUS_AdminEditUserFacebook" id="sUS_AdminEditUserFacebook" maxlength="35" value="<?php echo $User->Get("Facebook", $EditName); ?>" />
														</div>
													</div>
												</div>
												<div class="control-group">
													<label for="sUS_AdminEditUserTwitter" class="control-label">Twitter</label>
													<div class="controls">
														<div class="input-prepend">
															<span class="add-on">@</span>
															<input type="text" name="sUS_AdminEditUserTwitter" id="sUS_AdminEditUserTwitter" maxlength="35" value="<?php echo $User->Get("Twitter", $EditName); ?>" />
														</div>
													</div>
												</div>
												<div class="control-group">
													<label for="sUS_AdminEditUserXbox" class="control-label">Xbox</label>
													<div class="controls">
														<input type="text" name="sUS_AdminEditUserXbox" id="sUS_AdminEditUserXbox" maxlength="35" value="<?php echo $User->Get("Xbox", $EditName); ?>" />
													</div>
												</div>
												<div class="control-group">
													<label for="sUS_AdminEditUserPS3" class="control-label">PS3</label>
													<div class="controls">
														<input type="text" name="sUS_AdminEditUserPS3" id="sUS_AdminEditUserPS3" maxlength="35" value="<?php echo $User->Get("PS3", $EditName); ?>" />
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="form-actions">
									<button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Submit</button>
									<button type="reset" class="btn"><i class="icon-trash"></i> Reset</button>
								</div>
							</form>
							<?php
						}
						else
						{
							$Core->Alert("Oops!", "You cannot edit user ID 1", "error");
							echo "<div class=\"form-actions\">
								<a href=\"{$Core->GetString("URL")}/admin/\" class=\"btn btn-primary\">Admin CP</a>
							</div>";
						}
					}
					else
					{
						?>
						<p class="lead">You haven't selected a user to edit, select one from below.</p>
						
						<?php
						$MembersQ = $DB->Query("SELECT * FROM `Users` ORDER BY ABS(`Username`) ASC");
						if (intval($DB->Num($MembersQ)) > 0)
						{
							echo "<table class=\"table table-bordered table-striped\">
								<thead>
									<tr>
										<th>#</th>
										<th>Username</th>
										<th>Edit</th>
									</tr>
								</thead>
								<tbody>";
									while ($MembersA = @mysql_fetch_array($MembersQ)) {
										echo "<tr>
											<td>{$MembersA["UserID"]}</td>
											<td>{$MembersA["Username"]}</td>
											<td><a href=\"{$Core->GetString("URL")}/admin/edituser.php?user={$MembersA["Username"]}\">Edit {$MembersA["Username"]}</a></td>
										</tr>";
									}
								echo "</tbody>
							</table>";
						}
						else //I don't know how this is possible because you have to be logged in to view this page, thus meaning that users DO exist but better safe than sorry.
						{
							echo "<p class=\"text-error\">There are no members to display</p>";
						}
					}
				}
				else
				{
					$Core->Alert("Oops!", "You do not have permission to view this page.", "error");
					echo "<div class=\"form-actions\">
						<a href=\"{$Core->GetString("URL")}/admin/\" class=\"btn btn-primary\">Admin CP</a>
					</div>";
				}
				?>
			</div>
		</div>
		
		<hr />

		<footer>
			<?php include_once(SUS_INCLUDES . "/inc.footer.php"); ?>
		</footer>
	</div>
	
	<?php include_once(SUS_INCLUDES . "/inc.scripts.php"); ?>
	<?php require_once(SUS_INCLUDES . "/useralerts.php"); ?>
</body>
</html>
<?php
ob_flush();
?>