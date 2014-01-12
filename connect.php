<?php
     $conn=mysql_connect("localhost","root","123456") or die("CANNOT CONNECT TO MYSQL".mysql_error());
     mysql_select_db("2tao",$conn) or die("MYSQL ACCESS ERROR".mysql_error());
     mysql_query("set names 'gb2312'");
?>