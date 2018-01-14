<?php
session_start();
if (empty($_SESSION['user'])) {
	header("Location: ../login.php");
}
require_once("../php/connect.php");
$usernow = mysql_query("SELECT * FROM `user` WHERE `id` = '{$_SESSION['user']}'");
$data_usernow = mysql_fetch_array($usernow);
$theme = $data_usernow['theme'];

$group = mysql_query("SELECT * FROM `group` ORDER BY id ASC");
$totalRows_group = mysql_num_rows($group);

$latest = mysql_query("SELECT * FROM `lesson` ORDER BY `time_created` DESC LIMIT 0, 3");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>มุ่งสู่ห้อง K/Q ม.5 - Recall Card</title>
<link href="../css/main.css" rel="stylesheet" type="text/css" />
<link href="../css/main_<?php echo $theme; ?>.css" rel="stylesheet" type="text/css" />
<link href="../css/loggedin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.min.js"></script>
</head>

<body>
<div id="loading">Loading...</div>
<table border="0" cellspacing="0" cellpadding="0" id="all">
  <tr>
    <td width="50" valign="middle">
	  <div id="menu" class="icon"><img src="../images/menu.png" height="50" width="50" /></div>
	</td>
	<td>
	  <div id="topbar">
	    <div class="icon home"><img src="../images/home.png" height="50" width="50" /></div><div id="wide"><img src="../images/rctitle.png" height="50" width="150" /></div><div class="icon profile"><img src="../images/profile.png" height="50" width="50" /></div><div class="icon logout"><img src="../images/logout.png" height="50" width="50" /></div>
	  </div>
	</td>
  </tr>
  <tr>
    <td>
	  <div id="sidebar">
	    <div class="icon home"><img src="../images/back.png" height="50" width="50" /></div>
	    <div class="icon add"><img src="../images/add.png" height="50" width="50" /></div>
	    <div class="icon manage"><img src="../images/gear.png" height="50" width="50" /></div>
		<div class="high"></div>
	    <div class="icon info"><img src="../images/info.png" height="50" width="50" /></div>
	  </div>
	</td>
    <td>
	  <div id="main">
	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td width="200">
			  <div id="mainleft">
			    <div class="title">แบบฝึกหัดล่าสุด</div>
			    <?php while ($data_latest = mysql_fetch_array($latest)) {
					$thisuserid = $data_latest['user_id'];
					$thislessonid = $data_latest['id'];
					$checkuser = mysql_query("SELECT * FROM `user` WHERE `id` = '$thisuserid'");
					$data_checkuser = mysql_fetch_array($checkuser);
					$checkcard = mysql_query("SELECT * FROM `card` WHERE `lesson` = '$thislessonid'");
					$num_checkcard = mysql_num_rows($checkcard);
				?>
				<div class="clicktextbox latest" lesson="<?php echo $data_latest['id']; ?>">
				  <h3><?php echo $data_latest['name']; ?></h3>
				  <p>จำนวน <?php echo $num_checkcard; ?> ข้อ</p>
				  <p> โดย <?php echo $data_checkuser['name']; ?></p>
				</div>
				<?php } ?>
			  </div>
			</td>
			<td>
			  <div id="mainright">
				<?php while ($data_group = mysql_fetch_array($group)) {
				mysql_select_db("sunwsnet_edu");
				$lesson = mysql_query("SELECT * FROM `lesson` WHERE `group` = '{$data_group['id']}' ORDER BY `id` ASC");
				$num_lesson = mysql_num_rows($lesson); ?><div class="groupicon" group="<?php echo $data_group['id']; ?>">
				<div class="image"><img src="../images/theme/<?php echo $theme; ?>/groupicon.png" width="200" height="176" /></div>
				  <table border="0" cellspacing="0" cellpadding="0" width="200">
				    <tr>
			          <td align="left"><div class="name"><?php echo $data_group['name']; ?></div></td>
				      <td align="right"><div class="number"><?php echo "(".$num_lesson.")"; ?></div></td>
			        </tr>
			      </table>
				</div><?php } ?>
			  </div>
			</td>
		  </tr>
		</table>
	  </div>
	</td>
  </tr>
</table>
<div id="hidsidebar">
  <div class="inhid home">Back</div>
  <div class="inhid add">New lesson</div>
  <div class="inhid manage">Manage</div>
  <div class="high"></div>
  <div class="inhid info">Info</div>
</div>
<script type="text/javascript" src="../scripts/recallcard.js"></script>
<script type="text/javascript" src="../js/main.js"></script>
</body>
</html>