<?php

/***********************************************************\
|* Frequency CMS v1.0.0                                    *|
|* Author: Djordje Jocic                                   *|
|* Year: 2014                                              *|
|* ------------------------------------------------------- *|
|* Filename: your_profile_processor.php                    *|
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

// Class Starts.

class Processor extends PageProcessor
{
    // "Constructor/s".
    
    public function __construct()
    {
        parent::__construct(Locales::getLink("your-profile"));
    }
    
    // "Main" Methods.
    
    public function execute()
    {
        if (!Session::isActive())
            exit(header("location: " . CMS_ROOT));
        
        if (!empty($_GET[Locales::getVariable("option")]))
        {
            if ($_GET[Locales::getVariable("option")] == Locales::getLink("change-password"))
            {
                if (!$this->isPostEmpty())
                {
                    $this->checkPassword();
                    $this->checkConfirmationPassword();
                    
                    // Create "Core" Variables.
                    
                    $varUsersID = IDFetch::byUsername(Session::getUsername());
                    
                    InfoAlter::alterPassword(sha1($_POST["req_password"] . " - " . Core::get(Core::PASSWORD_SALT)), $varUsersID);
                    
                    Session::stop();
                    
                    // Reddirect.
                    
                    exit(header("location: " . CMS_ROOT));
                    
                    //exit(header("location: " . $this->getNoticeLocationPrefix() . Locales::getNoticeLink("password-changed")));
                }
            }
        }
    }
    
    // "Check" Methods.
    
    private function checkPassword()
    {
        // Check "Password" Variable.
        
        if (empty($_POST["req_password"]))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("password-empty")));
        else if (!StringCheck::between($_POST["req_password"], 5, 50))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("password-length")));
        
        // Check Integrity.
        
        $iv = new IntegrityVariable();
        
        // Perform Initial Settings.

        $iv->setType(IntegrityVariable::TP_CUSTOM);
        $iv->setRegularExpression("/^[A-z0-9!@#$%^&*()_+]+$/");
        $iv->setRedirectLocation($this->getErrorLocationPrefix() . Locales::getErrorLink("password-content"));
        
        // Assign Values.

        $iv->setValue($_POST["req_password"]);
        
        // Get Value.

        $this->psw = $iv->getValue();
    }
    
    private function checkConfirmationPassword()
    {
        // Check "Password" Variable.
        
        if (empty($_POST["req_password_re"]))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("confirmation-password-empty")));
        else if (!StringCheck::between($_POST["req_password_re"], 5, 50))
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("confirmation-password-length")));
        
        // Check Integrity.
        
        $iv = new IntegrityVariable();
        
        // Perform Initial Settings.

        $iv->setType(IntegrityVariable::TP_CUSTOM);
        $iv->setRegularExpression("/^[A-z0-9!@#$%^&*()_+]+$/");
        $iv->setRedirectLocation($this->getErrorLocationPrefix() . Locales::getErrorLink("confirmation-password-content"));
        
        // Assign Values.

        $iv->setValue($_POST["req_password_re"]);
        
        $iv->getValue(); // It Needs To Be Called In Order To Trigger Check.
        
        // Check Password Match.
        
        if ($_POST["req_password"] != $_POST["req_password_re"])
            exit(header("location:" . $this->getErrorLocationPrefix() . Locales::getErrorLink("passwords-not-equal")));
    }
}

?>