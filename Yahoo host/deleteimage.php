<?php
include 'init.php';
if(!logged_in())
{
    header('Location:index.php');
    exit();
}
?>
<?php
$imageid=$_GET['imageid'];
if(isset($imageid) || empty($imageid))
{
    deleteimage($imageid);
    header('Location:'.$_SERVER['HTTP_REFERER']);
    exit();
}
?>