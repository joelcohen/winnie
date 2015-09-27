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

#######################
## Configuration File #
#######################


// Winnie version number
define(WINNIE_VERSION, '3.14r1592653'); // Do not edit


/// Edit Settings bellow
/// --------------------


## Server settings

	// Is Winnie installed?
	define(WINNIE_INSTALLED, False); // Set to True if you have edited this file to your configuration.

	// Does the servers enable adding HTTP headers to mails without displaying them in the mail's content?
	define(ADD_HEADERS_ENABLED, True); // If you don't know about this one, leave it to True and send a mail using Winnie. If the mail you get contains weird text at the beginning set to False.

	// URL where Winnie is uploaded
	define(WINNIE_URL, 'http://...url to Winnies Folder.../'); // Enter the full URL which should end with a trailing slash /

## Winnie settings

	// Language
	define(LANGUAGE, 'fr'); // Language for winnie's web interface
	// 'en' for English
	// 'fr' for French

	// Winnie's Signature (appears at the bottom of mails)
	define(BOT_SIGNATURE, 'Winnie - Version' . WINNIE_VERSION);

	// Password for Winnie
	define(PASSWORD, '...my password...'); // Choose any password and communicate it to your users
	
## Mailing list settings

	// Mailing list's e-mail Adress
	define(ML_ADRESS, 'my_mailing_list@domain.com'); // This is the e-mail Adress to which Winnie should send its mails

	// Mailing list's Name
	define(ML_NAME, 'My Mailing List'); // The name of your mailing list as you want it to appear.

	// Member of the mailing list with their email addresses.
	$ML_memberList = array(); // Do not Edit
	// The format is: $ML_memberList['Name'] = 'e-mail address';
	$ML_memberList['John Doe']	= 'john.doe@domain.com';
	$ML_memberList['Jason Mraz']= 'jason@jasonmraz.com';
	$ML_memberList['Jane Doe']		= 'l33t_j4n3@g33k.org';
	$ML_memberList['And-so On']		= '...';
	// ...

?>