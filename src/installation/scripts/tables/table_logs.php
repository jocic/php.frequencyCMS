<?php

/***********************************************************\
|* Frequency CMS v1.0.0                                    *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: table_logs.php                                *|
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

// Create "Core" Variables.

$tblLogs = new EasyTable();

// "Table Logs" Variable Settings.

$tblLogs->setName("logs");

$tblLogs->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("id"),
        ColumnType::useInt(10),
        ColumnNull::notAllowed(),
        ColumnValue::useAutoIncrementValue()
    )
);

$tblLogs->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("timestamp"),
        ColumnType::useTimeStamp(),
        ColumnNull::notAllowed(),
        ColumnValue::useCurrentTimeStampValue()
    )
);

$tblLogs->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("code"),
        ColumnType::useInt(10),
        ColumnNull::notAllowed()
    )
);

$tblLogs->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("info"),
        ColumnType::useVarChar(255),
        ColumnNull::notAllowed()
    )
);

$tblLogs->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("ip"),
        ColumnType::useVarChar(50),
        ColumnNull::notAllowed()
    )
);

$tblLogs->addPrimaryKey(new EasyPrimaryKey("id"));

// Create The Table.

EasyCreate::setMode(EasyCreate::ECM_DROP_IF_EXISTS);
EasyCreate::execute($tblLogs);

?>