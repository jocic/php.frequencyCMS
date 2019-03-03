<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: index.php                                     *|
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

// Module Starts.

Build::setBlankPrefix($this->getBlankPrefix()); // Set Blank Prefix.

// Fetch Latest Pages.

EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

EasyGet::setOrderBy("id", EasyGet::OB_DESC);
EasyGet::setLimit(5);

$pages = EasyGet::execute
(
    "TS: pages",
    "CS: id, title, custom_id",
    "ARGS: published = 1"
);

// Create Elements.

$header = new FHeader();
$list   = new FList();
$notice = new FParagraph();

// Element Settings.

$header->setLevel(3);
$header->setContent(Locales::getCore("latest-pages"));

$notice->setAlignment(FParagraph::ALN_LEFT);
$notice->setContent("- " . Locales::getParagraph("no-pages-added"));

$list->setID("latest-pages-list");
$list->setClass("default-list");
$list->setType(FList::TP_OL);

// Build Elements.

Build::element($header);

if ($pages == null)
{
    Build::element($notice);
}
else
{
    // Append Child Elements.

    foreach ($pages as $page)
    {
        // Process "ID" Variable.
        
        $id = $page["id"];
        
        if (!empty($page["custom_id"]))
            $id = $page["custom_id"];
        
        // Process "Title" Variable.

        if (strlen($page["title"]) > 30)
            $page["title"] = substr($page["title"], 0, 30) . "...";

        // Process "Link" Variable.
        
        $link = "./?" .
                Locales::getVariable("page") .
                "=" .
                $id;
        
        // Add Item.

        $list->addItem
        (
            new FListItem
            (
                null,
                null,
                "<a href=\"$link\">" . $page["title"] . "</a>"
            )
        );
    }
    
    // Build List.
    
    Build::element($list);
}

?>