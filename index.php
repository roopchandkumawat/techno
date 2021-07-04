<?php
namespace Phppot;

use \Phppot\Member;
if (! empty($_POST["register-user"])) {
    
    $name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $gender = filter_var($_POST["gender"], FILTER_SANITIZE_STRING);
    $phone = filter_var($_POST["phone"], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_STRING);
    $comment = filter_var($_POST["comment"], FILTER_SANITIZE_STRING);
    require_once ("Member.php");
    /* Form Required Field Validation */
    $member = new Member();
    $errorMessage = $member->validateMember($name, $gender, $phone, $email);
    
    if (empty($errorMessage)) {
        $memberCount = $member->isMemberExists($phone, $email);
        
        if ($memberCount == 0) {
            $insertId = $member->insertMemberRecord($name, $gender, $phone, $email, $comment);
            if (! empty($insertId)) {
                header("Location: thankyou.php");
            }
        } else {
            $errorMessage[] = "User already exists.";
        }
    }
}
?>
<html>
<head>
<title>User Registration Form</title>
<link href="./css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <form name="frmRegistration" method="post" action="">
        <div class="demo-table">
        <div class="form-head">New Registration For Merathon</div>
            
<?php
if (! empty($errorMessage) && is_array($errorMessage)) {
    ?>	
            <div class="error-message">
            <?php 
            foreach($errorMessage as $message) {
                echo $message . "<br/>";
            }
            ?>
            </div>
<?php
}
?>
            <div class="field-column">
                <label>Name</label>
                <div>
                    <input type="text" class="demo-input-box"
                        name="name"
                        value="<?php if(isset($_POST['name'])) echo $_POST['name']; ?>">
                </div>
            </div>
            <div class="field-column">
                <label>Gender</label>
                <div>
                    <input type="radio" <?php if(isset($_POST['gender']) && $_POST['gender']=='Male') echo 'checked="checked"'; ?> name="gender" value="Male">Male
                    <input type="radio" <?php if(isset($_POST['gender']) && $_POST['gender']=='Female') echo 'checked="checked"'; ?> name="gender" value="Female">Female
                </div>
            </div>
            <div class="field-column">
                <label>Phone No.</label>
                <div>
                    <input type="text" class="demo-input-box" name="phone" maxlength="10" value="<?php if(isset($_POST['phone'])) echo $_POST['phone']; ?>">
                </div>

            </div>
            <div class="field-column">
                <label>Email</label>
                <div>
                    <input type="text" class="demo-input-box" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>">
                </div>
            </div>
            <div class="field-column">
                <label>Comment</label>
                <div>
                    <textarea  class="demo-input-box" name="comment"><?php if(isset($_POST['comment'])) echo $_POST['comment']; ?></textarea>
                </div>
            </div>
            <div class="field-column">
                <div class="terms">
                    <input type="checkbox" <?php if(isset($_POST['terms'])) echo 'checked="checked"'; ?> name="terms"> I accept terms and conditions
                </div>
                <div>
                    <input type="submit" name="register-user" value="Register" class="btnRegister">
                </div>
            </div>
        </div>
    </form>
</body>
</html>