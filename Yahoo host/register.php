<?php
include 'init.php';
//include 'index.php';


$errors=array();
if(isset($_POST['register_txtEmail'],$_POST['register_txtUname'],$_POST['register_txtpswd']))
{
   $register_txtEmail=$_POST['register_txtEmail'];
   $register_txtUname=$_POST['register_txtUname'];
   $register_txtpswd=$_POST['register_txtpswd'];
   if(empty($register_txtEmail)||empty($register_txtpswd)||empty($register_txtUname))
    {
        $errors[]="All field are required";
        //echo $errors;
    }
    elseif(user_exists($register_txtUname))
        $errors[]="User Id already exists";
    
    if(empty($errors))
    {
        //register the user
        $newregister=user_register($register_txtEmail,$register_txtUname,$register_txtpswd);
        echo "Welcome ".$newregister;
        //include_once( 'index.php');
        header('Location:index.php');
    }
    else
    {
        echo "<table style=\"position: absolute;top: 160px;right:300px\">";
        foreach($errors as $error)
        {
            echo "<tr><td>";    
            echo $error;
            echo "</td></tr>";
        }
    }
}
?>