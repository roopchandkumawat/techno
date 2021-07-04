<?php
namespace Phppot;

use \Phppot\DataSource;

class Member
{

    private $dbConn;

    private $ds;

    function __construct()
    {
        require_once "DataSource.php";
        $this->ds = new DataSource();
    }

    function validateMember()
    {
        $valid = true;
        $errorMessage = array();
        foreach ($_POST as $key => $value) {
            if (empty($_POST[$key])) {
                $valid = false;
            }
        }
        
        if($valid == true) {
            
            // Email Validation
            if (! isset($error_message)) {
                if (! filter_var($_POST["phone"], FILTER_SANITIZE_NUMBER_INT)) {
                    $errorMessage[] = "Invalid phone number.";
                    $valid = false;
                }
            }

            if (! isset($error_message)) {
                if (! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                    $errorMessage[] = "Invalid email address.";
                    $valid = false;
                }
            }
            
            // Validation to check if Terms and Conditions are accepted
            if (! isset($error_message)) {
                if (! isset($_POST["terms"])) {
                    $errorMessage[] = "Accept terms and conditions.";
                    $valid = false;
                }
            }
        }
        else {
            $errorMessage[] = "All fields are required.";
        }
        
        if ($valid == false) {
            return $errorMessage;
        }
        return;
    }

    function isMemberExists($phone, $email)
    {
        $query = "select * FROM registered_users WHERE phone = ? OR email = ?";
        $paramType = "ss";
        $paramArray = array($phone, $email);
        $memberCount = $this->ds->numRows($query, $paramType, $paramArray);
        
        return $memberCount;
    }

    function insertMemberRecord($name, $gender, $phone, $email,$comment)
    {
        $query = "INSERT INTO registered_users (name, gender, phone, email,comment) VALUES (?, ?, ?, ?, ?)";
        $paramType = "sssss";
        $paramArray = array(
            $name,
            $gender,
            $phone,
            $email,
            $comment
        );
        $insertId = $this->ds->insert($query, $paramType, $paramArray);
        return $insertId;
    }
}