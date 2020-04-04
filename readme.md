# Winnie

## One-click Link-sharing

**Version 3.14r15926 (Lombrique Lubrique)**

*Copyright (C) 2008, Joel Cohen*

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.



## What is it?

Winnie is a script aiming at simplifying the process of sharing weblinks. There are three parts to it:

- Winnie running on a server
- A mailing list (running somewhere on a server...)
- Members of the mailing list, surfing the web and eager to share their findings

Basically, Winnie is a script allowing members to send links by mail to the mailing list. Winnie can be invoked via a simple HTTP request. Perharps the most interesting feature is the ability to make such a request with just one click on a bookmarklet. Should some information be missing in your request, you will be taken to a web interface to fill it in. This is convenient if you wish to add some comment to the message you're sending.  

## What do I need?

In order for Winnie to work, you need:

- A webserver running PHP version 4.3 or higher
- A mailing list
- Some time to waste

You must be able upload files to the webserver. It must support PHP scripts (version 4.3 or higher), and be able to send mails to the mailing list. The mailing list must allow mails coming from the server.

## Installation

To install Winnie, you first need to edit the configuration file found at `includes/config.php` (with any text editor). Then, upload the whole `winnie/` folder to a webserver. Winnie should now be up and running (to check so, go to the URL where you uploaded it in a web browser). Notify your end-users by sending them a link to the `tuto/` folder so that they can bookmark the right url (you may do so by using Winnie!). And you're done! Just wait for these awesome links to flock into your inbox.

## How to customize it?

Editing the `config.php` file (found in the `includes/` folder) should enable you to quickly configure Winnie to work right out of the box. You can also customize the style of Winnie's interface and mails by editing the related css files found on the `css/` folder (`default.css` for the web interface, and `mail.css` for mails). For additional control over the contents of mails, you may edit the mail templates found in the `templates/` folder. Winnie's functionality can be expanded by adding filters and templates to extract and display the content of specific sites (check `includes/functions.php` for more details). These customisations are transparent for the end-users, and do not require them to change anything to their settings. Finally, you may also choose to delve into Winnie's code and tinker with it to your liking.
