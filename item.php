<?php
session_start();
$_SESSION['key']=$_GET["q"];

//crawl the data in Taobao and Amazon
require("search.php");
crawl($_SESSION['key']);
?>

<!DOCTYPE html>                                                                                              
<html  class="dk_fouc has-js" lang="en">
  <head>
    <title>2tao</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/flat-ui.css">
    <link href="images/megaphone.ico" rel="shortcut icon">
  </head>
  <body>
    <div class="container">
	  <div class="span12">
    <dl class="palette palette-info">
      <form class="row" action="item.php" method="get">
			<div class="span2"><h3><a href="index.php">2tao</a></h3><dd>@ZHY</dd></div>
			<div class="span6">
				<input class="span6" type="text" placeholder="" value="" name="q"/>
			</div>
			<div class="span2">
        <input class="btn btn-primary btn-large btn-block" type="submit" value="Search" />
			</div>
		  </form>
		</dl>
    </div>
    <br>
	  <h3 class="demo-panel-title">
      Results<small>搜索结果</small>
    </h3>
<?php
  require('connect.php');
  if( isset($_GET['page']) )
  {
   $page = intval( $_GET['page'] );
  }
  else{
   $page = 1;
  } 

// 每页数量
  $page_size = 10;
// 总数据量
  $key=$_SESSION['key'];
  $sql = "select * from $key";
  $result = mysql_query($sql);
  $amount = mysql_num_rows($result);

  if($amount){
     if( $amount < $page_size ){ $page_count = 1; }             
     if( $amount % $page_size )
     {                                
         $page_count = (int)($amount / $page_size) + 1;        
      }
   else{
       $page_count = $amount / $page_size;                    
   }
  }
  else{
     $page_count = 0;
  }

  $url=$_SERVER["REQUEST_URI"];
  //URL分析
  $parse_url=parse_url($url);
  $url_query=$parse_url["query"]; //单独取出URL的查询字串
  if($url_query)
  {
  //url替换
    $url_query=ereg_replace("(^|&)page=$page","",$url_query);
    $url=str_replace($parse_url["query"],$url_query,$url);
    if($url_query) 
    {
      $url.="&page"; 
    }
    else 
    {
      $url.="page";
    }   
  }
  else 
  {
    $url.="?page";
  }
  // 翻页链接
  $page_string = '';
  if( $page == 1 ){
     $page_string .= '第一页|上一页|';
  }
  else{
    $prepg= ($page-1);
    $page_string .= "<a href='$url=1'>第一页</a>|<a href='$url=$prepg'>上一页</a>|";
  }
  if( ($page == $page_count) || ($page_count == 0) ){
     $page_string .= '下一页|尾页';
  }
  else{
    $nextpg=($page+1);
    $page_string .= "<a href='$url=$nextpg'>下一页</a>|<a href='$url=$page_count'>尾页</a>";
  }
  // 获取数据，以二维数组格式返回结果
  if( $amount ){
     $sql = "select * from $key order by price limit ". ($page-1)*$page_size .", $page_size";
     $result = mysql_query($sql);
      while ( $row = mysql_fetch_array($result) ){
         $rowset[] = $row;
      }
  }
  else{
     $rowset = array();
  }

?>  

 <div class="span12">
 <div class="span4">
<h4> 
<?php 
  echo "KEY Word: $key ".'<br>';
  echo "$amount records.";?>
</h4>
</div>
<div class="span2">
<a class="btn btn-large btn-block" href="<?php echo "item.php?q=".$key ?>">Show pic</a>
</div>
<div class="span2">
<a class="btn btn-large btn-block" href="<?php echo "item1.php?q=".$key ?>">No pic</a>
</div>
</div>
      <div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
			<ul class="thumbnails">

      <?php
      foreach ($rowset as $item )
       {
      ?>
          <li class="span4">
					<div class="thumbnail">
						<img alt="300x200" src="<?php echo $item['image']?>" />
						<div class="caption">
							<h5>
								<?php echo $item['title']?>
							</h5>
              <p>
								<?php 
                echo "￥".$item['price']
                ?>
							</p>
							<p>
								<?php 
              if($item['source']==0)
                echo "Taobao";
              if($item['source']==1)
                echo "Amazon";
              ?>
							</p>
							<p>
								<a class="btn btn-primary" href="<?php echo $item['url']?>">More</a>
							</p>
						</div>
					</div>
				</li>
      <?php } ?>
			</ul>
		</div>
	</div>
      <h4><?php echo $page_string?></h4>
      <br><br>

        <footer>
      <div class="container">
        <div class="row">
          <div class="span2"></div>
          <div class="span5">
             <h3 class="footer-title">About me</h3>
             <p>Zhang Hongyi, a student @ ZJU<br>
                This work is completed as the project of BS<br></p>
          </div>
        </div>
        </div>  
      </footer>
      </body>
      </html>