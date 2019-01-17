<?php
    error_reporting(0);

	include_once('dbFunction.php');
	if(!($_SESSION)){
		header("Location:index.php");
	}
?>
<h4>Welcome <?php echo $_SESSION['email']; ?><a href="logout.php" name="logout">Logout</a> </h4>
<div>
<form method="Post" action="register.php" enctype="multipart/form-data">
    <input type="hidden" name="user_id" value="<?php echo $_SESSION['uid'] ?>">
    <input type="file" accept=".xlsx" name="all_xlsx[]" multiple>
    <input type="submit" name="upload_excel" value="Upload .xlsx">
</form>
</div>
<?php

    $funObj = new dbFunction();
//    echo $funObj->getUploadedData();
?>

    <h4>List of Files Uploaded</h4>
    <ul>
    <?php
        $user = $funObj->getUploadedData();
        foreach($user as $u)
        {
          echo '<li><a href="./uploads/'.$u['filename'].'">'.$u['filename'].'</a></li>';
        }
        ?>
    </ul>
</table>