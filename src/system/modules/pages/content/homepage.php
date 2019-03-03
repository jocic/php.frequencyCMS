<?php

/***********************************************************\
|* Frequency CMS v1.0.0                                    *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: homepage.php                                  *|
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

$varLinkPrefix       = null;
$varLatestPages      = null;

// Create "Core" Elements.

$divPageDescriptions = null;
$hdPageTitles        = null;
$divContents         = null;
$divReadMores        = null;

// "Link Prefix" Variable Settings.

$varLinkPrefix = CMS_ROOT .
                 "?" .
                 Locales::getVariable("page") .
                 "=";

// "Latest Pages" Variable Settings.

EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

EasyGet::setOrderBy("id", EasyGet::OB_DESC);

EasyGet::setLimit(5);

$varLatestPages = EasyGet::execute
(
    "TS: pages",
    "CS: id, title, description, custom_id",
    "ARGS: published = 1"
);

// Mixed Settings And Builds.

for ($i = 0; $i < count($varLatestPages); $i ++)
{
    // Create "Core" Variables.
    
    $varPageID             = null;
    
    // Create "Core" Elements.
    
    $divPageDescriptions[] = new FDiv();
    $hdPageTitles[]        = new FHeader();
    $divContents[]         = new FDiv();
    $divReadMores[]        = new FDiv();
    
    // "Page ID" Variable Settings.
    
    if (empty($varLatestPages[$i]["custom_id"]))
        $varPageID = $varLatestPages[$i]["id"];
    else
        $varPageID = $varLatestPages[$i]["custom_id"];
    
    // "Div Page Descriptions" Element Settings.
    
    $divPageDescriptions[$i]->setClass("page-description");
    
    $divPageDescriptions[$i]->addElement($hdPageTitles[$i]);
    $divPageDescriptions[$i]->addElement($divContents[$i]);
    $divPageDescriptions[$i]->addElement($divReadMores[$i]);
    
    // "Header Page Titles" Element Settings.

    $hdPageTitles[$i]->setLevel(1);
    $hdPageTitles[$i]->setContent($varLatestPages[$i]["title"]);
    
    // "Div Contents" Element Settings.
    
    $divContents[$i]->setClass("description-content");
    
    $divContents[$i]->addElement($varLatestPages[$i]["description"]);
    
    // "Div Read Mores" Element Settings.
    
    $divReadMores[$i]->setClass("read-more");
    
    $divReadMores[$i]->addElement(new FAnchor(null, null, $varLinkPrefix . $varPageID, null, Locales::getCore("read-more")));
    
    // Build Elements.
    
    Build::element($divPageDescriptions[$i]);
}
    
?>