<?php

/***********************************************************\
|* Frequency CMS v1.0.0                                    *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: dynamic_page.php                              *|
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

// Set Blank Prefix.

Build::setBlankPrefix($this->getBlankPrefix());

// Create "Core" Variables.

$varPageID                  = $_GET[Locales::getVariable("page")];
$varCommentPagePrefix       = "./?" . Locales::getVariable("page") . "=" . $varPageID . "&" . Locales::getVariable("option") . "=" . Locales::getLink("view-comments") . "&" . Locales::getVariable("comment-page") . "=";
$varCommentPageNumber       = 0;

// Create "Core" Elements.

$hdDynamicPage           = new FHeader();
$divDynamicPageContent   = new FDiv();
$divPageOptions          = new FDiv();
$divPageOptionsLeftSide  = new FDiv();
$divPageOptionsRightSide = new FDiv();
$lnkCommentNummber       = new FAnchor();
$lnkCommentOption        = new FAnchor();
$divPageCommentSection   = new FDiv();
$divPageCommentOptions   = new FDiv();
$divPageComments         = new FDiv();
$divPageCommentNumbers   = new FDiv();
$fmComment               = new FForm();
$tblComment              = new FTable();
$parToComment            = new FParagraph();
$parLogInToComment       = new FParagraph();

// Create "Row" Elements.

$rowCommentTitle         = new FTableRow();
$rowComment              = new FTableRow();
$rowCaptcha              = new FTableRow();
$rowSubmit               = new FTableRow();

// Create "Input" Elements.

$txtComment              = new FTextArea();
$inpCaptcha              = new FInput();
$btnSubmit               = new FButton();

// "Page ID" Variable Settings.

if (!is_numeric($varPageID))
    $varPageID = PageInfo::convertCustomID($varPageID);

// "Comment Page Number" Variable Settings.

if (!empty($_GET[Locales::getVariable("comment-page")]))
    $varCommentPageNumber = Filter::forNumeric($_GET[Locales::getVariable("comment-page")] - 1);

// "Header Dynamic Page" Element Settings.

$hdDynamicPage->setLevel(1);
$hdDynamicPage->setContent(PageInfo::getTitle($varPageID));

// "Div Dynamic Page Content" Element Settings.

$divDynamicPageContent->setID("page-content");
$divDynamicPageContent->setContent(PageInfo::getContent($varPageID));

// "Div Page Options" Element Settings.

$divPageOptions->setID("page-options");

$divPageOptions->addElement($divPageOptionsLeftSide);
$divPageOptions->addElement($divPageOptionsRightSide);
$divPageOptions->addElement(new FDiv(null, "clr"));

// "Div Page Options Left Side" Element Settings.

$divPageOptionsLeftSide->setClass("left-half");

$commentNumbers = Comments::countPageComments($varPageID);

if ($commentNumbers == 0)
    $divPageOptionsLeftSide->addElement(Locales::getCore("number-of-comments") . ": " . $commentNumbers);
else
    $divPageOptionsLeftSide->addElement($lnkCommentNummber);

// "Div Page Options Right Side" Element Settings.

$divPageOptionsRightSide->setClass("right-half");

if (Session::isActive())
    $divPageOptionsRightSide->addElement($lnkCommentOption);

// "Link Comment Number" Element Settings.

$lnkCommentNummber->setContent(Locales::getCore("number-of-comments") . ": " . $commentNumbers);
$lnkCommentNummber->setLink("./?" . Locales::getVariable("page") . "=" . $varPageID . "&" . Locales::getVariable("option") . "=" . Locales::getLink("view-comments"));

// "Link Comment Option" Element Settings.

$lnkCommentOption->setContent(Locales::getCore("comment"));
$lnkCommentOption->setLink("./?" . Locales::getVariable("page") . "=" . $varPageID . "&" . Locales::getVariable("option") . "=" . Locales::getLink("comment"));

// "Div Page Comment Section" Element Settings.

$divPageCommentSection->setID("page-comment-section");

$divPageCommentSection->addElement($fmComment);

// "Div Page Comment "

$divPageCommentOptions->setID("page-comment-options");

if (Session::isActive())
    $divPageCommentOptions->addElement($parToComment);
else
    $divPageCommentOptions->addElement($parLogInToComment);

// "Div Page Comments" Element Settings.

$divPageComments->setID("page-comments");

$commentArray = Comments::fetchPageComments($varPageID, $varCommentPageNumber * 10);

if (is_array($commentArray))
{
    $commentCount = 1;

    foreach ($commentArray as $comment)
    {
        $tblTempComment = new FTable();

        $tblTempComment->setID("page-comment-$commentCount");
        $tblTempComment->setClass("page-comment-table");

        $tblTempComment->addRow(new FTableRow(null, "comment-poster", new FTableCell(null, null, "<strong>" . InfoFetch::fetchUsername($comment["sender_id"]) . "</strong>")));
        $tblTempComment->addRow(new FTableRow(null, "comment-content", new FTableCell(null, null, $comment["content"])));

        $divPageComments->addElement($tblTempComment);

        $commentCount ++;
    }
    
    if ($commentNumbers > 10)
    {
        $divPageComments->addElement($divPageCommentNumbers);
        
        for ($i = 0; $i < ($commentNumbers / 10); $i ++)
        {
            if ($i == $varCommentPageNumber)
                $divPageCommentNumbers->addElement("<strong>" . ($i + 1) . "</strong>");
            else
                $divPageCommentNumbers->addElement("<a href=\"" . $varCommentPagePrefix . ($i + 1) . "\">" . ($i + 1) . "</a>");
        }
    }
}

// "Div Page Comment Numbers" Element Settings.

$divPageCommentNumbers->setID("comment-page-numbers");

// "Form Comment" Element Settings.

$fmComment->setID("comment-form");
$fmComment->setClass("default-form");
$fmComment->setMethod(FForm::MTD_POST);
$fmComment->setAction("./?" . Locales::getVariable("page") . "=" . $varPageID . "&" . Locales::getVariable("option") . "=" . Locales::getLink("comment"));

$fmComment->addItem($tblComment);

// "Table Comment" Element Settings.

$tblComment->setID("comment-form-table");
$tblComment->setClass("form-table");

$tblComment->addRow($rowCommentTitle);
$tblComment->addRow($rowComment);

if (Core::get(Core::DEPLOY_CAPTCHA) == "yes")
    $tblComment->addRow($rowCaptcha);

$tblComment->addRow($rowSubmit);

// "Paragraph To Comment" Element Settings.

$parToComment->setID("comment-options");
$parToComment->setClass("comments-info");
$parToComment->setAlignment(FParagraph::ALN_CENTER);
$parToComment->setContent(Locales::getParagraph("to-comment"));
$parToComment->setLink("./?" . Locales::getVariable("page") . "=" . $varPageID . "&" . Locales::getVariable("option") . "=" . Locales::getLink("comment"));

// "Paragraph Log In To Comment" Element Settings.

$parLogInToComment->setID("comment-options");
$parLogInToComment->setClass("comments-info");
$parLogInToComment->setAlignment(FParagraph::ALN_CENTER);
$parLogInToComment->setContent(Locales::getParagraph("log-in-to-comment"));
$parLogInToComment->setLink("./?" . Locales::getVariable("page") . "=" . Locales::getLink("log-in"));

// "Row Comment" Element Settings.

$rowCommentTitle->addCell(new FTableCell(null, null, Locales::getCore("comment")));

// "Row Comment" Element Settings.

$rowComment->addCell(new FTableCell(null, null, $txtComment, 2));

// "Row Captcha" Element Settings.

$rowCaptcha->addCell(new FTableCell(null, null, array(new FLabel("comment-captcha", Captcha::getChallenge()), $inpCaptcha)));

// "Row Submit" Element Settings.

$rowSubmit->addCell(new FTableCell(null, null, $btnSubmit, 2, null, FButton::ALN_RIGHT));

// "Textarea Comment" Element Settings.

$txtComment->setID("comment");
$txtComment->setName("req_comment");
$txtComment->setContent(null);
$txtComment->setMaxLength(200);

// "Input Captcha" Element Settings.

$inpCaptcha->setID("captcha-input");
$inpCaptcha->setClass("form-input");
$inpCaptcha->setMaxLength(2);
$inpCaptcha->setType(FInput::TP_TEXT);
$inpCaptcha->setName("req_captcha");

// "Input Submit" Element Settings.

$btnSubmit->setID("comment-button");
$btnSubmit->setClass("form-button");
$btnSubmit->setType(FInput::TP_SUBMIT);
$btnSubmit->setContent(Locales::getCore("post"));

// Build Elements.

Build::element($hdDynamicPage);
Build::element($divDynamicPageContent);

if (PageInfo::isCommentingEnabled($varPageID))
{
    if (empty($_GET[Locales::getVariable("option")]))
        Build::element($divPageOptions);
    else
    {
        if ($_GET[Locales::getVariable("option")] == Locales::getLink("comment"))
            Build::element($divPageCommentSection);
        else if ($_GET[Locales::getVariable("option")] == Locales::getLink("view-comments"))
            Build::element($divPageCommentOptions);
        
        Build::element($divPageComments);
    }
}

// Increment Page Hits.
            
Statistics::incrementPageHits();

?>