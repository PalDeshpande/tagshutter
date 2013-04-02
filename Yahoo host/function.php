<?php
function user_exists($userid)
{
    $userid=mysql_real_escape_string($userid);
    $query=mysql_query("select count(*) from tbl_users where userid='$userid'");
    return (mysql_result($query,0)==1)?true:false;
}

function user_register($email,$userid,$password)
{
    $email=mysql_real_escape_string($email);
    $userid=mysql_real_escape_string($userid);
    $status=mysql_query("INSERT INTO tbl_users VALUES('$userid','$email','".md5($password)."')");
    if($status>0)
        return $userid;
    else
        return mysql_errno;
}

function logged_in()
{
    if(isset($_SESSION['userid']))
        return true;
    else
        return false;
}

function login_check($userid,$password)
{
    $userid=mysql_real_escape_string($userid);
    $login_query=mysql_query("select count(*) from tbl_users where userid='$userid' and password='".md5($password)."'");
    $_SESSION['userid']=$userid;
    return (mysql_result($login_query,0)?true:false);
}

function create_album($albumName,$albumDescription)
{
    $albumName=mysql_real_escape_string($albumName);
    $albumDescription=mysql_real_escape_string($albumDescription);
    $albumquery=mysql_query("INSERT INTO tbl_albums VALUES('','".$_SESSION['userid']."',UNIX_TIMESTAMP(),'$albumName','$albumDescription')");
    if($albumquery>0)
    {
        mkdir('uploads/'.mysql_insert_id(),0775);//0744 used locally
    mkdir('uploads/thumbs/'.mysql_insert_id(),0775);//0744 used locally
    }
    else
    {
        header('Location:error.php');
    }
}

function get_album()
{
    $albums=array();
    $albums_query=mysql_query("select tbl_albums.albumid,tbl_albums.timestamp,tbl_albums.name,LEFT(tbl_albums.description,50) as description,count(tbl_images.imageid) as image_count from tbl_albums left join tbl_images on tbl_albums.albumid=tbl_images.albumid where tbl_albums.userid='".$_SESSION['userid']."'group by tbl_albums.albumid");
    //$rows=mysql_num_rows($albums_query);
    while($albumrow=mysql_fetch_assoc($albums_query))
    {
        $albums[]=array('id'=>$albumrow['albumid'],'timestamp'=>$albumrow['timestamp'],
                      'name'=>$albumrow['name'],
                      'description'=>$albumrow['description'],
                      'imagecount'=>$albumrow['image_count']);
    }
    return $albums;
}

function albumdata($albumid)
{
    $albumdata=array();
    $dataquery=mysql_query("select name,description from tbl_albums where albumid=".$albumid);
    while($albumrow=mysql_fetch_array($dataquery))
    {
        $albumdata=array('name'=>$albumrow['name'],'desc'=>$albumrow['description']);
    }
    return $albumdata;
}

function editalbum($albumid,$albumname,$albumdescription)
{
    $albumid=(int)$albumid;
    $albumname=mysql_real_escape_string($albumname);
    $albumdescription=mysql_real_escape_string($albumdescription);
    mysql_query("UPDATE tbl_albums SET name='$albumname',description='$albumdescription' where albumid='$albumid' and userid='".$_SESSION['userid']."'");
}

function deletealbum($albumid)
{
    $albumid=(int)$albumid;
    mysql_query("delete from tbl_albums where albumid='$albumid' and userid='".$_SESSION['userid']."'");
    mysql_query("delete from tbl_images where albumid='$albumid' and userid='".$_SESSION['userid']."'");
    rmdir('uploads/'.$albumid);
    rmdir('uploads/thumbs/'.$albumid);
}

function create_thumb($directory, $image, $destination)
{
  $image_file = $image;
  $image = $directory.$image;

  if (file_exists($image)) {

    $source_size = getimagesize($image);

    if ($source_size !== false) {

      $thumb_width = 100;
      $thumb_height = 100;

      switch($source_size['mime']) {
        case 'image/jpeg':
             $source = imagecreatefromjpeg($image);
        break;
        case 'image/png':
             $source = imagecreatefrompng($image);
        break;
        case 'image/gif':
             $source = imagecreatefromgif($image);
        break;
      }

      $source_aspect = round(($source_size[0] / $source_size[1]), 1);
      $thumb_aspect = round(($thumb_width / $thumb_height), 1);

      if ($source_aspect < $thumb_aspect) {
        $new_size = array($thumb_width, ($thumb_width / $source_size[0]) * $source_size[1]);
        $source_pos = array(0, ($new_size[1] - $thumb_height) / 2);
      } else if ($source_aspect > $thumb_aspect) {
        $new_size = array(($thumb_width / $source_size[1]) * $source_size[0], $thumb_height);
        $source_pos = array(($new_size[0] - $thumb_width) / 2, 0);
      } else {
        $new_size = array($thumb_width, $thumb_height);
        $source_pos = array(0, 0);
      }

      if ($new_size[0] < 1) $new_size[0] = 1;
      if ($new_size[1] < 1) $new_size[1] = 1;

      $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
      imagecopyresampled($thumb, $source, 0, 0, $source_pos[0], $source_pos[1], $new_size[0], $new_size[1], $source_size[0], $source_size[1]);

      switch($source_size['mime']) {
        case 'image/jpeg':
             imagejpeg($thumb, $destination.$image_file);
        break;
        case 'image/png':
              imagepng($thumb, $destination.$image_file);
        break;
        case 'image/gif':
             imagegif($thumb, $destination.$image_file);
        break;
      }


    }

  }
}

function uploadimage($image_temp,$image_ext,$albumid)
{
    $albumid=(int)$albumid;
    mysql_query("INSERT INTO tbl_images VALUES('','".$_SESSION['userid']."','$albumid',UNIX_TIMESTAMP(),'$image_ext')");
    $imageid=mysql_insert_id();
    $imagefile=$imageid.'.'.$image_ext;
    
    move_uploaded_file($image_temp,'uploads/'.$albumid.'/'.$imagefile);
    create_thumb('uploads/'.$albumid.'/',$imagefile,'uploads/thumbs/'.$albumid.'/');
}

function getimages($albumid)
{
    $images=array();
    $imagequery=mysql_query("SELECT imageid,albumid,timestamp,ext from tbl_images where userid='".$_SESSION['userid']."' and albumid=".$albumid);
    while($imagerow=mysql_fetch_assoc($imagequery))
    {
        $images[]=array('id'=>$imagerow['imageid'],'albumid'=>$imagerow['albumid'],'ts'=>$imagerow['timestamp'],'ext'=>$imagerow['ext']);
    }
    
    return $images;
}

function deleteimage($imageid)
{
    $imageid=(int)$imageid;
    //mysql_query("delete from tbl_albums where albumid='$albumid' and userid='".$_SESSION['userid']."'");
    $imagequery=mysql_query("select albumid,ext from tbl_images where imageid='$imageid' and userid='".$_SESSION['userid']."'");
    $image_result=mysql_fetch_assoc($imagequery);
    
    $albumid=$image_result['albumid'];
    $imageext=$image_result['ext'];
    
    unlink('uploads/'.$albumid.'/'.$imageid.'.'.$imageext);
    unlink('uploads/thumbs/'.$albumid.'/'.$imageid.'.'.$imageext);
    
    mysql_query("delete from tbl_images where imageid='$imageid' and userid='".$_SESSION['userid']."'");
}
?>