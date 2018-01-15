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

if ($User->Get("Username", $_GET["user"]) == $User->Name) {
	define("CURRENT_PAGE", "ME");
}

if (isset($_GET["user"]) && $User->Exists($_GET["user"])) {
	$ProfileName = $User->Get("Username", $_GET["user"]);
	$ProfileID   = $User->Get("UserID", $_GET["user"]);
	$PageTitle   = " {$ProfileName}";
}
else
{
	$PageTitle = " Profile";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $PageTitle; ?> &middot; <?php echo $Core->GetString("Title"); ?></title>
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
				<?php
				if ($User->LoggedIn)
				{
					if (!$ProfileName)
					{
						$Core->Alert("Oops!", "This user does not exist and therefore has no profile to show!", "error");
						echo "<div class=\"form-actions\">
							<a href=\"{$Core->GetString("URL")}/index.php\" class=\"btn btn-primary\">Return Home</a>
						</div>";
					}
					else
					{
						if ($User->Exists($ProfileName)==false)
						{
							$Core->Alert("Oops!", "This user does not exist and therefore has no profile to show!", "error");
							echo "<div class=\"form-actions\">
								<a href=\"{$Core->GetString("URL")}/index.php\" class=\"btn btn-primary\">Return Home</a>
							</div>";
						}
						else
						{
							$User->Update("PageVisits", ($User->Get("PageVisits", $ProfileName) + 1), $ProfileName);
						?>
							
							<div id="sUS_WallPostDialog" tabindex="-1" role="dialog" aria-labelledby="sUS_WallPostDialogLabel" class="modal hide fade" style="outline: none;">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h3 id="sUS_WallPostDialogLabel">Post on <?php echo $User->Get("Username", $ProfileName); ?>'s Wall</h3>
								</div>
								<form method="post" id="sUS_WallPostForm" name="sUS_WallPostForm" style="margin-bottom: 0;">
									<input type="hidden" id="sUS_WallPostTo" name="sUS_WallPostTo" value="<?php echo $User->Get("UserID", $ProfileName); ?>" />
									<div class="modal-body">
										<p>
											<textarea id="sUS_WallPostMessage" name="sUS_WallPostMessage" style="height: 140px; width: 518px;" placeholder="Enter a message to post to <?php echo $User->Get("Username", $ProfileName); ?>'s wall"></textarea>
										</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn" id="sUS_WallPostClose" name="sUS_WallPostClose" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Close</button>
										<button type="submit" class="btn btn-primary" id="sUS_WallPostSubmit" name="sUS_WallPostSubmit"><i class="icon-ok icon-white"></i> Post</button>
									</div>
								</form>
							</div>
							
							<div class="page-header">
								<h1>
									<?php echo $User->Get("Username", $ProfileName); ?>
									<small>
										<?php echo $User->Get("Rank", $ProfileName); ?>, <?php echo $User->Get("Sex", $ProfileName); if ($User->Get("Location", $ProfileName)) { echo ", from {$User->Get("Location", $ProfileName)}"; } ?>
									</small>
								</h1>
							</div>
							
							<div class="user-content">
								<ul class="nav nav-tabs" id="UserTabs">
									<li class="active"><a href="#wall" data-toggle="tab" id="TabWallPostLink">Wall</a></li>
									<li><a href="#information" data-toggle="tab" id="TabInformationLink">Information</a></li>
									<?php if ($User->Get("Rank") == "Administrator" XOR ($ProfileID == "1" && $User->Get("UserID") !== "1")) { ?><li><a href="#admin" data-toggle="tab" id="TabAdminLink">Admin</a></li><?php } ?>
								</ul>
								
								<div class="tab-content">
									<div class="tab-pane active" id="wall">
										Loading...
									</div>
									
									<div class="tab-pane" id="information">
										<fieldset>
											<legend>About</legend>
											
											<dl class="dl-horizontal">
												<dt>Gender</dt>
													<dd class="muted"><?php echo $User->Get("Sex", $ProfileName); ?></dd>
												
												<dt>Birthday</dt>
													<dd class="muted"><?php echo date("jS F, Y", $User->Get("BirthDate", $ProfileName)); ?></dd>
												
												<dt>Join date</dt>
													<dd class="muted"><?php echo date("jS F, Y - g:i a", $User->Get("JoinDate", $ProfileName)); ?></dd>
													
												<?php if ($User->Get("LastVisit", $ProfileName) !== "0") { ?>
													<dt>Last Visit</dt>
														<dd class="muted">
															<abbr title="<?php echo date("l, jS F, Y - g:i a", $User->Get("LastVisit")); ?>"><?php echo $Core->DateAgo($User->Get("LastVisit")); ?></abbr>
														</dd>
												<?php } ?>
												
												<dt>Page Visits</dt>
													<dd class="muted"><?php echo intval($User->Get("PageVisits", $ProfileName)); ?></dd>
												
												<dt>Rank</dt>
													<dd class="muted"><?php echo $User->Get("Rank", $ProfileName); ?></dd>
												
												<?php if ($User->Get("Location", $ProfileName)) { ?>
													<dt>Location</dt>
														<dd class="muted"><?php echo $User->Get("Location", $ProfileName); ?></dd>
												<?php } ?>
												
												<?php if ($User->Get("Music", $ProfileName)) { ?>
													<dt>Music</dt>
														<dd class="muted">
															<?php
															$Music = explode("\n", htmlspecialchars($User->Get("Music", $ProfileName)));
															foreach ($Music as $MusicItem) {
																echo $MusicItem . "<br />";
															}
															?>
														</dd>
												<?php } ?>
												
												<?php if ($User->Get("Movies", $ProfileName)) { ?>
													<dt>Movies</dt>
														<dd class="muted">
															<?php
															$Movies = explode("\n", htmlspecialchars($User->Get("Movies", $ProfileName)));
															foreach ($Movies as $MovieItem) {
																echo $MovieItem . "<br />";
															}
															?>
														</dd>
												<?php } ?>
											</dl>
										</fieldset>
										
										<fieldset>
											<legend>Interact</legend>
											
											<dl class="dl-horizontal">
												<dt>Email</dt>
													<dd class="muted"><a href="mailto:<?php echo $User->Get("Email", $ProfileName); ?>"><?php echo $User->Get("Email", $ProfileName); ?></a></dd>
												
												<?php if ($User->Get("Website", $ProfileName)) { ?>
													<dt>Website</dt>
														<dd class="muted"><a href="http://www.<?php echo urlencode($User->Get("Website", $ProfileName)); ?>" target="_blank">http://www.<?php echo $User->Get("Website", $ProfileName); ?></a></dd>
												<?php } ?>
												
												<?php if ($User->Get("Facebook", $ProfileName)) { ?>
													<dt>Facebook</dt>
														<dd class="muted"><a href="http://www.fb.me/<?php echo urlencode($Core->Filter($User->Get("Facebook", $ProfileName))); ?>" target="_blank">/<?php echo $Core->Filter($User->Get("Facebook", $ProfileName)); ?></a></dd>
												<?php } ?>
												
												<?php if ($User->Get("Twitter", $ProfileName)) { ?>
													<dt>Twitter</dt>
														<dd class="muted"><a href="http://www.twitter.com/<?php echo urlencode($Core->Filter($User->Get("Twitter", $ProfileName))); ?>" target="_blank">@<?php echo $Core->Filter($User->Get("Twitter", $ProfileName)); ?></a></dd>
												<?php } ?>
												
												<?php if ($User->Get("Xbox", $ProfileName)) { ?>
													<dt>Xbox</dt>
														<dd class="muted"><a href="https://live.xbox.com/en-GB/Profile?gamertag=<?php echo urlencode($Core->Filter($User->Get("Xbox", $ProfileName))); ?>" target="_blank"><?php echo $Core->Filter($User->Get("Xbox", $ProfileName)); ?></a></dd>
												<?php } ?>
												
												<?php if ($User->Get("PS3", $ProfileName)) { ?>
													<dt>PS3</dt>
														<dd class="muted"><?php echo $Core->Filter($User->Get("PS3", $ProfileName)); ?></dd>
												<?php } ?>
											</dl>
										</fieldset>
									</div>
									
									<?php if ($User->Get("Rank") == "Administrator" XOR ($ProfileID == "1" && $User->Get("UserID") !== "1")) { ?>
									<div class="tab-pane" id="admin">
										<p>Select an option...</p>
										
										<div class="btn-group">
											<a href="<?php echo $Core->GetString("URL"); ?>/admin/edituser.php?user=<?php echo $ProfileID; ?>" class="btn btn-primary"><i class="icon-wrench icon-white"></i> Edit <?php echo $ProfileName; ?></a>
											<a href="<?php echo $Core->GetString("URL"); ?>/admin/banuser.php?user=<?php echo $ProfileID; ?>" class="btn btn-warning"><i class="icon-lock icon-white"></i> Ban <?php echo $ProfileName; ?></a>
											<a href="<?php echo $Core->GetString("URL"); ?>/admin/deleteuser.php?user=<?php echo $ProfileID; ?>" class="btn btn-danger"><i class="icon-trash icon-white"></i> Delete <?php echo $ProfileName; ?></a>
										</div>
									</div>
									<?php } ?>
								</div>
							</div>
						<?php
						}
					}
				}
				else
				{
					$Core->Alert("Oops!", "It appears you are not logged in and therefore do not have permission to view this page.", "error");
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
	<script type="text/javascript">
		$(function(){
			$("div#wall").load("<?php echo $Core->GetString("URL"); ?>/inc/wall_posts.php?UserID=<?php echo $User->Get("UserID", $ProfileID); ?>");
		});
	</script>
</body>
</html>
<?php
ob_flush();
?>