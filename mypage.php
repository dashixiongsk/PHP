<html>
<head>
	<style>

		.page a {
			padding: 2px 5px 2px 5px;
			border:#aaaadd 1px solid;text-decoration:none;
			margin:5px;
		}
		.page span.current{
			border:#000099 1px solid;background-color:#000099;
			color:#fff;
			padding:4px 6px 4px 6px;
			font-weight:bold;
			margin:2px;
		}
	</style>
</head>
<body>
<?php
//1 chuanru yema
$page = $_GET['p'];
//2 根据页码取数据
$host ='localhost';
$username = 'root';
$password = '123456';
$db = 'mydemo';
$pageSize = 10;
$showpage = 5;
$conn = mysql_connect($host,$username,$password);
if(!$conn){
	echo '数据库连接失败';
	exit;
}
mysql_select_db($db);
mysql_query('set names utf8');

$sql = "select * from test_t limit ".(($page-1)*10).",$pageSize";
$result = mysql_query($sql);
echo '<table border=1 cellspacing=0>';
while($row = mysql_fetch_assoc($result)){
	echo '<tr>';
	echo "<td>{$row['ID']}</td>";
	echo "<td>{$row['daqu']}</td>";
	echo "<td>{$row['city']}</td>";
	echo '<tr>';
}
echo '</table><br/>';

$sql = "select count(*) from test_t";
$total_result = mysql_query($sql);
$total = mysql_fetch_array($total_result);
$total = $total[0]; //共有多少条记录
//计算页数
$total_pages = ceil($total/$pageSize);

//3显示分页+数据

//计算偏移量
$pageoffset = ($showpage-1)/2;

$page_banner = "<div class='page'>";
if($page>1){
	$page_banner .= "<a href='".$_SERVER['PHP_SELF']."?p=1'>首页</a>";
	$page_banner .= "<a href='".$_SERVER['PHP_SELF']."?p=".($page-1)."'>上一页</a>";
}
$start = 1;
$end = $total_pages;
if($total_pages>$showpage){
	if($page>$pageoffset+1){
		$page_banner .="...";
		
	}
	if($page>$pageoffset){
		$start = $page-$pageoffset;
		$end =$total_pages>$page+$pageoffset?$page+$pageoffset:$total_pages;
	}else{
		$start = 1;
		$end = $total_pages>$showpage?$showpage:$total_pages;
	}
	if($page+$pageoffset>$total_pages){
		$start = $start-($page+$pageoffset-$end);
	}
	
	
}
//显示页码   ...  3  4 5 6 7...
for($i = $start; $i<=$end;$i++){
	if($page == $i){
			$page_banner .= "<span class='current'>{$i}</span>";

	}else{
			$page_banner .= "<a href='".$_SERVER['PHP_SELF']."?p=".$i."'>{$i}</a>";

	}
}
//尾部省略
if($total_pages> $showpage && $total_pages > $page+$pageoffset){
	$page_banner .="...";
}

if($page<$total_pages){
	$page_banner .= "<a href='".$_SERVER['PHP_SELF']."?p=".($page+1)."'>下一页</a>";
	$page_banner .= "<a href='".$_SERVER['PHP_SELF']."?p=".($total_pages)."'>尾页</a>";
}

	$page_banner .="共{$total_pages}页&nbsp{$total}条记录 <form action='mypage.php'>";
	$page_banner .="到第<input type='text' size='2' name='p'/><input type='submit' value='提交'/>";
	$page_banner .="</form><div>";
	echo $page_banner;
	?>


</body>
</html>












