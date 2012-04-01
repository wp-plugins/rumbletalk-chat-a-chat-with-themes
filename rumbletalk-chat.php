<?php
/*
Plugin Name: RumbleTalk Chat
Plugin URI: http://www.rumbletalk.com/3rdsupport.php
Description: Add a <strong>Free Group Chat Widget</strong> to your blog or site in under a minute
Version: 1.0.4
Author: Yanir Shahak
Author URI: http://www.rumbletalk.com/contact_us.php
License: GPL2

Copyright 2011 Yanir Shahak (email : yanir@rumbletalk.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

	class RumbleTalkChat
	{
		protected $options;

		public function __construct()
		{
			$this->options = array
			(
				"rumbletalk_chat_code",
				"rumbletalk_chat_width",
				"rumbletalk_chat_height"
			);

			register_activation_hook( __FILE__, array( &$this, "install" ) );
			register_deactivation_hook( __FILE__, array( &$this, "unInstall" ) );

			if ( is_admin() )
			{
				add_action( "admin_menu", array( &$this, "adminMenu" ) );
			}
			else
			{
				add_filter( "the_content", array( &$this, "embed" ) );
			}
		}

		public function adminMenu()
		{
			add_options_page
			(
				"RumbleTalk Chat",
				"RumbleTalk Chat",
				"administrator",
				"rumbletalk-chat",
				array
				(
					&$this,
					"drawAdminPage"
				)
			);
		}

		public function drawAdminPage()
		{
?>
			<div>
				<h2>RumbleTalk Chat Options</h2>
				<form method="post" action="options.php">
					<input type="hidden" name="action" value="update"/>
					<input type="hidden" name="page_options" value="rumbletalk_chat_code,rumbletalk_chat_width,rumbletalk_chat_height"/>
					<? wp_nonce_field( "update-options" ); ?>
					<table>
						<tr>
							<td>Chatroom code:</td>
							<td><input type="text" name="rumbletalk_chat_code" id="rumbletalk_chat_code" value="<?= htmlspecialchars( get_option( "rumbletalk_chat_code" ) ); ?>" maxlength="8"/></td>
						</tr>
						<tr>
							<td></td>
							<td>
								This is the 8 letters/signs chat room code you've received from RumbleTalk.<br/>
								If you do not have a chat room code, please register at <a href="http://www.rumbletalk.com/" target="_blank">RumbleTalk.com</a>, it's super fast and free.
							</td>
						</tr>
						<tr>
							<td>Chatroom width:</td>
							<td><input type="text" name="rumbletalk_chat_width" id="rumbletalk_chat_width" value="<?= htmlspecialchars( get_option( "rumbletalk_chat_width" ) ); ?>" maxlength="4"/></td>
						</tr>
						<tr>
							<td></td>
							<td>
								The width in pixels you wish the chat widget to be.<br/>
								You can use percentages (e.g. 40%) or leave blank.
							</td>
						</tr>
						<tr>
							<td>Chatroom height:</td>
							<td><input type="text" name="rumbletalk_chat_height" id="rumbletalk_chat_height" value="<?= htmlspecialchars( get_option( "rumbletalk_chat_height" ) ); ?>" maxlength="4"/></td>
						</tr>
						<tr>
							<td></td>
							<td>
								The height in pixels you wish the chat widget to be.<br/>
								You can use percentages (e.g. 40%) or leave blank.
							</td>
						</tr>
						<tr>
							<td colspan="2"><input type="submit" value="<? _e( "Save Changes" ) ?>"/></td>
						</tr>
					</table>
				</form>
			</div>
<?
		}

		public function embed( $content )
		{
			$code = get_option( "rumbletalk_chat_code" );

			if ( empty( $code ) )
			{
				return;
			}

			$width  = get_option( "rumbletalk_chat_width"  );
			$height = get_option( "rumbletalk_chat_height" );
			$isw    = ( preg_match( "/^\d{1,4}%?$/", $width ) == 1 );
			$ish    = ( preg_match( "/^\d{1,4}%?$/", $height ) == 1 );
			$str    = "";

			if ( $isw || $ish )
			{
				$str = "<div style=\"" . ( $isw ? "width: {$width}px;" : "" ) . ( $ish ? "height: {$height}px;" : "" ) . "\">";
			}

			$str .= "<script type=\"text/javascript\" src=\"http://www.rumbletalk.com/client/?$code\"></script>";

			if ( $isw || $ish )
			{
				$str .= "</div>";
			}

			return preg_replace( "/\[rumbletalk-chat\]/i", $str, $content );
		}

		public function install()
		{
			foreach ( $this->options as $opt )
			{
				add_option( $opt );
			}
		}

		public function unInstall()
		{
			foreach ( $this->options as $opt )
			{
				delete_option( $opt );
			}
		}
	}

	new RumbleTalkChat();
?>