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
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Installer &middot; sUS</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Installation system to successfully install sUS V1." />
	<meta name="author" content="Mark Eriksson" />

	<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" />
	<style type="text/css">
	body {
		padding-top: 40px;
		padding-bottom: 40px;
		background-color: #f5f5f5;
	}

	.form-sUS_Installer {
		width: 400px;
		padding: 19px 29px 29px;
		margin: 0 auto 20px;
		background-color: #fff;
		border: 1px solid #e5e5e5;
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		border-radius: 5px;
		-webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
		-moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
		box-shadow: 0 1px 2px rgba(0,0,0,.05);
	}
	
	.form-sUS_Installer .form-sUS_Installer-heading, .form-sUS_Installer .checkbox {
		margin-bottom: 10px;
	}

	</style>
	<link href="../css/bootstrap-responsive.css" rel="stylesheet" type="text/css" />
	<link href="../css/styles.css" rel="stylesheet" type="text/css" />

	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js" type="text/javascript"></script>
	<![endif]-->
</head>

<body>
	<div class="modal hide fade" id="sUS_InstallBeforeYouProceedDialog">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Just before you proceed&hellip;</h3>
		</div>
		<div class="modal-body">
			<p>
				Just before you install sUS, please ensure that:
				<ul>
					<li>You have set the permissions of 'inc/global.php' to 777.</li>
					<li>You have set the permissions of 'js/funcs.js' to 777.</li>
					<li>You have set the permissions of 'img/avatars/' to 777.</li>
				</ul>
				If you do not do this, your sUS installation will fail. If you try to install sUS without following the steps above, you will be notified once you click the submit button.
			</p>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn btn-primary" data-dismiss="modal"><i class="icon-ok icon-white"></i> Got it!</a>
		</div>
	</div>
	<div id="drop_down_bar">&nbsp;</div>
	<div class="container">
		<form method="post" id="sUS_InstallerForm" name="sUS_InstallerForm" class="form-sUS_Installer">
			<h2 class="form-sUS_Installer-heading">sUS Installer</h2>
			
			<ul class="nav nav-tabs" id="sUS_InstallerTab">
				<li class="active"><a href="#mysql" data-toggle="tab">MySQL</a></li>
				<li><a href="#admin" data-toggle="tab">Admin</a></li>
				<li><a href="#settings" data-toggle="tab">Site Settings</a></li>
			</ul>
			
			<div class="tab-content">
				<div class="tab-pane active" id="mysql">
					<div class="control-group">
						<label for="sUS_InstallerMySQLHost" class="control-label help_tip" rel="tooltip" title="The location where the database is hosted, usually 'localhost'.">Host</label>
						<div class="controls">
							<input type="text" name="sUS_InstallerMySQLHost" id="sUS_InstallerMySQLHost" maxlength="45" value="localhost" />
						</div>
					</div>
					<div class="control-group">
						<label for="sUS_InstallerMySQLDBName" class="control-label help_tip" rel="tooltip" title="The name of the MySQL database to connect to.">Database name</label>
						<div class="controls">
							<input type="text" name="sUS_InstallerMySQLDBName" id="sUS_InstallerMySQLName" maxlength="45" />
						</div>
					</div>
					<div class="control-group">
						<label for="sUS_InstallerMySQLUsername" class="control-label help_tip" rel="tooltip" title="The name of the MySQL account.">Username</label>
						<div class="controls">
							<input type="text" name="sUS_InstallerMySQLUsername" id="sUS_InstallerMySQLUsername" maxlength="45" />
						</div>
					</div>
					<div class="control-group">
						<label for="sUS_InstallerMySQLPassword" class="control-label help_tip" rel="tooltip" title="The password of the username entered above.">Password</label>
						<div class="controls">
							<input type="password" name="sUS_InstallerMySQLPassword" id="sUS_InstallerMySQLPassword" maxlength="70" />
						</div>
					</div>
				</div>
				
				<div class="tab-pane" id="admin">
					<div class="control-group">
						<label for="sUS_InstallerAdminUsername" class="control-label help_tip" rel="tooltip" title="This will be the username that you use to login to your website.">Username</label>
						<div class="controls">
							<input type="text" name="sUS_InstallerAdminUsername" id="sUS_InstallerAdminUsername" maxlength="18" />
						</div>
					</div>
					<div class="control-group">
						<label for="sUS_InstallerAdminPassword" class="control-label help_tip" rel="tooltip" title="This will be your password that you use to login.">Password</label>
						<div class="controls">
							<input type="password" name="sUS_InstallerAdminPassword" id="sUS_InstallerAdminPassword" maxlength="30" />
						</div>
					</div>
					<div class="control-group">
						<label for="sUS_InstallerAdminEmail" class="control-label help_tip" rel="tooltip" title="Any emails from this website will be sent to this address.">Email</label>
						<div class="controls">
							<input type="text" name="sUS_InstallerAdminEmail" id="sUS_InstallerAdminEmail" maxlength="150" />
						</div>
					</div>
					<div class="control-group">
						<label for="sUS_InstallerAdminSex" class="control-label help_tip" rel="tooltip" title="Are you male or female? Your profile picture will differ depending on what you select.">Gender</label>
						<div class="controls">
							<select name="sUS_InstallerAdminSex" id="sUS_InstallerAdminSex">
								<option>Male</option>
								<option>Female</option>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label for="sUS_InstallerAdminDate" class="control-label help_tip" rel="tooltip" title="This isn't the most necessary information, but it's nice to know!">Date of Birth</label>
						<div class="controls">
							<select name="sUS_InstallerAdminDate" id="sUS_InstallerAdminDate">
								<?php
									for ($i=1; $i<=31; $i++) {
										echo "<option>{$i}</option>";
									}
								?>
							</select>
							
							<select name="sUS_InstallerAdminMonth" id="sUS_InstallerAdminMonth">
								<?php
									$Months = array("1" => "January", "2" => "February", "3" => "March", "4" => "April", "5" => "May", "6" => "June", "7" => "July", "8" => "August", "9" => "September", "10" => "October", "11" => "November", "12" => "December");
									foreach ($Months as $MonthID => $MonthName) {
										echo "<option value=\"{$MonthID}\">{$MonthName}</option>";
									}
								?>
							</select>
							
							<select name="sUS_InstallerAdminYear" id="sUS_InstallerAdminYear">
								<?php
									for ($i=1950; $i<=(date("Y")-5); $i++) {
										echo "<option>{$i}</option>";
									}
								?>
							</select>
						</div>
					</div>
				</div>
				
				<div class="tab-pane" id="settings">
					<div class="control-group">
						<label for="sUS_InstallerSettingsTitle" class="control-label help_tip" rel="tooltip" title="What do you want to call your website? This can be changed later on if need be.">Site Title</label>
						<div class="controls">
							<input type="text" name="sUS_InstallerSettingsTitle" id="sUS_InstallerSettingsTitle" maxlength="65" />
						</div>
					</div>
					<div class="control-group">
						<label for="sUS_InstallerSettingsURL" class="control-label help_tip" rel="tooltip" title="This is the URL where sUS will be installed. This can be changed later on if need be.<br /><br />Do NOT add a trailing slash (/).">URL</label>
						<div class="controls">
							<input type="text" name="sUS_InstallerSettingsURL" id="sUS_InstallerSettingsURL" maxlength="75" value="http://<?php echo $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]); ?>" style="width: 386px;" />
						</div>
					</div>
					<div class="control-group">
						<label for="sUS_InstallerSettingsCopyright" class="control-label help_tip" rel="tooltip" title="This will be displayed at the bottom left of every page. This can be changed later on if need be.<br /><br />HTML allowed.">Copyright</label>
						<div class="controls">
							<input type="text" name="sUS_InstallerSettingsCopyright" id="sUS_InstallerSettingsCopyright" maxlength="75" style="width: 386px;" />
						</div>
					</div>
					<div class="control-group">
						<label for="sUS_InstallerSettingsEmail" class="control-label help_tip" rel="tooltip" title="Any important emails will be sent to this address. This can be changed later on if need be.">Email</label>
						<div class="controls">
							<input type="text" name="sUS_InstallerSettingsEmail" id="sUS_InstallerSettingsEmail" maxlength="150" />
						</div>
					</div>
					<div class="control-group">
						<label for="sUS_InstallerSettingsHash" class="control-label help_tip" rel="tooltip" title="Enter a random string of characters, try to avoid single and double quotes. This hash will be used to encrypt passwords to make them safe and secure.<br /><br />Once you set this it cannot be changed or any existing user accounts will not work, so make sure no one else knows this!<br /><br />If you are having trouble thinking of a hash key, click the 'Generate&hellip;' button to make one for you.">Password Hash</label>
						<div class="controls">
							<div class="input-append">
								<input type="text" name="sUS_InstallerSettingsHash" id="sUS_InstallerSettingsHash" maxlength="20" />
								<button class="btn" type="button" id="sUS_InstallerSettingsHashGenerate" name="sUS_InstallerSettingsHashGenerate">Generate&hellip;</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<hr />
			
			<button type="submit" id="sUS_InstallerSubmit" name="sUS_InstallerSubmit" class="btn btn-large btn-success"><i class="icon-ok icon-white"></i> Install sUS</button>
			<button type="reset" id="sUS_InstallerReset" name="sUS_InstallerReset" class="btn btn-large"><i class="icon-trash"></i> Reset</button>
			<div class="clearfix"></div>
		</form>
	</div>
	
	<script src="../js/jquery-1.8.2.min.js" type="text/javascript"></script>
	<script src="../js/jquery-ui-1.9.1.custom.js"></script>
	<script src="../js/bootstrap.js" type="text/javascript"></script>
	<script type="text/javascript">
	$(function(){
		$("input#sUS_InstallerAdminEmail").keyup(function(){
			$("input#sUS_InstallerSettingsEmail").val($(this).val());
		});
		
		$("button#sUS_InstallerSettingsHashGenerate").click(function(){
			$.get("generate_hash.php?k=<?php echo microtime(true); ?>", {}, function(data){
				$("input#sUS_InstallerSettingsHash").val(data);
			});
		});
		
		$("label.help_tip").tooltip({'placement': 'left'});
		
		$("div#drop_down_bar").click(function(){
			$(this).hide();
		});
	
		$("form#sUS_InstallerForm").submit(function(){
			$.ajax({
				type: "POST",
				url: "install.php",
				data: $(this).serialize(),
				success: function(r){
					if (r == "success")
					{
						DDA("sUS V1 has been successfully installed! Please delete the \"installer/\" folder then you may use sUS!");
					}
					else
					{
						DDA(r);
					}
				},
				error: function(){
					DDA(ajaxerror);
				}
			});
			
			return false;
		});
		
		$("div#sUS_InstallBeforeYouProceedDialog").modal();
	});
	

	function DDA(w) {
		$("div#drop_down_bar").text(w).slideDown(350, function(){
			$(this).effect("bounce", { times: 3 }, 650, function(){
				$(this).delay(4000).slideUp("slow");
			});
		});
	}
	</script>
</body>
</html>