<?php
include 'init.php';

if(!logged_in())
{
    header('Location:index.php');
    exit();
}
?>
<h3>View Albums</h3>
<?php
$albumid=$_GET['albumid'];
$images=getimages($albumid);
if(empty($images))
{
    echo 'No Images in the album';
}
else
{
    foreach($images as $image)
    {
        echo '<a href="uploads/',$image['albumid'],'/',$image['id'],'.',$image['ext'],'"><img src="uploads/thumbs/',$image['albumid'],'/',$image['id'],'.',$image['ext'],'" alt="" title="Uploaded on ',date('D M Y / h:i',$image['ts']),'"/></a><a href="deleteimage.php?imageid=',$image['id'],'">x</a>';
    }
}
?>