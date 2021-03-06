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

// Define "Core" Constants.

define("IND_ACCESS", true);
define("DOC_ROOT", dirname(__FILE__));

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

// Debug Methods For Devs - IMPORTANT: UNCOMMENT AND USE ONLY ON LOCALHOST !!!

//EasyCore::setShowFrameworkErrors(true);
//EasyCore::setShowFrameworkNotices(true);
//EasyCore::setShowServerErrors(true);
//EasyCore::setDebugMode(true);

// Display A Page.

EasyConnection::start(); // Establish Connection to the MySQL Server.

Display::page();

EasyConnection::stop(); // Terminate Connection to the MySQL Server.

?>