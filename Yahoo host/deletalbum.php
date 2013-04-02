<?php
include 'init.php';

if(!logged_in())
{
    header('Location:index.php');
    exit();
}
?>
<?php
$albumid=$_GET['albumid'];
if(isset($albumid))
{
    deletealbum($albumid);
    header('Location:album.php');
}
else{
    echo 'Required album not found for deletion';
}
?>
