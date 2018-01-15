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
	<title>Edit Profile Picture &middot; <?php echo $Core->GetString("Title"); ?></title>
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
					<h1>Edit Profile Picture</h1>
				</div>
				
				<?php
				if ($User->LoggedIn) //User IS logged in.
				{
					if (isset($_POST["sUS_EditPictureSubmit"]))
					{
						$WhiteList = array("jpg", "jpeg", "gif", "png");
						$Extension = end(explode(".", $_FILES["sUS_EditPictureNew"]["name"]));
						
						if ((($_FILES["sUS_EditPictureNew"]["type"] == "image/gif") || ($_FILES["sUS_EditPictureNew"]["type"] == "image/png") || ($_FILES["sUS_EditPictureNew"]["type"] == "image/pjpeg") || ($_FILES["sUS_EditPictureNew"]["type"] == "image/jpeg")) && (in_array($Extension, $WhiteList)))
						{
							if ($_FILES["sUS_EditPictureNew"]["error"] <= 0)
							{
								$PictureFileName = $User->Name . "_" . substr(md5(microtime(true)), 0, 15) . "." . $Extension;
								if (!file_exists("img/avatars/{$PictureFileName}"))
								{
									move_uploaded_file($_FILES["sUS_EditPictureNew"]["tmp_name"], "img/avatars/{$PictureFileName}");
									$User->Update("Picture", ($Core->GetString("URL") . "/img/avatars/{$PictureFileName}"));
									$Core->Alert("Success!", "Your profile picture has been successfully updated!", "success");
									echo "<div class=\"form-actions\">
										<a href=\"{$Core->GetString("URL")}/index.php\" class=\"btn btn-primary\">Home</a>
									</div>";
								}
								else
								{
									$Core->Alert("Oops!", "This file already exists!", "error");
									echo "<div class=\"form-actions\">
										<a href=\"{$Core->GetString("URL")}/edit_picture.php\" class=\"btn btn-primary\">&laquo; Back</a>
									</div>";
								}
							}
							else
							{
								$Core->Alert("Oops!", "An unknown error occurred whilst uploading your new profile picture. Try again soon.", "error");
								echo "<div class=\"form-actions\">
									<a href=\"{$Core->GetString("URL")}/edit_picture.php\" class=\"btn btn-primary\">&laquo; Back</a>
								</div>";
							}
						}
						else
						{
							$Core->Alert("Oops!", "Your new profile picture must either be a <strong>.png</strong>, <strong>.gif</strong>, <strong>.jpg</strong> or a <strong>.jpeg</strong> file. It must also be under 30mb.", "error");
							echo "<div class=\"form-actions\">
								<a href=\"{$Core->GetString("URL")}/edit_picture.php\" class=\"btn btn-primary\">&laquo; Back</a>
							</div>";
						}
					}
					else
					{
					?>
						<p id="sUS_EditPictureText1">
							Select a photo from your computer that represents you, this image will be used alongside any comments or wall posts you make.
						</p>
						
						<p id="sUS_EditPictureText2">
							Your image must be either a <strong>.png</strong>, <strong>.gif</strong>, <strong>.jpg</strong> or a <strong>.jpeg</strong> file. Any image you upload will be resized 64x64px.
						</p>
						
						<form method="post" enctype="multipart/form-data" id="sUS_EditPictureForm" name="sUS_EditPasswordForm" class="form-horizontal">
							<div class="control-group">
								<label class="control-label">Current Picture</label>
								<div class="controls">
									<img src="<?php echo $User->Get("Picture"); ?>" height="64" width="64" alt="Your current Picture" />
								</div>
							</div>
							
							<div class="control-group">
								<label for="sUS_EditPictureNew" class="control-label">New Picture</label>
								<div class="controls">
									<input type="file" name="sUS_EditPictureNew" id="sUS_EditPictureNew" />
								</div>
							</div>
							
							<div class="form-actions">
								<button type="submit" name="sUS_EditPictureSubmit" id="sUS_EditPictureSubmit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Submit</button>
								<button type="reset" name="sUS_EditPictureReset" id="sUS_EditPictureReset" class="btn"><i class="icon-trash"></i> Reset</button>
							</div>
						</form>
					<?php
					}
				}
				else //User is NOT logged in.
				{
					$Core->Alert("Oops!", "It appears you are not logged in and therefore cannot change your profile picture.", "error");
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