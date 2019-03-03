<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: inbox_messages.php                            *|
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

$varUsersID       = null;
$varInboxMessages = null;

// Create "Core" Elements.

$hdOption         = new FHeader();
$parNotice        = new FParagraph();
$tblMessages      = new FTable();

// Create "Row" Elements.

$rowInfo          = new FTableRow();

// "Users ID" Variable Settings.

$varUsersID = IDFetch::byUsername(Session::getUsername());

// "Inbox Messages" Variable Settings.

$varInboxMessages = Messages::fetchUsersInboxMessages($varUsersID);

// "Header Option" Element Settings.

$hdOption->setLevel(2);
$hdOption->setContent(Locales::getTitle("inbox"));

// "Paragraph Notice" Element Settings.

$parNotice->setID("communication-notice");
$parNotice->setAlignment(FParagraph::ALN_CENTER);
$parNotice->setContent(Locales::getParagraph("empty-inbox"));

// "Table Messages" Element Settings.

$tblMessages->setID("message-table");
$tblMessages->setClass("default-table");

$tblMessages->addRow($rowInfo);

if ($varInboxMessages != null)
{
    for ($i = 0; $i < count($varInboxMessages); $i ++)
    {
        if ($varInboxMessages[$i]["read_status"] == 0)
            $varInboxMessages[$i]["read_status"] = Locales::getCore("unread");
        else
            $varInboxMessages[$i]["read_status"] = Locales::getCore("read");

        $tempRow = new FTableRow();

        $tempRow->addCell(new FTableCell(null, null, $i + 1));
        $tempRow->addCell(new FTableCell(null, null, $varInboxMessages[$i]["date_sent"]));
        $tempRow->addCell(new FTableCell(null, null, new FAnchor(null, null, $varLinkPreifx . Locales::getLink("view-message") . "&" . Locales::getVariable("id") . "=" . $varInboxMessages[$i]["id"], null, $varInboxMessages[$i]["title"])));
        $tempRow->addCell(new FTableCell(null, null, $varInboxMessages[$i]["read_status"]));

        $tblMessages->addRow($tempRow);
    }
}

// "Row Info" Element Settings.

$rowInfo->setClass("info-row");

$rowInfo->addCell(new FTableCell(null, null, "#"));
$rowInfo->addCell(new FTableCell(null, null, Locales::getCore("date-sent")));
$rowInfo->addCell(new FTableCell(null, null, Locales::getCore("title")));
$rowInfo->addCell(new FTableCell(null, null, Locales::getCore("status")));

// Append Elements.

$divContent->addElement($hdOption);

if ($varInboxMessages == null)
    $divContent->addElement($parNotice);
else
    $divContent->addElement($tblMessages);

?>