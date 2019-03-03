<?php

/***********************************************************\
|* Frequency CMS v1.0.0                                    *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: table_blogs.php                               *|
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

$tblBlogs = new EasyTable();
$fkBlogs  = new EasyForeignKey();

// "Table Blogs" Variable Settings.

$tblBlogs->setName("blogs");

$tblBlogs->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("id"),
        ColumnType::useInt(10),
        ColumnNull::notAllowed(),
        ColumnValue::useAutoIncrementValue()
    )
);

$tblBlogs->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("date_posted"),
        ColumnType::useDate(),
        ColumnNull::notAllowed()
    )
);

$tblBlogs->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("title"),
        ColumnType::useVarChar(100),
        ColumnNull::notAllowed()
    )
);

$tblBlogs->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("content"),
        ColumnType::useText(),
        ColumnNull::notAllowed()
    )
);

$tblBlogs->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("poster_id"),
        ColumnType::useInt(10),
        ColumnNull::notAllowed()
    )
);

$tblBlogs->addColumn
(
    new EasyColumn
    (
        ColumnName::useName("status"),
        ColumnType::useEnum("0, 1"),
        ColumnNull::notAllowed(),
        ColumnValue::useValue("0")
    )
);

$tblBlogs->addPrimaryKey(new EasyPrimaryKey("id"));
$tblBlogs->addForeignKey($fkBlogs);

// "Foreign Key Blogs" Variable Settings.

$fkBlogs->setName("user_blogs_fk");
$fkBlogs->setForeignKeyColumn("poster_id");
$fkBlogs->setReferenceTable("users");
$fkBlogs->setReferenceColumn("id");
$fkBlogs->setOnUpdateValue(EasyForeignKey::OPT_CASCADE);
$fkBlogs->setOnDeleteValue(EasyForeignKey::OPT_CASCADE);

// Create The Table.

EasyCreate::setMode(EasyCreate::ECM_DROP_IF_EXISTS);
EasyCreate::execute($tblBlogs);

?>