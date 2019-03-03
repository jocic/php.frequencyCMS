<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: links.php                                     *|
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

// Create "Core" Variable.

$varCoreLink = CMS_ROOT .
               "?" .
               Locales::getVariable("page") .
               "=" .
               Locales::getLink("site-administration") .
               "&" .
               Locales::getVariable("workplace") .
               "=" .
               Locales::getLink("links");

if (!empty($_GET[Locales::getVariable("option")])) // If Option Selected.
{
    if ($_GET[Locales::getVariable("option")] == Locales::getLink("arrange-menu-items")) // If "Arrange Menu Items" Selected.
    {
        // Create "Core" Variables.
        
        $varMenuItems            = null;
        $varMoveUpPrefix         = "<a id=\"move-up-icon\" class=\"options-icon\" title=\"" . Locales::getCore("move-up") . "\" href=\" " .  $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("move-up") . "&" . Locales::getVariable("id") . "=";
        $varMoveUpSufix          = "\">" . Locales::getCore("move-up") . "</a>";
        $varMoveDownPrefix       = "<a id=\"move-down-icon\" class=\"options-icon\" title=\"" . Locales::getCore("move-down") . "\" href=\" " .  $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("move-down") . "&" . Locales::getVariable("id") . "=";
        $varMoveDownSufix        = "\">" . Locales::getCore("move-down") . "</a>";
        $varEditMenuItemPrefix   = "<a id=\"edit-icon\" class=\"options-icon\" title=\"" . Locales::getCore("edit-menu-item") . "\" href=\" " .  $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-menu-item") . "&" . Locales::getVariable("id") . "=";
        $varEditMenuItemSufix    = "\">" . Locales::getCore("edit-menu-item") . "</a>";
        $varDeleteMenuItemPrefix = "<a id=\"delete-icon\" class=\"options-icon\" title=\"" . Locales::getCore("delete-menu-item") . "\" href=\" " .  $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("delete-menu-item") . "&" . Locales::getVariable("id") . "=";
        $varDeleteMenuItemSufix  = "\">" . Locales::getCore("delete-menu-item") . "</a>";
        
        // Create "Core" Elements.
        
        $hdArrangeMenuItems      = new FHeader();
        $parMenuItemsInfo        = new FParagraph();
        $tblArrangeMenuItems     = new FTable();
        
        // Create "Row" Elements.
        
        $rowMenuItemsInfo        = new FTableRow();
        
        // "Menu Items" Variable Settings.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

        EasyGet::setOrderBy("position", EasyGet::OB_ASC);

        $varMenuItems = EasyGet::execute
        (
            "TS: menu_items",
            "CS: id, title, type, position",
            "ARGS: menu_id = " . $_GET[Locales::getVariable("id")]
        );
        
        // "Header Arrange Menu Items" Element Settings.
        
        $hdArrangeMenuItems->setLevel(2);
        $hdArrangeMenuItems->setContent(Locales::getCore("arrange-menu-items"));
        
        // "Paragraph Menu Items Info" Element Settings.
        
        $parMenuItemsInfo->setID("menu-items-info");
        $parMenuItemsInfo->setClass("info-paragraph");
        $parMenuItemsInfo->setAlignment(FParagraph::ALN_CENTER);
        $parMenuItemsInfo->setContent(Locales::getParagraph("no-menu-items"));
        
        // "Table Arrange Menu Items" Element Settings.
        
        $tblArrangeMenuItems->setID("arrange-menu-items-table");
        $tblArrangeMenuItems->setClass("default-admin-table");
        $tblArrangeMenuItems->setAlignment(FTable::ALN_CENTER);
        
        $tblArrangeMenuItems->addRow($rowMenuItemsInfo);
        
        if ($varMenuItems != null)
        {
            foreach ($varMenuItems as $varMenuItem)
            {
                // Create "Temp" Variables.

                $varTempOptions = null;

                // Create "Temp" Elements.

                $varTempRow     = new FTableRow();

                // "Temp Options" Variable Settings..

                $varTempOptions = $varMoveUpPrefix . $varMenuItem["id"] . $varMoveUpSufix . " " . $varMoveDownPrefix . $varMenuItem["id"] . $varMoveDownSufix . " " . $varEditMenuItemPrefix . $varMenuItem["id"] . $varEditMenuItemSufix . " " . $varDeleteMenuItemPrefix . $varMenuItem["id"] . $varDeleteMenuItemSufix;
                
                // Process "Type" Variable.

               if ($varMenuItem["type"] == Menus::MI_TITLE)
                   $varMenuItem["type"] = Locales::getCore("title");
               else if ($varMenuItem["type"] == Menus::MI_SEPARATOR)
                   $varMenuItem["type"] = Locales::getCore("separator");
               else if ($varMenuItem["type"] == Menus::MI_MENU)
                   $varMenuItem["type"] = Locales::getCore("menu");
               else if ($varMenuItem["type"] == Menus::MI_CORE_ITEM)
                   $varMenuItem["type"] = Locales::getCore("core-item");
               else if ($varMenuItem["type"] == Menus::MI_CUSTOM_ITEM)
                   $varMenuItem["type"] = Locales::getCore("custom-item");
               
                // "Temp Row" Element Settings.

                $varTempRow->addCell(new FTableCell(null, "table-cell-id", $varMenuItem["id"]));
                $varTempRow->addCell(new FTableCell(null, "table-cell-title", $varMenuItem["title"]));
                $varTempRow->addCell(new FTableCell(null, "table-cell-type", $varMenuItem["type"]));
                $varTempRow->addCell(new FTableCell(null, "table-cell-position", $varMenuItem["position"]));
                $varTempRow->addCell(new FTableCell(null, "table-cell-options", $varTempOptions));

                // Append Elements To "Table Arrange Menu Items" Element.

                $tblArrangeMenuItems->addRow($varTempRow);
            }
        }
        
        // "Row Menu Items Info" Element Settings.
        
        $rowMenuItemsInfo->setID("menu-items-info-row");
        $rowMenuItemsInfo->setClass("info-row");

        $rowMenuItemsInfo->addCell(new FTableCell(null, "table-cell-id", "#"));
        $rowMenuItemsInfo->addCell(new FTableCell(null, "table-cell-title", Locales::getCore("title")));
        $rowMenuItemsInfo->addCell(new FTableCell(null, "table-cell-type", Locales::getCore("type")));
        $rowMenuItemsInfo->addCell(new FTableCell(null, "table-cell-position", Locales::getCore("position")));
        $rowMenuItemsInfo->addCell(new FTableCell(null, "table-cell-options", Locales::getCore("options")));
        
        // Append Elements To "Workplace" Element.

        $divWorkplace->addElement($hdArrangeMenuItems);

        if ($varMenuItems == null)
            $divWorkplace->addElement($parMenuItemsInfo);
        else  
            $divWorkplace->addElement($tblArrangeMenuItems);
    }
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("add-menu")) // If "Add Menu" Selected.
    {
        // Create "Core" Variables.

        $varName  = null;
        $varTitle = null;
        
        // Create "Core" Elements.

        $hdAddMenu  = new FHeader();
        $fmAddMenu  = new FForm();
        $tblAddMenu = new FTable();
        
        // Create "Row" Elements.
        
        $rowName    = new FTableRow();
        $rowTitle   = new FTableRow();
        $rowSubmit  = new FTableRow();
        
        // Create "Input" Elements.
        
        $inpName    = new FInput();
        $inpTitle   = new FInput();
        $btnReset   = new FButton();
        $btnSubmit  = new FButton();

        // "Name" Variable Settings.

        if (!empty($_POST["req_name"]))
            $varName = $_POST["req_name"];
        
        // "Title" Variable Settings.

        if (!empty($_POST["req_title"]))
            $varTitle = $_POST["req_title"];

        // "Header Add Menu" Element Settings.
        
        $hdAddMenu->setLevel(2);
        $hdAddMenu->setContent(Locales::getCore("add-menu"));
        
        // "Form Add Menu" Element Settings.

        $fmAddMenu->setID("add-menu-form");
        $fmAddMenu->setClass("default-form");
        $fmAddMenu->setMethod(FForm::MTD_POST);
        $fmAddMenu->setAction($varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("add-menu"));

        $fmAddMenu->addItem($tblAddMenu);
        
        // "Table Add Menu" Element Settings.
        
        $tblAddMenu->setID("add-menu-table");
        $tblAddMenu->setClass("default-admin-table");
        $tblAddMenu->setAlignment(FTable::ALN_CENTER);
        
        $tblAddMenu->addRow($rowName);
        $tblAddMenu->addRow($rowTitle);
        $tblAddMenu->addRow($rowSubmit);
        
        // "Row Name" Element Settings.
        
        $rowName->addCell(new FTableCell(null, null, new FLabel("name", Locales::getCore("name"))));
        $rowName->addCell(new FTableCell(null, null, $inpName));
        
        // "Row Title" Element Settings.
        
        $rowTitle->addCell(new FTableCell(null, null, new FLabel("title", Locales::getCore("title"))));
        $rowTitle->addCell(new FTableCell(null, null, $inpTitle));
        
        // "Row Submit" Element Settings.
        
        $rowSubmit->addCell(new FTableCell(null, null, array($btnReset, $btnSubmit), 2, null, FTableCell::ALN_RIGHT));
        
        // "Input Name" Element Settings.
        
        $inpName->setID("menu-name-input");
        $inpName->setClass("form-input");
        $inpName->setType(FInput::TP_TEXT);
        $inpName->setMaxLength(50);
        $inpName->setContent($varName);
        $inpName->setName("req_name");
        
        // "Input Title" Element Settings.
        
        $inpTitle->setID("menu-title-input");
        $inpTitle->setClass("form-input");
        $inpTitle->setType(FInput::TP_TEXT);
        $inpTitle->setMaxLength(50);
        $inpTitle->setContent($varTitle);
        $inpTitle->setName("req_title");
        
        // "Button Reset" Element Settings.
        
        $btnReset->setID("pages-reset-button");
        $btnReset->setClass("form-button");
        $btnReset->setType(FButton::TP_RESET);
        $btnReset->setContent(Locales::getCore("reset"));
        
        // "Button Submit" Element Settings.

        $btnSubmit->setID("add-menu-button");
        $btnSubmit->setClass("form-button");
        $btnSubmit->setType(FInput::TP_SUBMIT);
        $btnSubmit->setContent(Locales::getCore("add"));

        // Append Elements To "Workplace" Element.

        $divWorkplace->addElement($hdAddMenu);
        $divWorkplace->addElement($fmAddMenu);
    }
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("edit-menu")) // If "Edit Menu" Selected.
    {   
        // Create "Core" Variables.
        
        $varMenu     = null;
        
        // Create "Core" Elements.
        
        $hdEditMenu  = new FHeader();
        $fmEditMenu  = new FForm();
        $tblEditMenu = new FTable();
        
        // Create "Row" Elements.
        
        $rowName    = new FTableRow();
        $rowTitle   = new FTableRow();
        $rowSubmit  = new FTableRow();
        
        // Create "Input" Elements.
        
        $inpName    = new FInput();
        $inpTitle   = new FInput();
        $btnReset   = new FButton();
        $btnSubmit  = new FButton();
        
        // "Menu" Variable Settings.

        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

        $varMenu = EasyGet::execute
        (
            "TS: menus",
            "CS: *",
            "ARGS: id = " . $_GET[Locales::getVariable("id")]
        );
        
        // "Header Edit Menu" Element Settings.
        
        $hdEditMenu->setLevel(2);
        $hdEditMenu->setContent(Locales::getCore("edit-menu"));

        // "Form Edit Menu" Element Settings.

        $fmEditMenu->setID("add-menu-form");
        $fmEditMenu->setClass("default-form");
        $fmEditMenu->setMethod(FForm::MTD_POST);
        $fmEditMenu->setAction($varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-menu") . "&" . Locales::getVariable("id") . "=" . $_GET[Locales::getVariable("id")]);

        $fmEditMenu->addItem($tblEditMenu);
        
        // "Table Edit Menu" Element Settings.
        
        $tblEditMenu->setID("edit-menu-table");
        $tblEditMenu->setClass("default-admin-table");
        $tblEditMenu->setAlignment(FTable::ALN_CENTER);
        
        $tblEditMenu->addRow($rowName);
        $tblEditMenu->addRow($rowTitle);
        $tblEditMenu->addRow($rowSubmit);
        
        // "Row Name" Element Settings.
        
        $rowName->addCell(new FTableCell(null, null, new FLabel("name", Locales::getCore("name"))));
        $rowName->addCell(new FTableCell(null, null, $inpName));
        
        // "Row Title" Element Settings.
        
        $rowTitle->addCell(new FTableCell(null, null, new FLabel("title", Locales::getCore("title"))));
        $rowTitle->addCell(new FTableCell(null, null, $inpTitle));
        
        // "Row Submit" Element Settings.
        
        $rowSubmit->addCell(new FTableCell(null, null, array($btnReset, $btnSubmit), 2, null, FTableCell::ALN_RIGHT));
        
        // "Input Name" Element Settings.
        
        $inpName->setID("menu-name-input");
        $inpName->setClass("form-input");
        $inpName->setType(FInput::TP_TEXT);
        $inpName->setMaxLength(50);
        $inpName->setContent($varMenu[0]["name"]);
        $inpName->setName("req_name");
        
        // "Input Title" Element Settings.
        
        $inpTitle->setID("menu-title-input");
        $inpTitle->setClass("form-input");
        $inpTitle->setType(FInput::TP_TEXT);
        $inpTitle->setMaxLength(50);
        $inpTitle->setContent($varMenu[0]["title"]);
        $inpTitle->setName("req_title");
        
        // "Button Reset" Element Settings.
        
        $btnReset->setID("pages-reset-button");
        $btnReset->setClass("form-button");
        $btnReset->setType(FButton::TP_RESET);
        $btnReset->setContent(Locales::getCore("reset"));
        
        // "Button Submit" Element Settings.

        $btnSubmit->setID("add-menu-button");
        $btnSubmit->setClass("form-button");
        $btnSubmit->setType(FInput::TP_SUBMIT);
        $btnSubmit->setContent(Locales::getCore("edit"));

        // Append Elements To "Workplace" Element.

        $divWorkplace->addElement($hdEditMenu);
        $divWorkplace->addElement($fmEditMenu);
    }
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("add-menu-item")) // If "Add Menu Item" Selected.
    {
        // Create "Core" Variables.
        
        $varMenus           = null;
        $varLinks           = null;
        $varItemTitle       = null;
        $varItemType        = null;
        $varItemParent      = null;
        $varCustomContent   = null;
        
        // Create "Core" Elements.
        
        $hdAddMenuItem      = new FHeader();
        $fmAddMenuItem      = new FForm();
        $tblAddMenuItem     = new FTable();
        
        // Create "Row" Elements.
        
        $rowTitle           = new FTableRow();
        $rowType            = new FTableRow();
        $rowParent          = new FTableRow();
        $rowChildMenu       = new FTableRow();
        $rowChildItem       = new FTableRow();
        $rowCustomChildItem = new FTableRow();
        $rowSubmit          = new FTableRow();
        
        // Create "Input" Elements.
        
        $inpTitle           = new FInput();
        $selType            = new FSelect();
        $selParent          = new FSelect();
        $selMenus           = new FSelect();
        $selItems           = new FSelect();
        $inpCustom          = new FInput();
        $btnReset           = new FButton();
        $btnSubmit          = new FButton();
        
        // "Menus" Variable Settings.

        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

        $varMenus = EasyGet::execute
        (
            "TS: menus",
            "CS: id, title"
        );
        
        // "Links" Variable Settings.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

        $varLinks = EasyGet::execute
        (
            "TS: pages",
            "CS: id, title"
        );
        
        // "Item Title" Variable Settings.

        if (!empty($_POST["req_title"]))
            $varItemTitle = $_POST["req_title"];
        
        // "Item Type" Variable Settings.

        if (!empty($_POST["req_type"]))
            $varItemType = $_POST["req_type"];
        
        // "Item Parent" Variable Settings.

        if (!empty($_POST["req_parent"]))
            $varItemParent = $_POST["req_parent"];
        
        // "Menu Selected" Variable Settings.

        if (!empty($_POST["req_menu"]))
            $varMenuSelected = $_POST["req_menu"];
        
        // "Link Selected" Variable Settings.

        if (!empty($_POST["req_link"]))
            $varLinkSelected = $_POST["req_link"];
        
        // "Custom Content" Variable Settings.

        if (!empty($_POST["req_custom"]))
            $varCustomContent = $_POST["req_custom"];
        
        // "Header Add Menu Item" Element Settings.
        
        $hdAddMenuItem->setLevel(2);
        $hdAddMenuItem->setContent(Locales::getCore("add-menu-item"));

        // "Form Add Menu Item" Element Settings.

        $fmAddMenuItem->setID("add-link-form");
        $fmAddMenuItem->setClass("default-form");
        $fmAddMenuItem->setMethod("post");
        $fmAddMenuItem->setAction($varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("add-menu-item"));

        $fmAddMenuItem->addItem($tblAddMenuItem);
        
        // "Table Add Menu Item" Element Settings.

        $tblAddMenuItem->setID("add-menu-item-table");
        $tblAddMenuItem->setClass("default-admin-table");
        $tblAddMenuItem->setAlignment(FTable::ALN_CENTER);
        
        $tblAddMenuItem->addRow($rowTitle);
        $tblAddMenuItem->addRow($rowType);
        $tblAddMenuItem->addRow($rowParent);
        $tblAddMenuItem->addRow($rowChildMenu);
        $tblAddMenuItem->addRow($rowChildItem);
        $tblAddMenuItem->addRow($rowCustomChildItem);
        $tblAddMenuItem->addRow($rowSubmit);
        
        // "Row Title" Element Settings.
        
        $rowTitle->setID("menu-item-title");
        $rowTitle->addCell(new FTableCell(null, null, new FLabel("title", Locales::getCore("title"))));
        $rowTitle->addCell(new FTableCell(null, null, $inpTitle));
        
        // "Row Type" Element Settings.
        
        $rowType->setID("menu-item-type");
        $rowType->addCell(new FTableCell(null, null, new FLabel("type", Locales::getCore("type"))));
        $rowType->addCell(new FTableCell(null, null, $selType));
        
        // "Row Parent" Element Settings.
        
        $rowParent->setID("menu-item-parent");
        $rowParent->addCell(new FTableCell(null, null, new FLabel("parent", Locales::getCore("parent"))));
        $rowParent->addCell(new FTableCell(null, null, $selParent));
        
        // "Row Child Menu" Element Settings.
        
        $rowChildMenu->setID("child-menu-selector");
        $rowChildMenu->addCell(new FTableCell(null, null, new FLabel("child-menu", Locales::getCore("child-menu"))));
        $rowChildMenu->addCell(new FTableCell(null, null, $selMenus));
        
        // "Row Child Item" Element Settings.
        
        $rowChildItem->setID("child-item-selector");
        $rowChildItem->addCell(new FTableCell(null, null, new FLabel("child-item", Locales::getCore("child-item"))));
        $rowChildItem->addCell(new FTableCell(null, null, $selItems));
        
        // "Row Custom Child Item" Element Settings.
        
        $rowCustomChildItem->setID("child-item-selector");
        $rowCustomChildItem->addCell(new FTableCell(null, null, new FLabel("custom-child-item", Locales::getCore("custom-child-item"))));
        $rowCustomChildItem->addCell(new FTableCell(null, null, $inpCustom));
        
        // "Row Submit" Element Settings.
        
        $rowSubmit->setID("add-menu-item-row");
        $rowSubmit->addCell(new FTableCell(null, null, array($btnReset, $btnSubmit), 2, 0, FTableCell::ALN_RIGHT));
        
        // "Input Title" Element Settings.
        
        $inpTitle->setID("menu-item-title-input");
        $inpTitle->setClass("form-input");
        $inpTitle->setType(FInput::TP_TEXT);
        $inpTitle->setMaxLength(50);
        $inpTitle->setContent($varItemTitle);
        $inpTitle->setName("req_title");
        
        // "Select Type" Element Settings.
        
        $selType->setClass("form-select");
        $selType->addOption(new FSelectOption(0, Locales::getCore("title"), false));
        $selType->addOption(new FSelectOption(1, Locales::getCore("separator"), false));
        $selType->addOption(new FSelectOption(2, Locales::getCore("menu"), false));
        $selType->addOption(new FSelectOption(3, Locales::getCore("core-item"), false));
        $selType->addOption(new FSelectOption(4, Locales::getCore("custom-item"), false));
        $selType->setName("req_type");
        
        // "Select Parent" Element Settings.
        
        $selParent->setClass("form-select");
        
        foreach ($varMenus as $varMenu)
            $selParent->addOption(new FSelectOption($varMenu["id"], $varMenu["title"], false));
        
        $selParent->setName("req_parent");

        // "Select Menus" Element Settings.
        
        $selMenus->setClass("form-select");
        
        foreach ($varMenus as $varMenu)
            $selMenus->addOption(new FSelectOption($varMenu["id"], $varMenu["title"], false));
        
        $selMenus->setName("req_menus");
        
        // "Select Items" Element Settings.
        
        $selItems->setClass("form-select");
        
        $selItems->addOption(new FSelectOption("homepage", " - " . Locales::getTitle("home-page"), false));
        $selItems->addOption(new FSelectOption("registration", " - " . Locales::getTitle("registration"), false));
        $selItems->addOption(new FSelectOption("log-in", " - " . Locales::getTitle("log-in"), false));
        $selItems->addOption(new FSelectOption("messages", " - " . Locales::getTitle("messages"), false));
        $selItems->addOption(new FSelectOption("your-profile", " - " . Locales::getTitle("your-profile"), false));
        $selItems->addOption(new FSelectOption("site-administration", " - " . Locales::getTitle("site-administration"), false));

        foreach ($varLinks as $varLink)
            $selItems->addOption(new FSelectOption($varLink["id"], $varLink["title"], false));
        
        $selItems->setName("req_items");
        
        // "Input Custom" Element Settings.
        
        $inpCustom->setID("custom-menu-item-input");
        $inpCustom->setClass("form-input");
        $inpCustom->setType(FInput::TP_TEXT);
        $inpCustom->setMaxLength(125);
        $inpCustom->setContent($varCustomContent);
        $inpCustom->setName("req_custom");
        
        // "Button Reset" Element Settings.

        $btnReset->setID("add-menu-item-reset-button");
        $btnReset->setClass("form-button");
        $btnReset->setType(FButton::TP_RESET);
        $btnReset->setContent(Locales::getCore("reset"));

        // "Button Submit" Element Settings.

        $btnSubmit->setID("add-menu-item-submit-button");
        $btnSubmit->setClass("form-button");
        $btnSubmit->setType(FButton::TP_SUBMIT);
        $btnSubmit->setContent(Locales::getCore("add"));

        // Append Elements To "Workplace" Element.

        $divWorkplace->addElement($hdAddMenuItem);
        $divWorkplace->addElement($fmAddMenuItem);
    }
    else if ($_GET[Locales::getVariable("option")] == Locales::getLink("edit-menu-item")) // If "Edit Menu Item" Selected.
    {
        // Create "Core" Variables.
        
        $varItemID          = null;
        $varMenuItem        = null;
        $varMenus           = null;
        $varLinks           = null;
        $varItemTitle       = null;
        $varItemType        = null;
        $varItemParent      = null;
        $varCustomContent   = null;
        
        // Create "Core" Elements.
        
        $hdEditMenuItem     = new FHeader();
        $fmEditMenuItem     = new FForm();
        $tblEditMenuItem    = new FTable();
        
        // Create "Row" Elements.
        
        $rowTitle           = new FTableRow();
        $rowType            = new FTableRow();
        $rowParent          = new FTableRow();
        $rowChildMenu       = new FTableRow();
        $rowChildItem       = new FTableRow();
        $rowCustomChildItem = new FTableRow();
        $rowSubmit          = new FTableRow();
        
        // Create "Input" Elements.
        
        $inpTitle           = new FInput();
        $selType            = new FSelect();
        $selParent          = new FSelect();
        $selMenus           = new FSelect();
        $selItems           = new FSelect();
        $inpCustom          = new FInput();
        $btnReset           = new FButton();
        $btnSubmit          = new FButton();
        
        // "Item ID" Variable Settings.
        
        $varItemID = $_GET[Locales::getVariable("id")];
        
        // "Menu Item" Variable Settings.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

        $varMenuItem = EasyGet::execute
        (
            "TS: menu_items",
            "CS: title, value, type, menu_id",
            "ARGS: id = " . $varItemID
        );
        
        // "Menus" Variable Settings.

        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

        $varMenus = EasyGet::execute
        (
            "TS: menus",
            "CS: id, title"
        );
        
        // "Links" Variable Settings.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

        $varLinks = EasyGet::execute
        (
            "TS: pages",
            "CS: id, title"
        );
        
        // "Item Title" Variable Settings.

        if (!empty($_POST["req_title"]))
            $varItemTitle = $_POST["req_title"];
        else
             $varItemTitle = $varMenuItem[0]["title"];
        
        // "Item Type" Variable Settings.

        if (!empty($_POST["req_type"]))
            $varItemType = $_POST["req_type"];
        else
            $varItemType = $varMenuItem[0]["type"];
        
        // "Item Parent" Variable Settings.

        if (!empty($_POST["req_parent"]))
            $varItemParent = $_POST["req_parent"];
        else
            $varItemParent = $varMenuItem[0]["menu_id"];
        
        // "Menu Selected" Variable Settings.

        if (!empty($_POST["req_menu"]))
            $varMenuSelected = $_POST["req_menu"];
        
        // "Link Selected" Variable Settings.

        if (!empty($_POST["req_link"]))
            $varLinkSelected = $_POST["req_link"];
        
        // "Custom Content" Variable Settings.

        if (!empty($_POST["req_custom"]))
            $varCustomContent = $_POST["req_custom"];
        else if ($varItemType == Menus::MI_CUSTOM_ITEM)
            $varCustomContent = $varMenuItem[0]["value"];
        
        // "Header Edit Menu Item" Element Settings.
        
        $hdEditMenuItem->setLevel(2);
        $hdEditMenuItem->setContent(Locales::getCore("edit-menu-item"));

        // "Form Edit Menu Item" Element Settings.

        $fmEditMenuItem->setID("add-link-form");
        $fmEditMenuItem->setClass("default-form");
        $fmEditMenuItem->setMethod("post");
        $fmEditMenuItem->setAction($varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-menu-item") . "&" . Locales::getVariable("id") . "=" . $varItemID);

        $fmEditMenuItem->addItem($tblEditMenuItem);
        
        // "Table Add Menu Item" Element Settings.

        $tblEditMenuItem->setID("add-menu-item-table");
        $tblEditMenuItem->setClass("default-admin-table");
        $tblEditMenuItem->setAlignment(FTable::ALN_CENTER);
        
        $tblEditMenuItem->addRow($rowTitle);
        $tblEditMenuItem->addRow($rowType);
        $tblEditMenuItem->addRow($rowParent);
        $tblEditMenuItem->addRow($rowChildMenu);
        $tblEditMenuItem->addRow($rowChildItem);
        $tblEditMenuItem->addRow($rowCustomChildItem);
        $tblEditMenuItem->addRow($rowSubmit);
        
        // "Row Title" Element Settings.
        
        $rowTitle->setID("menu-item-title");
        $rowTitle->addCell(new FTableCell(null, null, new FLabel("title", Locales::getCore("title"))));
        $rowTitle->addCell(new FTableCell(null, null, $inpTitle));
        
        // "Row Type" Element Settings.
        
        $rowType->setID("menu-item-type");
        $rowType->addCell(new FTableCell(null, null, new FLabel("type", Locales::getCore("type"))));
        $rowType->addCell(new FTableCell(null, null, $selType));
        
        // "Row Parent" Element Settings.
        
        $rowParent->setID("menu-item-parent");
        $rowParent->addCell(new FTableCell(null, null, new FLabel("parent", Locales::getCore("parent"))));
        $rowParent->addCell(new FTableCell(null, null, $selParent));
        
        // "Row Child Menu" Element Settings.
        
        $rowChildMenu->setID("child-menu-selector");
        $rowChildMenu->addCell(new FTableCell(null, null, new FLabel("child-menu", Locales::getCore("child-menu"))));
        $rowChildMenu->addCell(new FTableCell(null, null, $selMenus));
        
        // "Row Child Item" Element Settings.
        
        $rowChildItem->setID("child-item-selector");
        $rowChildItem->addCell(new FTableCell(null, null, new FLabel("child-item", Locales::getCore("child-item"))));
        $rowChildItem->addCell(new FTableCell(null, null, $selItems));
        
        // "Row Custom Child Item" Element Settings.
        
        $rowCustomChildItem->setID("child-item-selector");
        $rowCustomChildItem->addCell(new FTableCell(null, null, new FLabel("custom-child-item", Locales::getCore("custom-child-item"))));
        $rowCustomChildItem->addCell(new FTableCell(null, null, $inpCustom));
        
        // "Row Submit" Element Settings.
        
        $rowSubmit->setID("add-menu-item-row");
        $rowSubmit->addCell(new FTableCell(null, null, array($btnReset, $btnSubmit), 2, 0, FTableCell::ALN_RIGHT));
        
        // "Input Title" Element Settings.
        
        $inpTitle->setID("menu-item-title-input");
        $inpTitle->setClass("form-input");
        $inpTitle->setType(FInput::TP_TEXT);
        $inpTitle->setMaxLength(50);
        $inpTitle->setContent($varItemTitle);
        $inpTitle->setName("req_title");
        
        // "Select Type" Element Settings.
        
        $selType->setClass("form-select");
        
        if ($varItemType == 0)
            $selType->addOption(new FSelectOption(0, Locales::getCore("title"), true));
        else
            $selType->addOption(new FSelectOption(0, Locales::getCore("title"), false));
        
        if ($varItemType == 1)
            $selType->addOption(new FSelectOption(1, Locales::getCore("separator"), true));
        else
            $selType->addOption(new FSelectOption(1, Locales::getCore("separator"), false));
        
        
        if ($varItemType == 2)
            $selType->addOption(new FSelectOption(2, Locales::getCore("menu"), true));
        else
            $selType->addOption(new FSelectOption(2, Locales::getCore("menu"), false));
        
        if ($varItemType == 3)
            $selType->addOption(new FSelectOption(3, Locales::getCore("core-item"), true));
        else
            $selType->addOption(new FSelectOption(3, Locales::getCore("core-item"), false));
        
        if ($varItemType == 4)
            $selType->addOption(new FSelectOption(4, Locales::getCore("custom-item"), true));
        else
            $selType->addOption(new FSelectOption(4, Locales::getCore("custom-item"), false));
        
        $selType->setName("req_type");
        
        // "Select Parent" Element Settings.
        
        $selParent->setClass("form-select");
        
        foreach ($varMenus as $varMenu)
        {
            if ($varItemParent == $varMenu["id"])
                $selParent->addOption(new FSelectOption($varMenu["id"], $varMenu["title"], true));
            else
                $selParent->addOption(new FSelectOption($varMenu["id"], $varMenu["title"], false));
        }
        
        $selParent->setName("req_parent");

        // "Select Menus" Element Settings.
        
        $selMenus->setClass("form-select");
        
        foreach ($varMenus as $varMenu)
        {
            if ($varItemType == Menus::MI_MENU && $varItemParent == $varMenu["id"])
                $selMenus->addOption(new FSelectOption($varMenu["id"], $varMenu["title"], true));
            else
                $selMenus->addOption(new FSelectOption($varMenu["id"], $varMenu["title"], false));
        }
        
        $selMenus->setName("req_menus");
        
        // "Select Items" Element Settings.
        
        $selItems->setClass("form-select");
        
        $selItems->addOption(new FSelectOption("homepage", " - " . Locales::getTitle("home-page"), false));
        $selItems->addOption(new FSelectOption("registration", " - " . Locales::getTitle("registration"), false));
        $selItems->addOption(new FSelectOption("log-in", " - " . Locales::getTitle("log-in"), false));
        $selItems->addOption(new FSelectOption("messages", " - " . Locales::getTitle("messages"), false));
        $selItems->addOption(new FSelectOption("your-profile", " - " . Locales::getTitle("your-profile"), false));
        $selItems->addOption(new FSelectOption("site-administration", " - " . Locales::getTitle("site-administration"), false));

        foreach ($varLinks as $varLink)
        {
            if ($varItemType == Menus::MI_CORE_ITEM && $varItemParent == $varLink["id"])
                $selItems->addOption(new FSelectOption($varLink["id"], $varLink["title"], true));
            else
                $selItems->addOption(new FSelectOption($varLink["id"], $varLink["title"], false));
        }
        
        $selItems->setName("req_items");
        
        // "Input Custom" Element Settings.
        
        $inpCustom->setID("custom-menu-item-input");
        $inpCustom->setClass("form-input");
        $inpCustom->setType(FInput::TP_TEXT);
        $inpCustom->setMaxLength(125);
        $inpCustom->setContent($varCustomContent);
        $inpCustom->setName("req_custom");
        
        // "Button Reset" Element Settings.

        $btnReset->setID("add-menu-item-reset-button");
        $btnReset->setClass("form-button");
        $btnReset->setType(FButton::TP_RESET);
        $btnReset->setContent(Locales::getCore("reset"));

        // "Button Submit" Element Settings.

        $btnSubmit->setID("add-menu-item-submit-button");
        $btnSubmit->setClass("form-button");
        $btnSubmit->setType(FButton::TP_SUBMIT);
        $btnSubmit->setContent(Locales::getCore("edit"));

        // Append Elements To "Workplace" Element.

        $divWorkplace->addElement($hdEditMenuItem);
        $divWorkplace->addElement($fmEditMenuItem);
    }
}
else
{
    // Create "Core" Variable.

    $varMenus                = null;
    $varMenuItems            = null;

    // Create "Link Prefix And Sufix" Variables.

    $varEditMenuPrefix       = "<a id=\"edit-icon\" class=\"options-icon\" title=\"" . Locales::getCore("edit-menu") . "\" href=\" " .  $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-menu") . "&" . Locales::getVariable("id") . "=";
    $varEditMenuSufix        = "\">" . Locales::getCore("edit-menu") . "</a>";
    $varDeleteMenuPrefix     = "<a id=\"delete-icon\" class=\"options-icon\" title=\"" . Locales::getCore("delete-menu") . "\" href=\" " .  $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("delete-menu") . "&" . Locales::getVariable("id") . "=";
    $varDeleteMenuSufix      = "\">" . Locales::getCore("delete-menu") . "</a>";
    $varArrangeItemsPrefix   = "<a id=\"arrange-icon\" class=\"options-icon\" title=\"" . Locales::getCore("arrange-menu-items") . "\"  href=\" " .  $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("arrange-menu-items") . "&" . Locales::getVariable("id") . "=";
    $varArrangeItemsSufix    = "\">" . Locales::getCore("arrange-menu-items") . "</a>";
    $varEditMenuItemPrefix   = "<a id=\"edit-icon\" class=\"options-icon\" title=\"" . Locales::getCore("edit-menu-item") . "\" href=\" " .  $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("edit-menu-item") . "&" . Locales::getVariable("id") . "=";
    $varEditMenuItemSufix    = "\">" . Locales::getCore("edit-menu-item") . "</a>";
    $varDeleteMenuItemPrefix = "<a id=\"delete-icon\" class=\"options-icon\" title=\"" . Locales::getCore("delete-menu-item") . "\" href=\" " .  $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("delete-menu-item") . "&" . Locales::getVariable("id") . "=";
    $varDeleteMenuItemSufix  = "\">" . Locales::getCore("delete-menu-item") . "</a>";

    // Create "Core" Elements.

    $hdMenus                 = new FHeader();
    $parMenusInfo            = new FParagraph();
    $tblMenus                = new FTable();
    $hdMenuItems             = new FHeader();
    $parMenuItemsInfo        = new FParagraph();
    $tblMenuItems            = new FTable();
    $divOptionLinks          = new FDiv();

    // Create "Row" Elements.

    $rowMenusInfo            = new FTableRow();
    $rowMenuItemsInfo        = new FTableRow();

    // "Menus" Variable Settings.

    EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

    $varMenus = EasyGet::execute
    (
        "TS: menus",
        "CS: *"
    );

    // "Menu Items" Variable Settings.
    
    EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

    $varMenuItems = EasyGet::execute
    (
        "TS: menu_items",
        "CS: *"
    );

    // "Header Menus" Element Settings.

    $hdMenus->setLevel(2);
    $hdMenus->setContent(Locales::getTitle("all-menus"));

    // "Paragraph Menus Info" Element Settings.

    $parMenusInfo->setID("menus-info");
    $parMenusInfo->setClass("info-paragraph");
    $parMenusInfo->setAlignment(FParagraph::ALN_CENTER);
    $parMenusInfo->setContent(Locales::getParagraph("no-menus"));

    // "Table Menus" Element Settings.

    $tblMenus->setID("menus-table");
    $tblMenus->setClass("default-admin-table");
    $tblMenus->setAlignment(FTable::ALN_CENTER);

    $tblMenus->addRow($rowMenusInfo);

    if ($varMenus != null)
    {
        foreach ($varMenus as $varMenu)
        {
            // Create "Temp" Variables.

            $varTempOptions = null;

            // Create "Temp" Elements.

            $varTempRow     = new FTableRow();

            // "Temp Options" Variable Settings.

            if ($varMenu["core"] == 1)
                $varTempOptions = $varArrangeItemsPrefix . $varMenu["id"] . $varArrangeItemsSufix;
            else
                $varTempOptions = $varArrangeItemsPrefix . $varMenu["id"] . $varArrangeItemsSufix . " " . $varEditMenuPrefix . $varMenu["id"] . $varEditMenuSufix . " " . $varDeleteMenuPrefix . $varMenu["id"] . $varDeleteMenuSufix;

            // "Temp Row" Element Settings.

            $varTempRow->addCell(new FTableCell(null, "table-cell-id", $varMenu["id"]));
            $varTempRow->addCell(new FTableCell(null, "table-cell-name", $varMenu["name"]));
            $varTempRow->addCell(new FTableCell(null, "table-cell-title", $varMenu["title"]));
            $varTempRow->addCell(new FTableCell(null, "table-cell-options", $varTempOptions));

            // Append Elements To "Table Menus" Element.

            $tblMenus->addRow($varTempRow);
        }
    }

    // "Header Menu Items" Element Settings.

    $hdMenuItems->setLevel(2);
    $hdMenuItems->setContent(Locales::getTitle("all-menu-items"));

    // "Paragraph Menu Items Info" Element Settings.

    $parMenuItemsInfo->setID("menu-items-info");
    $parMenuItemsInfo->setClass("info-paragraph");
    $parMenuItemsInfo->setAlignment(FParagraph::ALN_CENTER);
    $parMenuItemsInfo->setContent(Locales::getParagraph("no-menu-items"));

    // "Table Menu" Element Settings.

    $tblMenuItems->setID("menu-items-table");
    $tblMenuItems->setClass("default-admin-table");
    $tblMenuItems->setAlignment(FTable::ALN_CENTER);

    $tblMenuItems->addRow($rowMenuItemsInfo);

    if ($varMenuItems != null)
    {
        foreach ($varMenuItems as $varMenuItem)
        {
            // Create "Temp" Variables.

            $varTempOptions = null;

            // Create "Temp" Elements.

            $varTempRow     = new FTableRow();

            // "Temp Options" Variable Settings..

            $varTempOptions = $varEditMenuItemPrefix . $varMenuItem["id"] . $varEditMenuItemSufix . " " . $varDeleteMenuItemPrefix . $varMenuItem["id"] . $varDeleteMenuItemSufix;

            // Process "Type" Variable.
            
            if ($varMenuItem["type"] == Menus::MI_TITLE)
                $varMenuItem["type"] = Locales::getCore("title");
            else if ($varMenuItem["type"] == Menus::MI_SEPARATOR)
                $varMenuItem["type"] = Locales::getCore("separator");
            else if ($varMenuItem["type"] == Menus::MI_MENU)
                $varMenuItem["type"] = Locales::getCore("menu");
            else if ($varMenuItem["type"] == Menus::MI_CORE_ITEM)
                $varMenuItem["type"] = Locales::getCore("core-item");
            else if ($varMenuItem["type"] == Menus::MI_CUSTOM_ITEM)
                $varMenuItem["type"] = Locales::getCore("custom-item");
            else
                $varMenuItem["type"] = Locales::getCore("unknown");
            
            // Process "Parent (Menu ID)" Variable.

            EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);

            $varParentData = EasyGet::execute
            (
                "TS: menus",
                "CS: title",
                "ARGS: id = " . $varMenuItem["menu_id"]
            );

            $varMenuItem["menu_id"] = $varParentData[0]["title"];

            // "Temp Row" Element Settings.

            $varTempRow->addCell(new FTableCell(null, "table-cell-id", $varMenuItem["id"]));
            $varTempRow->addCell(new FTableCell(null, "table-cell-title", $varMenuItem["title"]));
            $varTempRow->addCell(new FTableCell(null, "table-cell-title", $varMenuItem["type"]));
            $varTempRow->addCell(new FTableCell(null, "table-cell-menu", $varMenuItem["menu_id"]));
            $varTempRow->addCell(new FTableCell(null, "table-cell-position", $varMenuItem["position"]));
            $varTempRow->addCell(new FTableCell(null, "table-cell-options", $varTempOptions));

            // Append Elements To "Table Menus" Element.

            $tblMenuItems->addRow($varTempRow);
        }
    }

    // "Div Option Links" Element Settings.

    $divOptionLinks->setClass("option-links");

    $divOptionLinks->addElement("<strong>" . Locales::getCore("options") . ":</strong>");
    $divOptionLinks->addElement(new FAnchor(null, null, $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("add-menu"), null, Locales::getCore("add-menu")));
    $divOptionLinks->addElement(" | ");
    $divOptionLinks->addElement(new FAnchor(null, null, $varCoreLink . "&" . Locales::getVariable("option") . "=" . Locales::getLink("add-menu-item"), null, Locales::getCore("add-menu-item")));

    // "Row Menus Info" Element Settings.

    $rowMenusInfo->setID("menu-info-row");
    $rowMenusInfo->setClass("info-row");

    $rowMenusInfo->addCell(new FTableCell(null, "table-cell-id", "#"));
    $rowMenusInfo->addCell(new FTableCell(null, "table-cell-name", Locales::getCore("name")));
    $rowMenusInfo->addCell(new FTableCell(null, "table-cell-title", Locales::getCore("title")));
    $rowMenusInfo->addCell(new FTableCell(null, "table-cell-options", Locales::getCore("options")));

    // "Row Menu Items Info" Element Settings.

    $rowMenuItemsInfo->setID("menu-items-info-row");
    $rowMenuItemsInfo->setClass("info-row");

    $rowMenuItemsInfo->addCell(new FTableCell(null, "table-cell-id", "#"));
    $rowMenuItemsInfo->addCell(new FTableCell(null, "table-cell-title", Locales::getCore("title")));
    $rowMenuItemsInfo->addCell(new FTableCell(null, "table-cell-menu", Locales::getCore("type")));
    $rowMenuItemsInfo->addCell(new FTableCell(null, "table-cell-menu", Locales::getCore("parent")));
    $rowMenuItemsInfo->addCell(new FTableCell(null, "table-cell-position", Locales::getCore("position")));
    $rowMenuItemsInfo->addCell(new FTableCell(null, "table-cell-options", Locales::getCore("options")));

    // Append Elements To "Workplace" Element.

    $divWorkplace->addElement($hdMenus);

    if ($varMenus == null)
        $divWorkplace->addElement($parMenusInfo);
    else
        $divWorkplace->addElement($tblMenus);

    $divWorkplace->addElement($hdMenuItems);

    if ($varMenuItems == null)
        $divWorkplace->addElement($parMenuItemsInfo);
    else
        $divWorkplace->addElement($tblMenuItems);

    $divWorkplace->addElement($divOptionLinks);
}

?>