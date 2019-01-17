<?php
require_once 'dbConnect.php';
session_start();
 	class dbFunction {

        public function conn()
        {
            $db = new dbConnect();
            $conn = $db->connect();

            return $conn;
        }

		public function UserRegister($emailid, $password){
			 	$password = md5($password);
				$qr = mysqli_query($this->conn(),"INSERT INTO users(emailid, password) values('".$emailid."','".$password."')") or die(mysql_error());
				return $qr;
			 
		}
		public function Login($emailid, $password){
			$res = mysqli_query($this->conn(),"SELECT * FROM users WHERE emailid = '".$emailid."' AND password = '".md5($password)."'");
			$user_data = mysqli_fetch_array($res);
			//print_r($user_data);
			$no_rows = mysqli_num_rows($res);
			
			if ($no_rows == 1) 
			{
		 
				$_SESSION['login'] = true;
				$_SESSION['uid'] = $user_data['id'];
//				$_SESSION['username'] = $user_data['username'];
				$_SESSION['email'] = $user_data['emailid'];

				return TRUE;
			}
			else
			{
				return FALSE;
			}
			 
				 
		}
		public function isUserExist($emailid){
			$qr = mysqli_query($this->conn(),"SELECT * FROM users WHERE emailid = '".$emailid."'");
			echo $row = mysqli_num_rows($qr);
			if($row > 0){
				return true;
			} else {
				return false;
			}
		}
		public function StoreUploaded($filesUploaded,$uid)
        {
            $file_count = count($filesUploaded['name']);
            $k=0;
            $j=0;
            for ($i = 0; $i < $file_count; $i++) {

                $name = basename($filesUploaded['name'][$i]);
                $tmp_name = $filesUploaded['tmp_name'][$i];
//                    $size = $filesUploaded['size'][$i];
                $check_exist_file = mysqli_query($this->conn(),"select * from user_file_mapping where filename='".$name."'");
                if(mysqli_num_rows($check_exist_file) > 0)
                {
                    $k++;
                }
                else
                {
                    if ($name != '') {
                        $j++;
                        mysqli_query($this->conn(), "Insert into user_file_mapping(filename,uploadedby) VALUES('" . $name . "','" . $_POST['user_id'] . "')");
                        move_uploaded_file($tmp_name, "./uploads/" . $name);
                    }
                }
            }
            $data = array('exist'=>$k,'moved'=>$j);
            return $data;
        }

        public function getUploadedData()
        {
            $uid = $_SESSION["uid"];
            $user = mysqli_query($this->conn(),"Select filename from user_file_mapping where uploadedby = '".$uid."'");
            return $user;
        }
	}
?>