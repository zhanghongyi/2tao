<?php

require("classes/simple_html_dom.php");
include("connect.php");
ini_set('memory_limit','-1');

function findNum($str=''){
	$str=trim($str);
	if(empty($str)){return '';}
	$temp=array('1','2','3','4','5','6','7','8','9','0');
	$result='';
	for($i=0;$i<strlen($str);$i++){
		if(in_array($str[$i],$temp)){
			$result.=$str[$i];
		}
	}
	return $result;
}

function handle_tb(&$key,$page)
{
  $standurl='http://s.taobao.com/search?q=';
  $num=40*$page;
  $hurl='&s='."$num";
  $url=$standurl.$key.$hurl; 
  $html=file_get_html($url);

foreach($html->find('div.item-box') as $e)
{
    //$e=mb_convert_encoding($e, "UTF-8"); 
    foreach($e->find('h3[class="summary"]') as $summary)
    {
    $title=$summary->plaintext;
      foreach($summary->find('a') as $url)
        $url=$url->href;
    }
    //echo $url. '<br>';
    //echo $title . '<br>';
    foreach($e->find('img') as $image)
    $img= $image->src;
    //echo $img . '<br>';
    //$sql=mysql_query("insert into product(image) values('$image')"); 
    foreach($e->find('div[class="col price"]') as $p)
    $price=findNum($p->innertext)/100;
    //echo "Price= ". $price . '<br>';
    foreach($e->find('div[class="col dealing"]') as $d)
    $dealing=findNum($d->innertext);
    //echo "Dealings in one month: " .$dealing . '<br>';
    foreach($e->find('div[class="col end shipping"]') as $s)
    $shipping=$s->innertext;
    //echo "shipping" .$shipping. '<br>';
    foreach($e->find('div[class="col seller"]') as $se)
    $seller=$se->innertext;
    //echo $seller .'<br>';
    foreach($e->find('div[class="col end loc"]') as $l)
    $loc=$l->innertext;
    //echo $loc . '<br>';
   
  $sql="insert into $key(url,price,source,title,image)
    values
  ('$url',$price,0,'$title','$img')";
  mysql_query($sql);
                        
}
$html->clear();
}

function handle_amazon(&$key,$page)
{
  $standurl='http://www.amazon.cn/s/&keywords=';
  $hurl="&page=".$page;
  $url=$standurl.$key.$hurl; 
  $html=file_get_html($url);
foreach($html->find('div[class=rslt prod celwidget"]') as $a)
{  foreach($a->find('img') as $image)
    $img= $image->src;
   foreach($a->find('span[class="bld lrg red"]') as $pa)
			$pricea=$pa->innertext;
		foreach($a->find('h3[class="newaps"]') as $infoa)
			foreach($infoa->find('a') as $linka){
				$url=$linka->href;
				$title=$linka->plaintext; 
      }
    $price=findNum($pricea)/100;
  $sql="insert into $key(url,price,source,title,image)
    values
  ('$url',$price,1,'$title','$img')";
  mysql_query($sql);
                        
}
$html->clear();
}
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}

function crawl($key)
{
   $sql = "CREATE TABLE IF NOT EXISTS $key (
  url varchar(200) NOT NULL default '',
  price float(10,2) default NULL,
  title tinytext character set utf8 collate utf8_unicode_ci,
  source int(11) default NULL,
  image varchar(200),
  PRIMARY KEY  (url)
  ) ";
  mysql_query($sql);
  $max_page=2; 
  $i=0;
  while($i<$max_page){
  handle_tb($key,$i);
  handle_amazon($key,$i);
  $i=$i+1;
  
  }
} 
?>
