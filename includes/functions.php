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

##############################
## General purpose functions #
##############################

function generateMessage($inputMessage, $url, $subject)
{
	/*
	Generates the mail to send using the user input (after some basic filtering).
	
	Parameters:
		string $inputMessage : message (may be empty) sent by the user
		string $url : URL of the shared page to be included in the mail
		string $subject : The subject of the mail (typically the shared page title)
		
	Return values:
		Returns the content of the mail to send as a string (without http headers).
	
	*/
	
	// Should the message be in txt or html format?
	$templateType = (ADD_HEADERS_ENABLED)?'html':'txt';
	
	// Assign templates vars
	$templateVars['url'] = $url;
	$templateVars['subject'] = $subject;
	$templateVars['inputMessage'] = stripslashes($inputMessage);
	if ($templateType == 'html')
	{
		// Html tags from user's message will appear (and not be interpreted).
		// Newlines are replaced by <br/> tags for them to appear in html.
		$templateVars['inputMessage'] = nl2br(htmlentities($templateVars['inputMessage']));
	}
	

	
	
	//// Filters for custom site-specific content.
	//// Edit this section if you want to add some.
	
	/// Vie De Merde
	if(!(strpos($url, 'viedemerde.fr/') === False))
	{
		// The shared page is from the Vie De Merde website
		
		
		$templateName = 'mail/vdm'; // Custom template

		// Fetch the 'VDM' story from the shared page.
		$templateVars['VDM'] = fetchVDM($url);
		if ($templateType == 'txt')
		{
			// Convert the html code from $templateVars['VDM'] to plain text.
			$templateVars['VDM'] = strip_tags($templateVars['VDM']); // There should not be any tag, but who knows.
			$templateVars['VDM'] = html_entity_decode($templateVars['VDM']);
		}
	}
	/// Youtube
	elseif(!(strpos($url, 'youtube.com/') === False))
	{
		// C'est une video youtube
		$templateName = 'mail/youtube';
		
		// On transforme l'url
		$templateVars['embedUrl'] = embedYoutubeURl($url);
	}
	else
	{
		// On utilise le comportement par défaut
		$templateName = 'mail/default';
	}
	
	// On renvoie le résultat final
	return generateFromTemplate($templateName, $templateVars, $templateType);
}

function fetchVDM($url)
{
	/*
		This function is intended to work with pages from the viedemerde.fr website. It fetches the first 'VDM' story found at a given URL. 
		
		Parameters:
			string $url : The URL where the 'VDM' story is to be found.

		Return values:
			Returns the story as a string, or the boolean False if none could be found.
		
	*/
	
	if (ini_get('allow_url_fopen')) {
		// On ouvre la page
		$VDM = file_get_contents($url);

		// Une phrase qui commence par "Aujourd'hui" et qui se termine par "VDM".
		$pattern = "/.*(Aujourd'hui[^\"][^<]*VDM).*/";

		preg_match($pattern, $VDM, $FirstMatch);

		return $FirstMatch[1]; // On extrait la VDM à proprement parler.
	} else {
		return False; // Retourne False en cas d'échec
	}
}

function embedYoutubeURl($url)
{
	/*
	This function is intended to work with URLs from the youtube website. It replaces the URL of a youtube video (usually ---youtube.com/watch?v=---) by the URL used to embed it (---youtube.com/v/---). 
	
	Parameters:
		string $url : The URL to the youtube video (user input).
	
	Return values:
		Returns the embed URL in a string.
	
	*/
	
	// Expected youtube URL format
	$pattern = '/(.*)youtube\.com\/watch.*[&\?]v=(\w[\w-]*)/';// This does not assume v is the first paramter (even if that wouls be the case with a youtube-generated URL)

	return preg_replace($pattern, '${1}youtube.com/v/${2}&hl=fr', $url);
}

function correctUrl($url)
{
	/*
	Corrects a (slightly) mistyped URL (in common cases). Intends to have a somewhat similar behaviour as the URL correcting implemented in common web browsers (but unfortunately lacking on most mail programs). Still experimental and not thoroughly tested.
	
	Parameters:
		string $url : The URL to correct (typically user input).
	
	Return values:
		Returns a valid URL in a string (hopefully).
	
	*/
	
	
	// Expected format of a URL
	$pattern = '/(\w+:\/\/)?(\w[\w-_]*\.)?(\w[\w-_]*\.\w{2,})([^w].*)?/'; // URL
	
	// Match the URL with the expected pattern
	preg_match($pattern, $url, $matches);
	
	// If the URL matches the pattern
	if(!empty($matches))
	{
		$matches[1] = $matches[1]?$matches[1]:'http://'; // Default protocol is http://
		$matches[2] = $matches[2]?$matches[2]:'www.'; // If there is no subdomain, www. is a safe guess
		$matches[4] = $matches[4]?$matches[4]:'/'; // The final slash
		return $matches[1] . $matches[2] . $matches[3] . $matches[4];
	}
	else
	{
		// The URL was not in the expected format, leave it that way.
		return $url;
	}	
}

function generateFromTemplate($templateName, $templateVars, $templateType = '')
{
	/* 
	Basic function for template management. Uses plain php scripts as templates.
	
	Parameters:
		string $templateName : path to the template file (php script). For convenience, the function allows the final .php extension to be ommited.
		array  $templateVars : associative array of the variables to be used in the template
		string $templateType : the intended type of output file (html, txt,...). This parameter defaults to an empty string which has no effect whatsoever. The template type should also appear in the template file extension prior to .php (.html.php for html, .txt.php for txt...). If the final .php is ommited, the function will check the template type extension, and append it if missing. 
		
	Return values:
		The output of the php script in a string.
	*/
	
	
	/// template name validation.
	preg_match('/(.*)(\.\w+)?(\.php)?$/', $templateName, $matches);
	
	// If the final .php extension was ommited
	if ($matches[3] == '')
	{
		// If the type extension is missing (or invalid)
		if ($templateType != '' && $matches[2] != $templateType) {
			$templateName = $matches[1] . '.' . $templateType; // Append the proper extension for template type
		}
		$templateName .= '.php'; // Append the missing .php extension
	}	
	
	// Extract template variables to local
	extract($templateVars); // ${$key} = $value;
	// Start output buffering
	ob_start();
	// Include the template file (to parse it)
	include('templates/' . $templateName);
	// Get the output from the content of the buffer
	$output = ob_get_contents();
	// End buffering and discard 
	ob_end_clean();	
	
	if ($templateType = 'txt')
	{
		// Wrap the output to 70 chars (for plain text emails)
		$output = wordwrap($output, 70); 
	}
	return $output;
}

?>