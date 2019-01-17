<?php
error_reporting(0);
include_once('dbFunction.php');


$funObj = new dbFunction();

if($_POST['login']){
    $emailid = $_POST['user_email'];
    $password = $_POST['user_password'];
    if($password != '' && $emailid != '')
    {
        $user = $funObj->Login($emailid, $password);
        if ($user) {
            $uid = $_SESSION["uid"];
            $allrecords = mysqli_query($funObj->conn(),"Select * from user_file_mapping where uploadedby = '".$uid."'");
            // Login Success
            header("location:home.php");
        } else {
            // Registration Failed
            echo "<script>
                    alert('Emailid / Password Not Match');
                           history.go(-1);
                    </script>";
        }
    }
    else {
        echo "<script>
                        alert('Please Fill All the Fields');
                           history.go(-1);
              </script>";
    }
}


if($_POST['register']){

//    $username = $_POST['username'];
    $emailid = $_POST['user_email'];
    $password = $_POST['user_password'];
//    $confirmPassword = $_POST['confirm_password'];


    if($password != '' && $emailid != '')
    {
        $email = $funObj->isUserExist($emailid);
        if(!$email){
            $register = $funObj->UserRegister($emailid, $password);
            if($register){
                echo "<script>alert('Registration Successful');</script>";
                header("location:SignUp.html");
            }else{
                echo "<script>alert('Registration Not Successful');</script>";
            }
        } else {
            echo "<script>alert('Email Already Exist'); history.go(-1);</script>";
        }
    } else {
        echo "<script>
                        alert('Please Fill All the Fields');
                           history.go(-1);
              </script>";
    }
}

if($_POST['upload_excel'])
{
    if(!empty($_FILES['all_xlsx']))
    {
        $uploading = $funObj->StoreUploaded($_FILES['all_xlsx'],$_POST['user_id']);

        if($uploading['moved'] == 0 && $uploading['exist'] > 0)
        {
            echo $uploading['exist'].'  Already Exist';
        }
        elseif ($uploading['exist'] == 0 && $uploading['moved'] > 0)
        {
            echo $uploading['moved'].'  Uploaded Successfully  ';
        }
        elseif ($uploading['exist'] > 0 && $uploading['moved']  > 0)
        {
            echo $uploading['moved'].'  Uploaded Successfully  ';
            echo $uploading['exist'].'  Already Exist';
        }
        else
        {
            echo '<script>alert("Please Select file to upload");history.go(-1);</script>';
        }

        echo '<script>setTimeout(function(){history.go(-1)},4000)</script>';
//        if($uploading)
//        {
//            echo "<script>alert('Registration Successful');
//                        header('Location:')
//            </script>";
//        }
//        else
//        {
//            echo "<script>alert('Please select atleast one file');history.go(-1);</script>";
//        }
    }
}
?>