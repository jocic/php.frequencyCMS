<?php

/***********************************************************\
|* Frequency CMS v1.0.0                                    *|
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

// Define "Core" Constants.

define("IND_ACCESS", true);
define("DOC_ROOT", dirname(__FILE__). DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR);

// Start Session.

@session_start();

// Check Installation Step And Reddirect.

if (empty($_SESSION["step"]))
    $_SESSION["step"] = 1;
else if ($_SESSION["step"] != 1)
{
    if ($_SESSION["step"] == 2)
        exit(header("location: step-2.php"));
    else if ($_SESSION["step"] == 3)
        exit(header("location: step-3.php"));
    else if ($_SESSION["step"] == 4)
        exit(header("location: step-4.php"));
}

// Required "Frequency" Constants.

require_once DOC_ROOT .
             DIRECTORY_SEPARATOR .
             "system" .
             DIRECTORY_SEPARATOR . 
             "includes" .
             DIRECTORY_SEPARATOR .
             "frequency_constants.php";

// Required Files.

require_once DOC_ROOT .
             DIRECTORY_SEPARATOR .
             "system" .
             DIRECTORY_SEPARATOR .
             "system_core.php";

// Create "Core" Variables.

$varHeadTitle   = "frequencyCMS » Free And Open Source CMS « frequency-cms.com";
$varPageTitle   = "frequencyCMS Installation";
$varStep        = "Step #1";
$varDescrTitle  = "Languages";
$varContTitle   = "Installation";
$varLangSelect  = "<strong>Selected:</strong> English Language";
$varEN          = "English Language";
$varRS          = "Serbian Language";
$varDE          = "German Language";
$varIT          = "Italian Language";
$varRU          = "Russian Language";
$varGR          = "Greek Language";
$varParaOne     = "If you have selected your prefered language click on the button bellow.";
$varButtonValue = "Next";
$varSupportOne  = "frequencyCMS Support #1";
$varSupportTwo  = "frequencyCMS Support #2";
$varSuppInfoOne = "<strong>Support</strong> frequencyCMS financially!";
$varSuppInfoTwo = "<strong>Support</strong> frequencyCMS morally!";
$varBannerOne   = "<a href=\"http://www.fatcow.com/join/index.bml?AffID=727583\" title=\"FatCow Hosting! THE BEST!\"><img src=\"./assets/images/fatcow.png\" border=\"0\" alt=\"Get Best Hosting In Teh World!\" /></a>";
$varBannerTwo   = "<a href=\"http://signup.leagueoflegends.com/?ref=52271a33c1464409534193\" title=\"Play League Of Legends!\"><img src=\"./assets/images/lol.png\" border=\"0\" alt=\"Play The Best Game In Teh World!\" /></a>";

// Create "Core" Elements.

$divWrapper     = new FDiv();
$divContainer   = new FDiv();
$divHeader      = new FDiv();
$divLeftSide    = new FDiv();
$divRightSide   = new FDiv();
$divDescription = new FDiv();
$tblFlagHolder  = new FTable();
$divContent     = new FDiv();
$fmContent      = new FForm();
$tblContent     = new FTable();
$divSupportOne  = new FDiv();
$divSupportTwo  = new FDiv();

// Create "Row" Elements.

$rowFlagsOne    = new FTableRow();
$rowFlagsTwo    = new FTableRow();
$rowSubmit      = new FTableRow();

// Create "Input" Elements.

$btnSubmit      = new FButton();

// "Banner One" Variable Settings.

$varTemp = @file_get_contents("http://www.frequency-cms.com/api/adverts.php?program=frequency&advert=1");

if (!empty($varTemp))
    $varBannerOne = $varTemp;

// "Banner Two" Variable Settings.

$varTemp = @file_get_contents("http://www.frequency-cms.com/api/adverts.php?program=frequency&advert=2");

if (!empty($varTemp))
    $varBannerTwo = $varTemp;

// "Div Wrapper" Element Settings.

$divWrapper->setID("wrapper");

$divWrapper->addElement($divContainer);

// "Div Container" Element Settings.

$divContainer->setID("main-container");
$divContainer->setClass("container");

$divContainer->addElement($divHeader);
$divContainer->addElement($divLeftSide);
$divContainer->addElement($divRightSide);
$divContainer->addElement(new FDiv(null, "clr"));

// "Div Header" Element Settings.

$divHeader->setID("header");

$divHeader->addElement(new FDiv("logo", null, new FDiv(null, "protector", "frequencyCMS")));
$divHeader->addElement(new FDiv("logo-title", null, $varPageTitle));
$divHeader->addElement(new FDiv("steps", null, $varStep));

// "Div Left Side" Element Settings.

$divLeftSide->setID("left-side");
$divLeftSide->setClass("side");

$divLeftSide->addElement($divDescription);
$divLeftSide->addElement($divContent);

// "Div Right Side" Element Settings.

$divRightSide->setID("right-side");
$divRightSide->setClass("side");

$divRightSide->addElement($divSupportOne);
$divRightSide->addElement($divSupportTwo);

// "Div Description" Element Settings.

$divDescription->setID("installer-description");
$divDescription->setClass("section");

$divDescription->addElement(new FHeader(1, $varDescrTitle));
$divDescription->addElement($tblFlagHolder);
$divDescription->addElement(new FParagraph($varLangSelect, FParagraph::ALN_CENTER));

// "Table Flag Holder" Element Settings.

$tblFlagHolder->setID("flag-holder");
$tblFlagHolder->setClass("default-table");
$tblFlagHolder->setAlignment(FTable::ALN_CENTER);

$tblFlagHolder->addRow($rowFlagsOne);
$tblFlagHolder->addRow($rowFlagsTwo);

// "Row Flags One" Element Settings.

$rowFlagsOne->setID("flags-one");

$rowFlagsOne->addCell(new FTableCell(null, null, new FAnchor("en-flag", "flag", "#", $varEN, "EN")));
$rowFlagsOne->addCell(new FTableCell(null, null, new FAnchor("rs-flag", "flag", "#", $varRS, "RS")));
$rowFlagsOne->addCell(new FTableCell(null, null, new FAnchor("de-flag", "flag", "#", $varDE, "DE")));

// "Row Flags Two" Element Settings.

$rowFlagsTwo->setID("flags-two");

$rowFlagsTwo->addCell(new FTableCell(null, null, new FAnchor("it-flag", "flag", "#", $varIT, "IT")));
$rowFlagsTwo->addCell(new FTableCell(null, null, new FAnchor("ru-flag", "flag", "#", $varRU, "RU")));
$rowFlagsTwo->addCell(new FTableCell(null, null, new FAnchor("gr-flag", "flag", "#", $varGR, "GR")));

// "Div Content" Element Settings.

$divContent->setID("installer-content");
$divContent->setClass("section");

$divContent->addElement(new FHeader(1, $varContTitle . " - " . $varStep));
$divContent->addElement(new FParagraph($varParaOne));
$divContent->addElement($fmContent);

// "Form Content" Element Settings.

$fmContent->setID("installation-form");
$fmContent->setClass("default-form");
$fmContent->setMethod(FForm::MTD_GET);
$fmContent->setAction("step-2.php");

$fmContent->addItem($tblContent);

// "Table Content" Element Settings.

$tblContent->setID("info-table");
$tblContent->setClass("default-table");

$tblContent->addRow($rowSubmit);

// "Row Submit" Element Settings.

$rowSubmit->addCell(new FTableCell(null, null, $btnSubmit, null, null, FTableCell::ALN_RIGHT));

// "Input Submit" Element Settings.

$btnSubmit->setID("installation-button");
$btnSubmit->setClass("form-button");
$btnSubmit->setType(FInput::TP_SUBMIT);
$btnSubmit->setContent($varButtonValue);

// "Div Support One" Element Settings.

$divSupportOne->setID("support-one");
$divSupportOne->setClass("section");

$divSupportOne->addElement(new FHeader(1, $varSupportOne));
$divSupportOne->addElement(new FDiv(null, "banner", $varBannerOne));
$divSupportOne->addElement(new FParagraph($varSuppInfoOne));

// "Div Support Two" Element Settings.

$divSupportTwo->setID("support-two");
$divSupportTwo->setClass("section");

$divSupportTwo->addElement(new FHeader(1, $varSupportTwo));
$divSupportTwo->addElement(new FDiv(null, "banner", $varBannerTwo));
$divSupportTwo->addElement(new FParagraph($varSuppInfoTwo));

// Build Elements.

Build::element("<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">");
Build::element("<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en-gb\" lang=\"en-gb\" id=\"installation-page\" >");
Build::element("<head>", "    ");
Build::element("<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" />\n", "        ");
Build::element("<meta name=\"author\" content=\"Đorđe Jocić (Djordje Jocic)\" />\n", "        ");
Build::element("<meta name=\"keywords\" content=\"frequency, free, open source, cms, dynamic portal, content management, digital publishing, open source, agpl, security, community\" />", "        ");
Build::element("<meta name=\"description\" content=\"Frequency CMS is an open-source software solution for fast and easy dynamic web-site and portal developing.\" />", "        ");
Build::element("<meta name=\"generator\" content=\"Frequency CMS - Open Source Content Management System\" />\n", "        ");
Build::element("<link rel=\"icon\" href=\"/system/assets/images/favicon.ico\" type=\"image/x-icon\" />\n", "        ");
Build::element("<title>$varHeadTitle</title>\n", "        ");
Build::element("<link href=\"./assets/theme.css\" rel=\"stylesheet\" type=\"text/css\" />", "        ");
Build::element("</head>\n", "    ");
Build::element("<body>\n", "    ");
Build::element($divWrapper, "        ");
Build::element("</body>", "    ");
Build::element("</html>");

?>