<?php
include 'config.php';
include'func.php';
$id=$_GET['id'];
$grab=json_decode(ngegrab('http://api.soundcloud.com/tracks/'.$id.'.json?client_id='.$soundcloud_api));
$duration=format_time($grab->duration/1000);
if($song=$grab->artwork_url) {
$thumb = $song;
}
else {
$thumb = '/no_thumb.jpg';
} if(!empty($grab->genre)){
$genre=$grab->genre;
}else{
$genre='Unknown';
}
$name=$grab->title;
$played=$grab->playback_count;
$permalink=$grab->permalink;
$size=format_size(getfilesize(getlinkdl($id)));
if(!empty($name) && !empty($_GET['id']) && !empty($_GET['permalink'])){
$title='Download mp3 '.$name.' ('.$size.')';
include ('head.php');
echo'<div class=title align=justify>';
echo '<span xmlns:v="http://rdf.data-vocabulary.org/#">';
echo '<span typeof="v:Breadcrumb"><a href="/" rel="v:url" property="v:title">Home</a></span>';
echo ' &#187; <span typeof="v:Breadcrumb"><a href="'.$dir.'/?genre='.$genre.'" rel="v:url" property="v:title">'.$genre.'</a></span>';
echo ' &#187; <span typeof="v:Breadcrumb"><span class="breadcrumb_last" property="v:title">'.$name.'</span>';
echo '</span>';
echo '</div>';
echo '<div class="menu">';
echo '<div class="ml"><b>'.$name.'<br/><center><img src="'.$thumb.'" class="img-thumbnail"/></center></b><div align="right"><a href="https://www.facebook.com/sharer/sharer.php?u='.$share.'"><img src="/fb.png"></a><a href="https://twitter.com/home?status=http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'"><img src="/Tw.png"></a></div></div>';
echo '<div class="ml">Artist: <a href="'.$dir.'?genre='.$genre.'">'.$genre.'</a></div>';
echo '<div class="ml">Duration: '.$duration.'</div>';
echo '<div class="ml">Size: '.$size.'</div>';
echo '<div class="ml">Bitrate: 128 kbps</div>';
echo '<div class="ml">Played: '.$played.' Times</div>';
echo '</div>';
$permexp=explode('-',$grab->permalink);
echo'<div class="menu">Tags: ';
foreach($permexp as $perma){
echo'<a href="'.$dir.'?q='.$perma.'">'.ucfirst($perma).'</a>, ';
}

$ttag=clearspace($genre);
$tgrab=json_decode(ngegrab('http://ws.audioscrobbler.com/2.0/?method=tag.getsimilar&tag='.strtolower($ttag).'&api_key='.$lastfm_api.'&format=json'));
$tjumlah=count($tgrab->similartags->tag)-1;
if($tjumlah < 4){
$tcount=$tjumlah;
}else{
$tcount='3';
}
if(!empty($tgrab->similartags->tag[0]->name)){
echo'</div><div class="list">Other Genre';
for($i=0;$i<=$tcount;$i  ){
echo'<a href="index.php?genre='.$tgrab->similartags->tag[$i]->name.'">'.$tgrab->similartags->tag[$i]->name.'</a>, ';
}

}

echo '</div><div class="menu" align="center">';
// Audio
echo '<iframe width="90%" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/'.$_GET['id'].'&color=0066cc"></iframe>';

$forses = md5(time());
$_SESSION[$forses] = $id;
$session = $_SESSION[$forses];
echo '</div><div class="menu" align="center"><a href="'.getlinkdl($id).'"><b><img src="http://kmwap.yn.lt/Img/dl.png"/></b></a></div>';
$genrer=str_replace(' ',',',$genre);
$genrer=str_replace('_',',',$genrer);
$genrer=str_replace('-',',',$genrer);
$jsonr=json_decode(ngegrab('http://api.soundcloud.com/tracks.json?genres='.strtolower($genrer).'&limit=8&offset=0&client_id='.$soundcloud_api));
if (!empty($jsonr[0]->title)){
echo'<div class="title"><b>Related Downloads</b></div><div class="menu">';
foreach($jsonr as $list){
$idr=$list->id;
$permalinkr=$list->permalink;
$namer=$list->title;
echo'<div class="ml">&raquo; <a href="'.$dir.'download/'.$idr.'/'.$permalinkr.'.html">'.$namer.'.mp3</a></div>';}
echo'</div>';
}
}else{
$title='Not Found';
include'head.php';
echo'<div class="eror">Sorry, file not found.</div>';
}
echo '</div>';
include'foot.php';
?>
