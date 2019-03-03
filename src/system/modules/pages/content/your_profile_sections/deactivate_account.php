<?php

/***********************************************************\
|* Frequency CMS v1.0.0                                    *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: deactivate_account.php                        *|
|* ------------------------------------------------------- *|
|* Copyright (C) 2014                                      *|
|* ------------------------------------------------------- *|
|* This program is free software: you can redistribute     *|
|* it and/or modify it under the terms of the GNU Affero   *|
|* General Public License as published by the Free         *|
|* Software Foundation, either version 3 of the License,   *|
|* or any other, later, version of the License.            *|
|* ------------------------------------------------------- *|
|* This program is distributed in the hope that it will    *|
|* be useful, but WITHOUT ANY WARRANTY; without even the   *|
|* implied warranty of MERCHANTABILITY or FITNESS FOR A    *|
|* PARTICULAR PURPOSE.  See the GNU Affero General Public  *|
|* License for more details. You should have received a    *|
|* copy of the GNU Affero General Public License along     *|
|* with this program.                                      *|
|* ------------------------------------------------------- *|
|* If not, see <http://www.gnu.org/licenses/>.             *|
|* ------------------------------------------------------- *|
|* Removal of this copyright header is strictly prohibited *|
|* without written permission from the original author(s). *|
\***********************************************************/

// Security Check.

if (!defined("IND_ACCESS")) exit("Action not allowed.");

// Create "Core" Elements.

$hdDeactivateAccount  = new FHeader();
$divMainInfo          = new FDiv();
$divProfileOptions    = new FDiv();

// Create "Link" Elements.

$lnkEditProfile       = new FAnchor();
$lnkChangePassword    = new FAnchor();
$lnkDeactivateAccount = new FAnchor();

// "Header Deactivate Account" Element Settings.

$hdDeactivateAccount->setLevel(1);
$hdDeactivateAccount->setContent(Locales::getTitle("deactivate-account"));

// "Div Main Info" Element Settings.

$divMainInfo->setID("profile-status");

$divMainInfo->addElement(Locales::getParagraph("opt-not-available-in-beta"));

// "Div Profile Options" Element Settings.

$divProfileOptions->setID("users-profile-options");

$divProfileOptions->addElement(array($lnkEditProfile, " | ", $lnkChangePassword, " | ", $lnkDeactivateAccount));

// "Link Edit Profile" Element Settings.

$lnkEditProfile->setLink("./?" . Locales::getVariable("page") . "=" . Locales::getLink("your-profile") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-profile"));
$lnkEditProfile->setLinkTitle(Locales::getCore("edit-profile"));
$lnkEditProfile->setContent(Locales::getCore("edit-profile"));

// "Link Change Password" Element Settings.

$lnkChangePassword->setLink("./?" . Locales::getVariable("page") . "=" . Locales::getLink("your-profile") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("change-password"));
$lnkChangePassword->setLinkTitle(Locales::getCore("change-password"));
$lnkChangePassword->setContent(Locales::getCore("change-password"));

// "Link Deactivate Account" Element Settings.

$lnkDeactivateAccount->setLink("./?" . Locales::getVariable("page") . "=" . Locales::getLink("your-profile") . "&" . Locales::getVariable("option") . "=" . Locales::getLink("deactivate-account"));
$lnkDeactivateAccount->setLinkTitle(Locales::getCore("deactivate-account"));
$lnkDeactivateAccount->setContent(Locales::getCore("deactivate-account"));

// Build Elements.

Build::element($hdDeactivateAccount);
Build::element($divMainInfo);
Build::element($divProfileOptions);

?>