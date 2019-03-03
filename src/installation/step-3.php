<?php

/***********************************************************\
|* Frequency CMS v1.0.0                                    *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: step-3.php                                    *|
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
{
    $_SESSION["step"] = 1;
    
    exit(header("location: index.php"));
}
else if ($_SESSION["step"] != 3)
{
    if ($_SESSION["step"] == 1)
       exit(header("location: index.php"));
    else if ($_SESSION["step"] == 2)
        $_SESSION["step"] = 3;
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

// Include The Processor.

require_once "./scripts/processors/processor_step_3.php";

// Create "Core" Variables.

$varHeadTitle   = "frequencyCMS » Free And Open Source CMS « frequency-cms.com";
$varPageTitle   = "frequencyCMS Installation";
$varStep        = "Step #3";
$varDescrTitle  = "Description";
$varParaOne     = "Before you start using <strong>frequencyCMS</strong> a database needs to be configured. Please enter your correct MySQL server information in the form bellow, after that press the button \"next\" or \"try again\". If you don't know how to finish this step, please check the official <strong>frequencyCMS</strong> site or read the instruction manual.";
$varErrorTitle  = "Error";
$varParaTwo     = "Either the information you entered is not correct or you don't have the read/write rights for the MySQL server configuration file.";
$varContTitle   = "Installation";
$varParaThree   = "After clicking on the \"next\" button, <strong>frequencyCMS</strong> installer will create a database config file.";
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
$divError       = new FDiv();
$divContent     = new FDiv();
$fmContent      = new FForm();
$tblContent     = new FTable();
$divSupportOne  = new FDiv();
$divSupportTwo  = new FDiv();

// Create "Row" Elements.

$rowHostname    = new FTableRow();
$rowUsername    = new FTableRow();
$rowPassword    = new FTableRow();
$rowName        = new FTableRow();
$rowTablePrefix = new FTableRow();
$rowViewPrefix  = new FTableRow();
$rowSubmit      = new FTableRow();

// Create "Input" Elements.

$inpHostname    = new FInput();
$inpUsername    = new FInput();
$inpPassword    = new FInput();
$inpName        = new FInput();
$inpTablePrefix = new FInput();
$inpViewPrefix  = new FInput();
$btnSubmit      = new FButton();

// "Button Value" Variable Settings.

if (!$varPassed)
    $varButtonValue = "Try Again";

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

if (!$varPassed)
    $divLeftSide->addElement($divError);

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
$divDescription->addElement(new FParagraph($varParaOne));

// "Div Error" Element Settings.

$divError->setID("installer-error");
$divError->setClass("section");

$divError->addElement(new FHeader(1, $varErrorTitle));
$divError->addElement(new FParagraph($varParaTwo));

// "Div Content" Element Settings.

$divContent->setID("installer-content");
$divContent->setClass("section");

$divContent->addElement(new FHeader(1, $varContTitle . " - " . $varStep));

$divContent->addElement($fmContent);
$divContent->addElement(new FParagraph($varParaThree, FParagraph::ALN_CENTER));

// "Form Content" Element Settings.

$fmContent->setID("installation-form");
$fmContent->setClass("default-form");
$fmContent->setMethod(FForm::MTD_POST);
$fmContent->setAction("step-3.php");

$fmContent->addItem($tblContent);

// "Table Content" Element Settings.

$tblContent->setID("installation-table");
$tblContent->setClass("default-table");

$tblContent->addRow($rowHostname);
$tblContent->addRow($rowUsername);
$tblContent->addRow($rowPassword);
$tblContent->addRow($rowName);
$tblContent->addRow($rowTablePrefix);
$tblContent->addRow($rowViewPrefix);
$tblContent->addRow($rowSubmit);

// "Row Hostname" Element Settings.

$rowHostname->addCell(new FTableCell(null, null, "Database Hostname"));
$rowHostname->addCell(new FTableCell(null, null, $inpHostname));

// "Row Username" Element Settings.

$rowUsername->addCell(new FTableCell(null, null, "Database Username"));
$rowUsername->addCell(new FTableCell(null, null, $inpUsername));

// "Row Password" Element Settings.

$rowPassword->addCell(new FTableCell(null, null, "Database Password"));
$rowPassword->addCell(new FTableCell(null, null, $inpPassword));

// "Row Password" Element Settings.

$rowName->addCell(new FTableCell(null, null, "Database Name"));
$rowName->addCell(new FTableCell(null, null, $inpName));

// "Row Table Prefix" Element Settings.

$rowTablePrefix->addCell(new FTableCell(null, null, "Database Table Preifx"));
$rowTablePrefix->addCell(new FTableCell(null, null, $inpTablePrefix));

// "Row View Prefix" Element Settings.

$rowViewPrefix->addCell(new FTableCell(null, null, "Database View Preifx"));
$rowViewPrefix->addCell(new FTableCell(null, null, $inpViewPrefix));

// "Row Submit" Element Settings.

$rowSubmit->addCell(new FTableCell(null, null, $btnSubmit, 2, null, FTableCell::ALN_RIGHT));

// "Input Hostname" Element Settings.

$inpHostname->setID("hostname-input");
$inpHostname->setClass("form-input");
$inpHostname->setMaxLength(50);
$inpHostname->setType(FInput::TP_TEXT);
$inpHostname->setName("req_hostname");
$inpHostname->setContent("localhost");

// "Input Username" Element Settings.

$inpUsername->setID("username-input");
$inpUsername->setClass("form-input");
$inpUsername->setMaxLength(20);
$inpUsername->setType(FInput::TP_TEXT);
$inpUsername->setName("req_username");
$inpUsername->setContent("root");

// "Input Password" Element Settings.

$inpPassword->setID("password-input");
$inpPassword->setClass("form-input");
$inpPassword->setMaxLength(50);
$inpPassword->setType(FInput::TP_PASSWORD);
$inpPassword->setName("req_password");

// "Input Name" Element Settings.

$inpName->setID("name-input");
$inpName->setClass("form-input");
$inpName->setMaxLength(20);
$inpName->setType(FInput::TP_TEXT);
$inpName->setName("req_name");
$inpName->setContent("frequency_demo");

// "Input Table Prefix" Element Settings.

$inpTablePrefix->setID("table-prefix-input");
$inpTablePrefix->setClass("form-input");
$inpTablePrefix->setMaxLength(5);
$inpTablePrefix->setType(FInput::TP_TEXT);
$inpTablePrefix->setName("req_table_prefix");
$inpTablePrefix->setContent("fdbt_");

// "Input View Prefix" Element Settings.

$inpViewPrefix->setID("view-prefix-input");
$inpViewPrefix->setClass("form-input");
$inpViewPrefix->setMaxLength(5);
$inpViewPrefix->setType(FInput::TP_TEXT);
$inpViewPrefix->setName("req_view_prefix");
$inpViewPrefix->setContent("fdbv_");

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