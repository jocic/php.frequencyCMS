<?php

/***********************************************************\
|* Frequency CMS v1.0.0                                    *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: core_page.php                                 *|
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

class CorePage
{
    // "Set" Methods.

    public static function set($pageName)
    {
        // Filter Page Name.
        
        $pageName = self::filterName($pageName);
    }
    
    // "Get" Methods.
    
    public static function get($pageName)
    {
        // Filter Page Name.
        
        $pageName = self::filterName($pageName);
        
        // Fetch Page Data.
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
        
        $data = EasyGet::execute
        (
            "TS: core_pages",
            "CS: content",
            "ARGS: name = $pageName"
        );
        
        return $data[0]["content"];
    }
    
    // "Filter" Methods.
    
    private static function filterID($pageID)
    {
        
    }
    
    private static function filterName($pageName)
    {
        $filteredName = new FilteredVariable();

        $filteredName->setType(FilteredVariable::TP_CUSTOM);
        $filteredName->setRegularExpression("/[^a-zA-Z0-9\-]/");
        $filteredName->setValue($pageName);

        $filteredName = $filteredName->getValue();
        
        return $filteredName;
    }
}

?>