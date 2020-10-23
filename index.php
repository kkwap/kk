<?php
include 'config.php';
include'func.php';
if(!empty($_GET['genre'])){
$title='Genre of '.queryencode($_GET['genre']).'';
}elseif(!empty($_GET['q'])){
$title='Results For '.queryencode($_GET['q']).'';
}else{
$title='Awaaz.Cf - Download Latest Music in High Quality for Free';
}
include'head.php';
if(!empty($_GET['genre'])){
$genrer=str_replace(' ',',',strtolower($_GET['genre']));
$genrer=str_replace('_',',',$genrer);
$genrer=str_replace('-',',',$genrer);
}else{
$q=queryencode($_GET['q']);
$artist = array('Atif Aslam','Justin Bieber','Pitbul','Bilal Saeed','Falak Shabbir','Sarmad Qadeer','Aima Baig','Ajmal Sajid','Mushtaq Cheena','Shreya','Arijit singh','QB','Shakira','Arman Khan','Shirley Setia','Rahat Fateh Ali Khan','NFAK','Katty Perry');
$no = rand(0,count($artist));
$keyword = $artist[$no];

$q = $q ? $q : $keyword;
}
if(!empty($_GET['page'])){
$noPage=$_GET['page'];
$page=($noPage-1)*20;
}else{
$noPage='1';
$page='0';
}
if(!empty($_GET['genre'])){
$json=json_decode(ngegrab('http://api.soundcloud.com/tracks.json?genres='.$genres.'&limit=20&offset='.$page.'&offset=0&client_id='.$soundcloud_api));
}else{
$json=json_decode(ngegrab('http://api.soundcloud.com/tracks.json?q='.str_replace(' ','-',$q).'&limit=20&offset='.$page.'&client_id='.$soundcloud_api));
}
echo"<div class=title align=center><b>$q</b></div>";
if (!empty($json[0]->title)){
foreach($json as $list){
$id=$list->id;
$permalink=$list->permalink;
$name=$list->title;
$size=format_size(getfilesize(getlinkdl($id)));
$duration=format_time($list->duration/1000);
$played=$list->playback_count;
 if($song=$list->artwork_url) {
$thumb = $song;
}
else {
$thumb = '/no_thumb.jpg';
}
echo'<div class="menu"><center><img src="'.$thumb.'" class="img-thumbnail"></center><br><a href="'.$dir.'download/'.$id.'/'.$permalink.'.html">'.$name.'.mp3</a></br>Size: '.$size.'<br/>Duration: '.$duration.'<br/></div>';}
echo '<div class="pager">';
if(!empty($_GET['genre'])){
if ($noPage > 1) {echo' <li class="previous"><a href="?genre='.strtolower($_GET['genre']).'&amp;page='.($noPage-1).'">&laquo; Previous</a> </li> ';}
if (!empty($json[9])) {echo' <li class="next"> <a href="?genre='.strtolower($_GET['genre']).'&amp;page='.($noPage+1).'">Next Page &raquo;</a> </li> ';}
}else{
if ($noPage > 1) {echo' <li class="previous"> <a href="?q='.querydecode($q).'&amp;page='.($noPage-1).'">&laquo; Previous</a> </li> ';}
if (!empty($json[9])) {echo'<li class="next"><a href="?q='.querydecode($q).'&amp;page='.($noPage+1).'">Next &raquo;</a></li></ul>';}
}
echo '</div><br>';
}else{echo'<div class="menu"><font color="red">Result Not Found, please use another keyword.</font></div>';}
include'last_search.php';
include'foot.php';
?>
