<?php
/*
Plugin Name: RumbleTalk Chat
Plugin URI: http://www.rumbletalk.com/3rdsupport.php
Description: Add a <strong>Boutique Chatroom Widget</strong> to your blog or site in under a minute
Version: 1.3.1
Author: Yanir Shahak
Author URI: http://www.rumbletalk.com/contact_us.php
License: GPL2

Copyright 2013 Yanir Shahak (email : yanir@rumbletalk.com)

This program is free trial software; you can redistribute it and/or modify
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
				add_shortcode( 'rumbletalk-chat', array( &$this, "embed" ) );
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
	 <div style="width:820px;">

			<h2>RumbleTalk Chat Options</h2>

	   <table>
		 <tr>
		   <td width="500" valign="top">

			   <div style="width:500px;">
				<form method="post" action="options.php">
					<input type="hidden" name="action" value="update"/>
					<input type="hidden" name="page_options" value="rumbletalk_chat_code,rumbletalk_chat_width,rumbletalk_chat_height"/>
					<? wp_nonce_field( "update-options" ); ?>
					<table valign="top">
						<tr>
							<td colspan="2" align="left"  style="padding-bottom:30px;"><img width="490" src="http://d1pfint8izqszg.cloudfront.net/emails/Mailxa-01.png" /></td>
						</tr>
						<tr>
							<td width="120"><b>Chatroom code:</b></td>
							<td><input type="text" name="rumbletalk_chat_code" id="rumbletalk_chat_code" value="<?= htmlspecialchars( get_option( "rumbletalk_chat_code" ) ); ?>" maxlength="8"/></td>
						</tr>
						<tr>
							<td></td>
							<td>
							    <span style="font:arial 8px none; color:#AAACAD">
  								  This is the 8 letters/signs chat room code you've received from RumbleTalk (after registration you see it in the <a href="http://d1pfint8izqszg.cloudfront.net/images/Instructions-getChat.png" target="_blank"> chat code </a>section in addition to an email send with the code).<br/><br/>
								</span>
							</td>
						</tr>
						<tr>
							<td width="120"   style="padding-top:30px;">Chatroom width:</td>
							<td   style="padding-top:30px;"><input type="text" name="rumbletalk_chat_width" id="rumbletalk_chat_width" value="<?= htmlspecialchars( get_option( "rumbletalk_chat_width" ) ); ?>" maxlength="4"/></td>
						</tr>
						<tr>
							<td></td>
							<td>
							  <span style="font:arial 8px none; color:#AAACAD">
								The width in pixels you wish the chat widget to be.<br/>
								You can use percentages (e.g. 40%) or leave blank.
							  </span>
							</td>
						</tr>
						<tr>
							<td width="120">Chatroom height:</td>
							<td><input type="text" name="rumbletalk_chat_height" id="rumbletalk_chat_height" value="<?= htmlspecialchars( get_option( "rumbletalk_chat_height" ) ); ?>" maxlength="4"/></td>
						</tr>
						<tr>
							<td></td>
							<td>
							    <span style="font:arial 8px none; color:#AAACAD">
								The height in pixels you wish the chat widget to be.<br/>
								You can use percentages (e.g. 40%) or leave blank.
								</span>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="padding-top:20px;"><input type="submit" value="<? _e( "Save Changes" ) ?>"/></td>
						</tr>
						<tr>
							<td colspan="2" style="padding-top:20px;"><span style="font:arial 8px none; color:green">&#42; In some wordpress themes 2 known issues might occur, please <br/>see below the way to fix it.</span></td>
						</tr>
						<tr>
							<td colspan="2" align="left"  style="padding-top:30px;"><img width="490" src="http://d1pfint8izqszg.cloudfront.net/emails/Mailxa-04.png" /></td>
						</tr>
					</table>
				</form>
			</div>

		</td>
		<td  valign="top">

			<div style="float:right; width:290px; border:1px #DEDEDD dashed; background-color:#FEFAE7; padding:10px 10px 10px 10px">
				<b>Description:</b> The <a href="http://www.rumbletalk.com/?utm_source=wordpress&utm_medium=plugin&utm_campaign=fromplugin" target="_blank">RumbleTalk</a> Plugin is a boutique chat room Platform for websites, facebook pages and real-time events. It is available for all Wordpress installed versions.<br />
				<br />
				<b>Like the plugin? "Like" RumbleTalk Chat!</b>
				 <div id="fb-root"></div>
				 <script>(function(d, s, id) {
				   var js, fjs = d.getElementsByTagName(s)[0];
				   if (d.getElementById(id)) return;
				   js = d.createElement(s); js.id = id;
				   js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=181184391902159";
				   fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));</script>
					<div class="fb-like" data-href="https://www.facebook.com/rumbletalk" data-send="true" data-width="280" data-show-faces="true" data-font="arial"></div>

				<br />
				<br />
				<b>How to add your chatroom in 60 seconds:</b>
				  <table>
				    <tr>
				      <td align="left" valign="top" width="20">
				         <img  width="32px" src="http://d1pfint8izqszg.cloudfront.net/admin/images/SQ-about.png" />
				      </td>
				      <td style="padding-left:5px;">
				         Get your chatroom code from RumbleTalk website. Add it to your plugin (here on the left) and save.
				      </td>
				    </tr>
				    <tr>
				      <td style="padding-top:5px;" align="left" valign="top" width="20">
				         <img width="32px" src="http://d1pfint8izqszg.cloudfront.net/admin/images/SQ-contact.png" />
				      </td>
				      <td style="padding-left:5px;">
				         Now add the text <b style="font:arial 8px none; color:#68A500">&#91;rumbletalk-chat&#93; </b>to your visual editor where you want your chat to show.....Your done.
				      </td>
				    </tr>
				    <tr>
				      <td style="padding-top:5px;" align="left" valign="top" width="20">
				         <img width="32px" src="http://d1pfint8izqszg.cloudfront.net/admin/images/SQ-features.png" />
				      </td>
				      <td style="padding-left:5px;">
				         You can always change the look and feel, change settings or set advanced options latter on.
				      </td>
				    </tr>
				  </table>

				<br />
				<b>Homepage:</b> <a href="http://www.rumbletalk.com/?utm_source=wordpress&utm_medium=plugin&utm_campaign=fromplugin" target="_blank">RumbleTalk Home</a><br />
				<Br />
				<b>Facebook:</b> <a href="https://www.facebook.com/rumbletalk" target="_blank">Facebook Fan Page</a><br />

				<br/>
			    <a href="http://www.rumbletalk.com/premium.php?utm_source=wordpress&utm_medium=wordpress&utm_campaign=plugin" style="text-decoration:none">
				<strong><span style="color: #000;"> <u>Upgrade your Plan!</u> </span></strong></a>


			</div>

		</td>
	   </tr>
	 </table>




	   <table>
		 <tr>
		   <td width="500" valign="top">

			<div style="width:500px;">
				  <table>
				    <tr>
				      <td align="left" valign="top" width="20">
				         <img  width="32px" src="http://d1pfint8izqszg.cloudfront.net/admin/images/SQ-faq.png" />
				      </td>
				      <td style="padding-left:5px;">
				        <span style="font:arial; font-size:14px;color:#73AC00">Troubleshooting</span> <br/>
				      </td>
				    </tr>
				    <tr>
				      <td colspan="2" style="padding-left:5px;padding-top:10px;">

							RumbleTalk chat is elastic chat. In some themes we see 2 possible issues.<br/>
							1 - The height cannot be changed.<br/>
							2 - Some elements in the page are missing.<br/><br/>

							The solution in that case is not using the plugin but add the chatroom code below directy into the html of the page.<br/><br/>
					        <span style="font:arial 8px none; color:green">&#42; Copy and paste the code below into your html, make sure you replaced the <b>chatcode</b> with your own chatroom code.</span><br/><br/>

						<div>
							<code>
							  &lt;div style="width: 550px; height: 370px;"&gt;<br/>
							  &lt;script language="JavaScript" type="text/javascript" src="http://www.rumbletalk.com/client/?<b>chatcode</b>"&gt;&lt;/script&gt;<br/>
							  &lt;/div&gt;
							</code>
						</div>
				      </td>
				    </tr>
				  </table>
			</div>
			<div style="width:500px;">
				  <table style="padding-top:20px;">
				    <tr>
				      <td align="left" valign="top" width="20">
				         <img  width="32px" src="http://d1pfint8izqszg.cloudfront.net/admin/images/SQ-faq.png" />
				      </td>
				      <td style="padding-left:5px;">
				        <span style="font:arial; font-size:14px;color:#73AC00">Floating Image</span> <br/>
				      </td>
				    </tr>
				    <tr>
				      <td colspan="2" style="padding-left:5px;padding-top:10px;">

							If you wish to add to your webpage a <a href="http://www.rumbletalk.com/?utm_source=wordpress&utm_medium=plugin&utm_campaign=fromplugin" target="_blank">floating chat</a> which is a toolbar
							like chat <br/>on your right bottom corner.
                            <br/>
							<img src="http://d1pfint8izqszg.cloudfront.net/images/toolbar/toolbar.png" />
							<br/>
							Please use the code below instead of using the plugin.<br/><br/>

						<div>
							<code>
							  &lt;div style="width: 550px; height: 370px;"&gt;<br/>
							  &lt;script language="JavaScript" type="text/javascript" src="http://www.rumbletalk.com/client/?<b>chatcode</b>&1"&gt;&lt;/script&gt;<br/>
							  &lt;/div&gt;
							</code>
						</div>
				      </td>
				    </tr>
				  </table>
			</div>

		</td>
		<td  valign="top">

			<div style="float:right; width:290px; border:1px #DEDEDD dashed; background-color:#FEFAE7; padding:10px 10px 10px 10px">
				 With RumbleTalk you may create your own chat theme, share images and videos, talk from your mobile and even add the same chat to your facebook page.
				<br />
				<br />
				 <a  target="_blank" href="https://fbcdn-sphotos-c-a.akamaihd.net/hphotos-ak-prn1/555083_529814737068782_1413799779_n.png">
				   <img width="100" src="https://fbcdn-sphotos-c-a.akamaihd.net/hphotos-ak-prn1/555083_529814737068782_1413799779_n.png" />
				 </a>
				 <a  target="_blank" href="https://fbcdn-sphotos-a-a.akamaihd.net/hphotos-ak-ash3/554878_529815873735335_800794496_n.png">
				   <img width="100" src="https://fbcdn-sphotos-a-a.akamaihd.net/hphotos-ak-ash3/554878_529815873735335_800794496_n.png" />
				 </a>
				<br />
				 <a  target="_blank" href="https://fbcdn-sphotos-c-a.akamaihd.net/hphotos-ak-ash3/564947_465273650189558_696427239_n.jpg">
				   <img width="100" src="https://fbcdn-sphotos-c-a.akamaihd.net/hphotos-ak-ash3/564947_465273650189558_696427239_n.jpg" />
				 </a>
				 <a  target="_blank" href="http://d1pfint8izqszg.cloudfront.net/images/donotuseyet.png">
				   <img width="100" src="http://d1pfint8izqszg.cloudfront.net/images/donotuseyet.png" />
				 </a>
				<br />
				 <a  target="_blank" href="http://d1pfint8izqszg.cloudfront.net/images/blog/DeleteMessages.png">
				   <img width="100" src="http://d1pfint8izqszg.cloudfront.net/images/blog/DeleteMessages.png" />
				 </a>
				 <a  target="_blank" href="http://d1pfint8izqszg.cloudfront.net/images/blog/DeleteAllMessages2.png">
				   <img width="100" src="http://d1pfint8izqszg.cloudfront.net/images/blog/DeleteAllMessages2.png" />
				 </a>
				<br />
				 <a  target="_blank" href="https://fbcdn-sphotos-g-a.akamaihd.net/hphotos-ak-ash4/422387_340738479309743_255273953_n.jpg">
				   <img width="100" src="https://fbcdn-sphotos-g-a.akamaihd.net/hphotos-ak-ash4/422387_340738479309743_255273953_n.jpg" />
				 </a>
				<br />
				<br />
				<b>Thanks:</b> Thanks for using RumbleTalk plugin. If you have any issues, suggestions or praises send us an email to support@rumbletalk.com
			</div>

		</td>
	   </tr>
	 </table>



   </div>
<?
		}

		public function embed( $attr )
		{
			$code = get_option( 'rumbletalk_chat_code' );

			if ( empty( $code ) )
			{
				return '';
			}

			$width  = get_option( 'rumbletalk_chat_width'  );
			$height = get_option( 'rumbletalk_chat_height' );
			$isw    = ( preg_match( '/^\d{1,4}%?$/', $width ) == 1 );
			$ish    = ( preg_match( '/^\d{1,4}%?$/', $height ) == 1 );
			$str    = '';

			if ( $isw || $ish )
			{
				$str = '<div style="' . ( $isw ? "width: {$width}px;" : '' ) . ( $ish ? "height: {$height}px;" : '' ) . '">';
			}

			$str .= "<script type=\"text/javascript\" src=\"http://www.rumbletalk.com/client/?$code\"></script>";

			if ( $isw || $ish )
			{
				$str .= '</div>';
			}

			return $str;
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