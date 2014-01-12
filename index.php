<!DOCTYPE html>           
<?php session_start(); ?>                                                                                       
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
        <h1>
          <div class="demo-headline">
            二淘比价<br>
          <small>专注淘宝亚马逊二十年</small>
          </div>
        </h1>
      <form class="row" action="item1.php" method="get">
          <div class="span2"></div>
          <div class="span6">
				      <input class="span6" type="text" placeholder="" value="" name="q"/>
          </div>
          <div class="span2">                                                                       
              <input class="btn btn-primary btn-large btn-block" type="submit" value="Search" />
          </div>
			</form>
      <br><br><br><br><br><br><br>

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
