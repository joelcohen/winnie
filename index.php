<?php

## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ##
## __          ___             _      
## \ \        / (_)           (_)     
##  \ \  /\  / / _ _ __  _ __  _  ___ 
##   \ \/  \/ / | | '_ \| '_ \| |/ _ \
##    \  /\  /  | | | | | | | | |  __/
##     \/  \/   |_|_| |_|_| |_|_|\___|
##
## One-click Link-sharing
##
## +-----------------------------------------+
## | Version 3.14r15926 (Lombrique Lubrique) |
## +-----------------------------------------+
##
##
## Copyright (C) 2008, Joël Cohen
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
##
## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## 


// Configuration file
include('includes/config.php');
// Localization strings
include('includes/language/'. LANGUAGE . '/index.php');
// General purpose functions
include('includes/functions.php');

if (! WINNIE_INSTALLED)
{
	// Winnie is not yet installed
	// Redirect to the read me
	header('location: readme.html');
	exit; //End of script
}


##########################################
## Preliminary processing of input data ##
##########################################

// Flush unnecessary whitespace
foreach ($_GET as $key => $value)
{
	$_GET[$key] = trim($value);
}

// Correct a possibly mistyped URL
$_GET['url'] = correctUrl($_GET['url']);


if (isset($_GET['ok']) && $_GET['url'] != '') {
	// The URL was not empty
	// The user has validated his message ($_GET['ok'] had a value).
	
	if ($_GET['pass'] == PASSWORD && in_array($_GET['from'], $ML_memberList)) {
		// Password was correct.
		// User provided a valid e-mail adress from the members list.
		
		######################
		## Sending the mail ##
		######################
		
			// To
			$to      = isset($_GET['test'])?$_GET['from']:ML_ADRESS;
				// Test mode allows mails to be sent only to the user itself (for testing purposes)
		
			// Subject
			$subject = stripslashes($_GET['title']);
		
			// Message body
			$message = generateMessage($_GET['comment'], $_GET['url'], $subject);
			
			// From
			$from = array_search($_GET['from'], $ML_memberList).' <'.$_GET['from'].'>';// Nom <e-mail>
		
			// HTTP Headers
			if (ADD_HEADERS_ENABLED === True)
			{
				// If Winnie is configured to add some.
				$headers = 'From: '. $from . "\r\n";
				$headers .= 'Reply-To: ' . $to . "\r\n";
				$headers .= 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				$headers .=	'X-Mailer: Winnie,  PHP/' . phpversion();
			} else {
				// Otherwise they are left essentially empty.
				$headers = 'From: '. $from;
			}
			
			
			// Send the mail
			mail($to, $subject, $message, $headers);
	

		#########################################
		## Redirect user to where he came from ##
		#########################################
		
		// HTTP redirection
		header('location: ' . $_GET['url']);
		exit; //End of script
		
		
		// In every other cases, the web interfaces has to be displayed.
	}
	elseif (in_array($_GET['from'], $ML_memberList)) {
		// User provided a valid e-mail adress from the members list but a worng password (either wrong or empty).
		$errorInput = 'pass'; // Input containing the error
		$errorMessage = $_GET['pass']?LS_ERROR_MESSAGE_INVALID_PASSWORD:LS_ERROR_MESSAGE_EMPTY_PASSWORD;
	}
	else {
		
		// User did not provide a valid e-mail adress.
		$errorInput = 'from'; // Input containing the error
		$errorMessage = LS_ERROR_MESSAGE_INVALID_EMAIL;
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" class="plain">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" href="css/default.css" type="text/css" media="screen" title="Winnie" charset="utf-8">

	<title><?php echo ML_NAME; ?>  :: <?php echo LS_WEB_INTERFACE_PAGE_TITLE; ?></title>
	
</head>

<body>
	<h1><?php echo ML_NAME; ?></h1>	
	<h2><?php echo LS_WEB_INTERFACE_PAGE_TITLE; ?></h2>
	
	<form action="index.php" method="get" accept-charset="utf-8">
		<?php
		// Display errors (if any).
		echo (isset($errorMessage)?'<div class="Error">'.LS_ERROR_MESSAGE.' : '.$errorMessage.'</div>':'');
		?>
		<fieldset id="message">
		<ol>
			<li>
				<label for="title"><?php echo LS_SUBJECT; ?></label>
				<input type="text" name="title" value="<?php echo stripslashes($_GET['title']); ?>" id="title"/>
			</li>
			<li>
				<label for="from"><?php echo LS_FROM; ?> <span class="Warning">(<?php echo LS_WEB_INTERFACE_FROM_WARNING; ?>)</span></label>
				<input
					type="text"
					name="from" 
					<?php echo ($errorInput == 'from')?'class="Error"':''; ?>
					value="<?php echo stripslashes($_GET['from']); ?>"
					id="from"/>
			</li>
			<li>
				<label for="url"><?php echo LS_URL; ?></label>
				<input type="text" name="url" id="url" class="url" value="<?php echo stripslashes($_GET['url']); ?>"/>
			</li>
			<li>
				<label for="comment"><?php echo LS_COMMENT; ?></label>
				<textarea name="comment"  rows="6"><?php echo stripslashes($_GET['comment']); ?></textarea>
			</li>
			<li>
				<label for="pass"><?php echo LS_PASSWORD; ?></label>
				<input
					type="password"
					name="pass"
					<?php echo ($errorInput == 'pass')?'class="Error"':''; ?>
					value="<?php echo $_GET['pass']; ?>"
					id="pass"/>
			</li>
		</ol>
		</fieldset>
		<input type="hidden" name="ok" value="" id="ok"/>
		<?php
		// If in mode test, add an hidden input (to stay in test mode).
		echo (isset($_GET['test'])?'<input type="hidden" name="test" value="" id="test"/>'."\n":'');
		?>
		<input type="submit" value="<?php echo LS_WEB_INTERFACE_SUBMIT_BUTTON; ?> &rarr;"/>
	</form>
	
	<div id="Footer">
		<p>Winnie :: Version <?php echo WINNIE_VERSION; ?></p>
	</div>
</body>
</html>