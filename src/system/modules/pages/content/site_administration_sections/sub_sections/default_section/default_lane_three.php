<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: default_lane_three.php                        *|
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

// Create "SystemUpdate" Elements.

$divSystemUpdate = new FDiv();
$parInfo         = new FParagraph();
$divIconHolder   = new FDiv();
$divIcon         = new FDiv();
$parVersion      = new FParagraph();

// Create "Adverts" Elements.

$divBannerOne    = new FDiv();
$divBannerTwo    = new FDiv();

// Check "System Version" If Info Was Fetched.

if (!empty($varSystemVersion)) 
{
    // Create "Temp" Variables.
    
    $tempSystemUpdated = $varSystemVersion == Core::get(Core::SYSTEM_VERSION); // New Version Available.
    
    // "Div SystemUpdate" Element Settings.
    
    $divSystemUpdate->setID("system-info-available");
    $divSystemUpdate->setClass("lane-item");
    
    // "Paragraph Info" Element Settings.
    
    $parInfo->setID("update-info");
    $parInfo->setClass("available-info");
    
    if ($tempSystemUpdated)
        $parInfo->setContent(Locales::getParagraph("system-updated"));
    else
        $parInfo->setContent(Locales::getParagraph("update-available"));

    // "Div Icon Holder" Element Settings.
    
    $divIconHolder->setID("info-available-icon");
    $divIconHolder->setClass("update-info-icon");
    
    // "Div Icon" Element Settings.

    $divIcon->setClass("protector");
    $divIcon->setContent(Locales::getCore("update"));

    // "Paragraph Version" Element Settings.
    
    $parVersion->setID("version-info");
    $parVersion->setClass("available-info");
    
    if ($tempSystemUpdated)
        $parVersion->setContent(Locales::getCore("system-version") . ": <strong>" . $varSystemVersion . "</strong>");
    else
        $parVersion->setContent(Locales::getCore("available-version") . ": <strong>" . $varSystemVersion . "</strong>");
}
else
{
    // "Div System Update" Element Settings.

    $divSystemUpdate->setID("system-info-unavailable");
    $divSystemUpdate->setClass("lane-item");

    // "Paragraph Info" Element Settings.

    $parInfo->setID("update-info");
    $parInfo->setClass("unavailable-info");
    $parInfo->setContent(Locales::getParagraph("info-not-available"));

    // "Div Icon Holder" Element Settings.

    $divIconHolder->setID("info-unavailable-icon");
    $divIconHolder->setClass("update-info-icon");

    // "Div Icon" Element Settings.

    $divIcon->setClass("protector");
    $divIcon->setContent(Locales::getCore("update"));

    // "Paragraph Version" Element Settings.

    $parVersion->setID("version-info");
    $parVersion->setClass("unavailable-info");
    $parVersion->setContent(Locales::getCore("version") . ": <strong>" . Core::get(Core::SYSTEM_VERSION) . "</strong>");
}

// If "Advert One" Was Fetched Display It.

if (!empty($varBannerOne))
{
    // "Div Banner One" Element Settings.
    
    $divBannerOne->setID("advert-one");
    $divBannerOne->setClass("lane-item");
    $divBannerOne->setContent($varBannerOne);
}

// If "Advert Two" Was Fetched Display It.

if (!empty($varBannerTwo))
{
    // "Second Advert" Element Settings.
    
    $divBannerTwo->setID("advert-two");
    $divBannerTwo->setClass("lane-item");
    $divBannerTwo->setContent($varBannerTwo);
}

// Append Elements To "Icon Holder" Elements.

$divIconHolder->addElement($divIcon);

// Append Elements To "System Update" Elements.

$divSystemUpdate->addElement($parInfo);
$divSystemUpdate->addElement($divIconHolder);
$divSystemUpdate->addElement($parVersion);

// Append Elements To "Lane Three" Element.

$divLaneThree->addElement($divSystemUpdate);

if (!empty($varBannerOne))
    $divLaneThree->addElement($divBannerOne);

if (!empty($varBannerTwo))
    $divLaneThree->addElement($divBannerTwo);

?>