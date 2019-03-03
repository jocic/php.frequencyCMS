<?php

/***********************************************************\
|* frequencyCMS v1.0.0                                     *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: statistics.php                                *|
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

class Statistics
{
    // "Get" Methods.
    
    private static function countIDS($tableName, $argument = null)
    {
        if ($argument != null)
            $argument = "ARGS: " . $argument;
        
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
        
        $data = EasyGet::execute
        (
            "TS: $tableName",
            "CS: COUNT(`id`)",
            $argument
        );

        return $data[0]["COUNT(`id`)"];
    }
    
    private static function get($name)
    {
        EasyGet::setFetchMode(EasyGet::FM_BY_ASSOC);
        
        $data = EasyGet::execute
        (
            "TS: statistics",
            "CS: count",
            "ARGS: name = $name"
        );

        return $data[0]["count"];
    }
    
    public static function getTotalHits()
    {
        $hits = self::get("total_hits");
        
        if ($hits == null)
            return 0;
        else
            return $hits;
    }
    
    public static function getPageHits()
    {
        $hits = self::get("page_hits");
        
        if ($hits == null)
            return 0;
        else
            return self::get("page_hits");
    }
    
    public static function getUserCount()
    {
        return self::countIDS("users");
    }
    
    public static function getMaleUserCount()
    {
        return self::countIDS("user_info", "gender = 0");
    }
    
    public static function getFemaleUserCount()
    {
        return self::countIDS("user_info", "gender = 1");
    }
    
    public static function getOtherUserCount()
    {
        return self::countIDS("user_info", "gender = 2");
    }
    
    public static function getMessagesCount()
    {
        return self::countIDS("messages");
    }
    
    public static function getCommentCount()
    {
        return self::countIDS("page_comments");
    }
    
    public static function getPagesCount()
    {
        return self::countIDS("pages");
    }
    
    // "Print" Methods.
    
    
    
    // "Increment" Methods.
    
    public static function increment($nameValue)
    {
        EasyUpdate::execute
        (
            "TS: statistics",
            "CS: count",
            "VLS: increment",
            "ARGS: name = $nameValue"
        );
    }
    
    public static function incrementTotalHits()
    {
        self::increment("total_hits");
    }
    
    public static function incrementPageHits()
    {
        self::increment("page_hits");
    }
}

?>
