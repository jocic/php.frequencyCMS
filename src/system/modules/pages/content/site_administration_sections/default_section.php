<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: default_section.php                           *|
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

// Create "Core" Variables.

$varSubScriptRoot = $varScriptRoot .
                    "sub_sections" .
                    DIRECTORY_SEPARATOR .
                    "default_section" .
                    DIRECTORY_SEPARATOR;

// Create "Notice" Variables.

$varNoticeOne     = @file_get_contents("http://www.frequency-cms.com/api/notices.php?program=frequency&notice=1");
$varNoticeTwo     = @file_get_contents("http://www.frequency-cms.com/api/notices.php?program=frequency&notice=2");
$varNoticeThree   = @file_get_contents("http://www.frequency-cms.com/api/notices.php?program=frequency&notice=3");

// Create "Other" Variables.

$varSystemVersion = @file_get_contents("http://www.frequency-cms.com/api/version.php?program=frequency");
$varBannerOne     = "<a href=\"http://www.fatcow.com/join/index.bml?AffID=727583\" target=\"_blank\" title=\"FatCow Hosting! THE BEST!\"><img src=\"./system/assets/images/other/fatcow.png\" border=\"0\" alt=\"Get Best Hosting In Teh World!\" /></a>";
$varBannerTwo     = "<a href=\"http://signup.leagueoflegends.com/?ref=52271a33c1464409534193\" target=\"_blank\" title=\"Play League Of Legends!\"><img src=\"./system/assets/images/other/lol.png\" border=\"0\" alt=\"Play The Best Game In Teh World!\" /></a>";

// Create "Core" Elements.

$divLaneHolder    = new FDiv();
$divLaneOne       = new FDiv();
$divLaneTwo       = new FDiv();
$divLaneThree     = new FDiv();

// "Banner One" Variable Settings.

$varTemp = @file_get_contents("http://www.frequency-cms.com/api/adverts.php?program=frequency&advert=1");

if (!empty($varTemp))
    $varBannerOne = $varTemp;

unset($varTemp);

// "Banner Two" Variable Settings.

$varTemp = @file_get_contents("http://www.frequency-cms.com/api/adverts.php?program=frequency&advert=2");

if (!empty($varTemp))
    $varBannerTwo = $varTemp;

unset($varTemp);

// "Div Lane Holder" Element Settings.

$divLaneHolder->setID("admin-lane-holder");

$divLaneHolder->addElement($divLaneOne);
$divLaneHolder->addElement($divLaneTwo);
$divLaneHolder->addElement($divLaneThree);

// "Div Lane One" Element Settings.

$divLaneOne->setID("admin-lane-1");
$divLaneOne->setClass("admin-lane");

require_once $varSubScriptRoot . "default_lane_one.php";

// "Div Lane Two" Element Settings.

$divLaneTwo->setID("admin-lane-2");
$divLaneTwo->setClass("admin-lane");

require_once $varSubScriptRoot . "default_lane_two.php";

// "Div Lane Three" Element Settings.

$divLaneThree->setID("admin-lane-3");
$divLaneThree->setClass("admin-lane");

require_once $varSubScriptRoot . "default_lane_three.php";

// Append Elements To "Workplace" Element.

$divWorkplace->addElement($divLaneHolder);

?>