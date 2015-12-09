<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width"/>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<link rel="icon" href="img/favicon.ico" type="image/x-icon"/>
<title>IEV Partitions</title>
<link rel="image_src" href="http://www.nalo-corporation.net/turbet_e/idp/img/logo.png" type="image/png"/>
<meta property="og:image" content="http://www.nalo-corporation.net/turbet_e/idp/img/logo.png"/>
<meta property="og:type" content="website"/>
<meta property="og:title" content="IEV Partitions"/>
<meta property="og:url" content="http://www.nalo-corporation.net/turbet_e/idp/index.php"/>
<meta property="og:description" content="Partitons du classeur, paroles des chants avec les recharges 17 à 21 du répertoire Il est vivant !"/>
<style media="screen" type="text/css">
@font-face{font-family:'Open Sans';src:url('font/OpenSans-Light.ttf') format('truetype');}
a{outline:0;}
input[type=number]::-webkit-outer-spin-button,input[type=number]::-webkit-inner-spin-button{-webkit-appearance:none;margin:0;}
input[type=number]{-moz-appearance:textfield;}
html{height:100%;min-height:100%;}
img{border:0;vertical-align:middle;}
body,table{margin:auto;font-family:Open Sans;font-size:14px;}
body{height:100%;min-height:100%;background-image:url('img/fond.png');background-attachment:fixed;background-repeat:no-repeat;background-position:center;background-size:cover;}
#head{background-color:#555;position:fixed;z-index:100;width:100%;height:50px;}
p{margin:0;}
#pa,#co,#submit{width:35px;}
#pa,#ti,#co,#submit{line-height:40px !important;border:1px solid #000;padding:0px 5px;margin-top:5px;}
#submit{cursor:pointer;}
table{border-collapse:collapse;opacity:0.9;filter:alpha(opacity=90);width:100%;}
.title{text-align:left;border-right:1px solid #444;border-left:1px solid #444;}
tr a{text-decoration:none;color:#2980b9;}
body,.part,.page{text-align:center;}
tr{line-height:40px;background-color:#EEE;}
tr:hover{background-color:#BBB;color:#FFF;}
td{padding:5px;}
.grey,#paroles{background-color:#FFF;}
#paroles{opacity:0.9;filter:alpha(opacity=90);
min-height:calc(100% - 50px);
min-height:-webkit-calc(100% - 50px);
min-height:-moz-calc(100% - 50px);}
#partition{width:100%;}
.tdlink{height:100%;width:100%;}
</style>
<style media="screen and (orientation:landscape)" type="text/css">
body{background-image:url('img/fond_land.png');}
</style>
</head>
<body>
<table>
<div id="head">
<form id="search" autocomplete="off" action="index.php" method="post">
<p>
<input id="pa" placeholder="Page" type="number" name="pa"/>
<input id="ti" placeholder="Titre" type="text" name="ti" size="7"/>
<input id="co" placeholder="Cote" type="number" name="co"/>
<input id="submit" type="submit" value="&#128270"/>
</p>
</form>
</div>
<div style="height:50px;"></div>
<?php
//$bdd = new PDO('mysql:host=localhost;dbname=turbet_e', 'turbet_e', 'MQtZET9x4UWfG9nV');
$bdd = new PDO('mysql:host=localhost;dbname=turbet_e', 'turbet_e', 'MQtZET9x4UWfG9nV');
$bdd -> query('SET NAMES UTF8');
if((isset($_POST['pa']) && $_POST['pa'] != null)||(isset($_POST['ti']) && $_POST['ti'] != null)||(isset($_POST['co']) && $_POST['co'] != null)){
$pa = htmlspecialchars($_POST['pa']);
$exp = array("oe","OE","Oe");
$ti = str_replace($exp,"œ",htmlspecialchars($_POST['ti']));
$co = htmlspecialchars($_POST['co']);
while($pa[0] == '0' && $pa[1] != null){$pa = substr($pa,1);}
while($co[0] == '0' && $co[1] != null){$co = substr($co,1);}
if((isset($_POST['pa']) && $_POST['pa'] != null)&&(isset($_POST['ti']) && $_POST['ti'] != null)&&(isset($_POST['co']) && $_POST['co'] != null)){
$rek = $bdd -> query("SELECT * FROM chants WHERE titre LIKE '%$ti%' OR part LIKE '$co%' OR page LIKE '$pa' ORDER BY titre ASC");}
else if((isset($_POST['pa']) && $_POST['pa'] != null)&&(isset($_POST['ti']) && $_POST['ti'] != null)){
$rek = $bdd -> query("SELECT * FROM chants WHERE titre LIKE '%$ti%' OR page LIKE '$pa' ORDER BY titre ASC");}
else if((isset($_POST['pa']) && $_POST['pa'] != null)&&(isset($_POST['co']) && $_POST['co'] != null)){
$rek = $bdd -> query("SELECT * FROM chants WHERE part LIKE '$co%' OR page LIKE '$pa' ORDER BY titre ASC");}
else if((isset($_POST['ti']) && $_POST['ti'] != null)&&(isset($_POST['co']) && $_POST['co'] != null)){
$rek = $bdd -> query("SELECT * FROM chants WHERE titre LIKE '%$ti%' AND part LIKE '$co%' ORDER BY titre ASC");}
else if(isset($_POST['pa']) && $_POST['pa'] != null){
$rek = $bdd -> query("SELECT * FROM chants WHERE page LIKE '$pa' ORDER BY titre ASC");}
else if(isset($_POST['co']) && $_POST['co'] != null){
$rek = $bdd -> query("SELECT * FROM chants WHERE part LIKE '$co%' ORDER BY part ASC");}
else{$rek = $bdd -> query("SELECT * FROM chants WHERE titre LIKE '%$ti%' ORDER BY titre ASC");}
$id = 0;
while ($data = $rek -> fetch()){
$id1 = $data['id'];
$page = $data['page'];
$titre = $data['titre'];
$part = $data['part'];
if($id % 2 == 0)
{echo '<tr>';}else{echo '<tr class="grey">';}
if($page != 0){
if($page < 10){$str1 = 'p00'.$page;}
else if($page < 100){$str1 = 'p0'.$page;}
else{$str1 = 'p'.$page;}}
else{$str1 = 'p???';}
if($part < 1000){$str2 = '0'.$part;}
else{$str2 = $part;}
if(file_exists('paro/'.$part.'.txt') == 1)
{echo '<td class="page"><a href="?p='.$part.'"><div class="tdlink">'.$str1.'</div></a></td>';}
else{echo '<td style="color:#e74c3c;cursor:no-drop;" class="page">'.$str1.'</td>';}
if(file_exists('jpg/'.$part.'.jpg') == 1 || file_exists('jpg/'.$part.'-0.jpg') == 1)
{echo '<td class="title"><a href="?j='.$part.'"><div class="tdlink">'.$titre.'</div></a></td>';}
else{echo '<td style="color:#e74c3c;cursor:no-drop;" class="title">'.$titre.'</td>';}
if(file_exists('part/'.$part.'.pdf') == 1)
{echo '<td class="part"><a href="part/'.$part.'.pdf"><div class="tdlink">'.$str2.'</div></a></td>';}
else{echo '<td style="color:#e74c3c;cursor:no-drop;" class="part">'.$str2.'</td>';}
echo '</tr>';
$id++;}
$rek->closeCursor();
$bdd=null;}
?>
</table>
<?php
if(isset($_GET['p']) && $_GET['p'] != null){
echo '<p id="paroles"><br>';
$b=1;
$f=fopen('paro/'.$_GET["p"].'.txt','r');
while(!feof($f)){
$l=fgets($f);
if($l=="\n"){$b=0;}
if($l[0]=="R" && $l[1]=="."){$b=1;}
if(!$b){echo $l.'<br>';}
else{echo '<b>'.$l.'</b><br>';}}
fclose($f);
echo '<br></p>';}
?>
<?php
if(isset($_GET['j']) && $_GET['j'] != null){
$i=0;$e=1;
while($e==1){
if(file_exists('jpg/'.$_GET["j"].'-'.$i.'.jpg')==1){
echo '<img id="partition" src="jpg/'.$_GET["j"].'-'.$i.'.jpg"/><br>';
$i++;}
else{$e=0;}}
if(!$i){echo '<img id="partition" src="jpg/'.$_GET["j"].'.jpg"/>';}}
?>
</body>
</html>
