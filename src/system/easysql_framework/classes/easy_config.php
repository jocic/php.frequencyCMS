<?php

/***********************************************************\
|* EasySQL Framework v1.0.3                                *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: easy_config.php                               *|
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

if (!defined("CONST_EASY_SQL")) exit("Action not allowed.");

class DBConfig
{
    // "Core" Variables.

    private $host       = "";
    private $username   = "";
    private $password   = "";
    private $dbSchema   = "";
    private $tblPrefix  = "";
    private $viewPrefix = "";

    // "Set" Methods.

    public function setHostname($host) { $this->host = $host; }

    public function setUsername($username) { $this->username = $username; }

    public function setPassword($password) { $this->password = $password; }

    public function setSchemaName($dbSchema) { $this->dbSchema = $dbSchema; }

    public function setTablePrefix($tblPrefix) { $this->tblPrefix = $tblPrefix; }

    public function setViewPrefix($viewPrefix) { $this->viewPrefix = $viewPrefix; }

    // "Get" Methods.

    public function getHostname() { return $this->host; }

    public function getUsername() { return $this->username; }

    public function getPassword() { return $this->password; }

    public function getSchemaName() { return $this->dbSchema; }

    public function getTablePrefix() { return $this->tblPrefix; }

    public function getViewPrefix() { return $this->viewPrefix; }
}

?>