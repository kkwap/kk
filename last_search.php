<?php
$div = "| # |";
$dat = 'last_search.txt';
$fp=fopen($dat, 'r');
$count=fgets($fp);
fclose($fp);
$search = $q;
$search = str_replace(' ', ' ', $search);
$data = explode($div, $count);
if (in_array($search, $data)) 
{
$tulis = implode($div, $data);
$hit=$tulis;
}
else 
{
$data = explode($div, $count);
$tulis = $data[1].''.$div.''.$data[2].''.$div.''.$data[3].''.$div.''.$data[4].''.$div.''.$data[5].''.$div.''.$data[6].''.$div.''.$data[7].''.$div.''.$data[8].''.$div.''.$data[9].''.$div.''.$data[10].''.$div.''.$data[11].''.$div;
$tulis .= $search;
$hit=$tulis;
}
$cuplissayangputri=fopen($dat, 'w');
fwrite($cuplissayangputri,$tulis);
fclose($cuplissayangputri);
$fa=fopen($dat, 'r');
$b=fgets($fa);
fclose($fa);
$c = explode($div, $b);
echo '</div></div><br/><br/><div class="col-lg-4">
<div class="bs-component">
<div class="panel panel-info">
<div class="panel-heading">
<h3 class="panel-title">Last Searches</h3>
</div>
<div class="panel-body">
';
foreach(array_reverse($c) as $d)
{
echo '<a href="/index.php?q='.$d.'">'.$d.'</a><b>,</b>';
}
echo '</div></div></div></div><br><br/>';
?>
