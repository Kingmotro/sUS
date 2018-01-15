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
?>
<p class="navbar-text pull-right">
	<?php
	if ($User->LoggedIn)
	{
	?>
		Logged in as <a href="<?php echo $Core->GetString("URL"); ?>/profile/<?php echo $User->Name; ?>" class="navbar-link"><?php echo $User->Name; ?></a>
		<span class="divider">|</span>
		<?php if ($User->Get("Rank") == "Administrator") { ?>
			<a href="<?php echo $Core->GetString("URL"); ?>/admin/" class="navbar-link<?php if (strpos($_SERVER["PHP_SELF"], '/admin/')!==false) { echo "\" style=\"color: #000000;\""; } ?>">Admin CP</a>
			<span class="divider">|</span>
		<?php } ?>
		<a href="javascript:void(0);" onclick="javascript:LogOut('<?php echo $User->Name; ?>');" class="navbar-link">Logout</a>
	<?php
	}
	else
	{
		echo "Hello Guest!";
	}
	?>
</p>
<ul class="nav">
	<?php
	$Core->NavItem("HOME", "Home", "index.php", CURRENT_PAGE);
	$Core->NavItem("MEMBERS", "Members", "members.php", CURRENT_PAGE);
	$Core->NavItem("ABOUT", "About", "about.php", CURRENT_PAGE);
	$Core->NavItem("CONTACT", "Contact", "contact.php", CURRENT_PAGE);
	if ($User->LoggedIn)
	{
		if (intval($Messages->Unread) > 0) {
			$MessagesExtraNav     = " ({$Messages->Unread})";
			$MessagesExtraNavItem = " <span class=\"badge badge-success\">{$Messages->Unread}</span>";
		}
		$Core->NavItem("ME", "Me{$MessagesExtraNav}", "#", CURRENT_PAGE, true, array("Messages{$MessagesExtraNavItem}" => "messages.php",
																					 "NAV_DIVIDER"                     => "",
																					 "My Profile"                      => "profile/{$User->Name}",
																					 "Edit Email"                      => "edit_email.php",
																					 "Edit Password"                   => "edit_password.php",
																					 "Edit Profile"                    => "edit_profile.php",
																					 "Edit Profile Picture"            => "edit_picture.php"));
	}
	else
	{
		$Core->NavItem("REGISTER", "Register", "register.php", CURRENT_PAGE);
		$Core->NavItem("RESET_PW", "Reset", "reset.php", CURRENT_PAGE);
	}
	?>
</ul>