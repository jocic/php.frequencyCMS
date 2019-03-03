<?php

/***********************************************************\
|* Frequency CMS v1.0.0                                    *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: user_related_tables.php                       *|
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

// Row For Table "Users".

EasyInsert::execute
(
    new TableSelection("users"),
    new ColumnSelection("username", "password", "status"),
    new ValueSelection($varUsername, $varSaltedPassword, "0")
);

// Row For Table "User Info".

EasyInsert::execute
(
    new TableSelection("user_info"),
    new ColumnSelection("id", "gender", "email", "first_ip", "last_ip"),
    new ValueSelection("1", "0", "office@localhost.com", $_SERVER["REMOTE_ADDR"], $_SERVER["REMOTE_ADDR"])
);

// Row For Table "Personals".

EasyInsert::execute
(
    new TableSelection("user_personals"),
    new ColumnSelection("id", "prefered_language"),
    new ValueSelection("1", "en")
);

// Row For Table "Sessions".

EasyInsert::execute
(
    new TableSelection("sessions"),
    new ColumnSelection("users_id"),
    new ValueSelection("1")
);

?>