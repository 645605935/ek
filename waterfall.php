<?php
// header('Content-type:text/html; charset=utf-8');
// $mysql = mysql_connect('localhost','root','root');
// mysql_query('set names utf8',$mysql);
// mysql_select_db('waterfall',$mysql);
// $page = isset($_GET['page'])?(int)$_GET['page']:0;
// $num = isset($_GET['requestNum'])?(int)$_GET['requestNum']:20;
// $startNum  =$page*$num;
// $rows = mysql_query('select * from waterfall limit '.$startNum.' , '.$num.'');
// $data = array();
// while ($row = mysql_fetch_assoc($rows)){
// 	$data[] = $row;
// }
//
// echo json_encode($data);
echo '[{"title":"\u6807\u98980","src":"0.jpg","pinid":"1"},{"title":"\u6807\u98981","src":"1.jpg","pinid":"2"},{"title":"\u6807\u98982","src":"2.jpg","pinid":"3"},{"title":"\u6807\u98983","src":"3.jpg","pinid":"4"},{"title":"\u6807\u98984","src":"4.jpg","pinid":"5"},{"title":"\u6807\u98985","src":"5.jpg","pinid":"6"},{"title":"\u6807\u98986","src":"6.jpg","pinid":"7"},{"title":"\u6807\u98987","src":"7.jpg","pinid":"8"},{"title":"\u6807\u98988","src":"8.jpg","pinid":"9"},{"title":"\u6807\u98989","src":"9.jpg","pinid":"10"},{"title":"\u6807\u989810","src":"10.jpg","pinid":"11"},{"title":"\u6807\u989811","src":"11.jpg","pinid":"12"},{"title":"\u6807\u989812","src":"12.jpg","pinid":"13"},{"title":"\u6807\u989813","src":"13.jpg","pinid":"14"},{"title":"\u6807\u989814","src":"14.jpg","pinid":"15"},{"title":"\u6807\u989815","src":"15.jpg","pinid":"16"},{"title":"\u6807\u989816","src":"16.jpg","pinid":"17"},{"title":"\u6807\u989817","src":"17.jpg","pinid":"18"},{"title":"\u6807\u989818","src":"18.jpg","pinid":"19"},{"title":"\u6807\u989819","src":"19.jpg","pinid":"20"}]';
?>
