<?php
##
## WINNIE, Copyright (C) 2008, Joël Cohen
## 
## This program is free software: you can redistribute it and/or modify
## it under the terms of the GNU General Public License as published by
## the Free Software Foundation, either version 3 of the License, or
## (at your option) any later version.
## 
## This program is distributed in the hope that it will be useful,
## but WITHOUT ANY WARRANTY; without even the implied warranty of
## MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
## GNU General Public License for more details.
## 
## You should have received a copy of the GNU General Public License
## along with this program.  If not, see <http://www.gnu.org/licenses/>.
##

// Configuration file
include('../includes/config.php');
// Localization strings
include('../includes/language/'. LANGUAGE . '/tuto.php');
// General purpose functions
include('../includes/functions.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" class="plain">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" href="../css/default.css" type="text/css" media="screen" title="Winnie" charset="utf-8">

	<title><?php echo ML_NAME; ?> :: <?php echo LS_TUTORIAL; ?></title>
	
</head>

<body>
	<h1><?php echo ML_NAME; ?></h1>	
	<h2><?php echo LS_TUTORIAL; ?></h2>
	
<div id="Main">
	<h2><?php echo LS_TUTORIAL_TITLE; ?></h2>
	
	<h3><?php echo LS_TUTORIAL_HEADER_ON_YOUR_COMPUTER; ?></h3>
	
	<p><?php echo LS_TUTORIAL_PARAGRAPH_ON_YOUR_COMPUTER; ?></p>
	
	<table>
<?php


	foreach($ML_memberList as $email){
		echo "		<tr>\n";
		echo "			<th>$email</th>\n";
		echo "			<td><a href=\"javascript:location.href='".WINNIE_URL."?from=".urlencode($email)."&amp;pass=".PASSWORD."&amp;url='+encodeURIComponent(location.href)+'&amp;title='+encodeURIComponent(document.title.replace(/^\s*|\s*$/g,''))+'&amp;ok='\">1 ".LS_CLICK."</a></td>\n";
		echo "			<td><a href=\"javascript:location.href='".WINNIE_URL."?from=".urlencode($email)."&amp;pass=".PASSWORD."&amp;url='+encodeURIComponent(location.href)+'&amp;title='+encodeURIComponent(document.title.replace(/^\s*|\s*$/g,''))\">2 ".LS_CLICKS."</a></td>\n";
		echo "		</tr>\n";
	}

	?>
	</table>
	
	<h3><?php echo LS_TUTORIAL_HEADER_ELSEWHERE; ?></h3>
	
	<p><?php echo LS_TUTORIAL_PARAGRAPH_ELSEWHERE; ?></p>
</div>	

	<div id="Footer">
		<p>Winnie :: Version <?php echo WINNIE_VERSION; ?></p>
	</div>
</body>
</html>



