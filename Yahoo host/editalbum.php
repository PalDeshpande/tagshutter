<?php
include 'init.php';

if(!logged_in())
{
    header('Location:index.php');
    exit();
}
?>
<h3>Edit Albums</h3>
<?php
$albumid=$_GET['albumid'];
$albumdata=albumdata($albumid);
?>
<form action="" method="post">
    <p>Name:<br /><input type="text" name="txtAlbumName" value='<?php echo $albumdata['name'] ?>' /></p>
    <p>Description:<br/><textarea name="txtDescription" rows="6" cols="35" maxlength="255"><?php echo $albumdata['desc'] ?></textarea></p>
    <p><input type="submit" value="Edit Album" /></p>
</form>
<?php
if(isset($_POST['txtAlbumName'],$_POST['txtDescription']))
{
    $albumname=$_POST['txtAlbumName'];
    $description=$_POST['txtDescription'];
    
    $errors=array();
    if(empty($albumname)||empty($description))
    {
        $errors[]='album name and desscription required';
    }
    if(empty($errors))
    {
        //edit album
        editalbum($albumid,$albumname,$description);
        header('Location:album.php');
        exit();
    }
}
?>
