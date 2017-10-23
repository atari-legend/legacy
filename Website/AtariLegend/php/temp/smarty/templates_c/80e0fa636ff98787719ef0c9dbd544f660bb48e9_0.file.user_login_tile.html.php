<?php
/* Smarty version 3.1.29, created on 2017-01-21 14:26:46
  from "/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/main/user_login_tile.html" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58836fa6d91392_12797538',
  'file_dependency' => 
  array (
    '80e0fa636ff98787719ef0c9dbd544f660bb48e9' => 
    array (
      0 => '/opt/lampp/htdocs/AtariLegend/Website/AtariLegend/themes/templates/1/main/user_login_tile.html',
      1 => 1484337716,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58836fa6d91392_12797538 ($_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, false);
?>

	<?php 
$_smarty_tpl->ext->_inheritance->processBlock($_smarty_tpl, 0, 'user_login_tile', array (
  0 => 'block_186339845058836fa6d8c578_76408225',
  1 => false,
  3 => 0,
  2 => 0,
));
?>
	

             
        
<?php }
/* {block 'user_login_tile'}  file:1/main/user_login_tile.html */
function block_186339845058836fa6d8c578_76408225($_smarty_tpl, $_blockParentStack) {
?>

	<?php if (!isset($_smarty_tpl->tpl_vars['user_session']->value['userid'])) {?>
		<div class="logon">
			<div class="standard_tile">
			<form action="../tiles/user_process_login.php" method="post" name="login_form">
				<h1>LOG ON</h1>
				<div class="standard_tile_line"></div>
				<div class="logon_input_usn">
					<div class="logon_left">
						<div class="logon_username_icon"></div>
					</div>
					<div class="logon_right">
						<input class="standard_tile_input" type="text" name="userid" maxlength="30">
					</div>
				</div>
				<div class="logon_input_pwd">
					<div class="logon_left">
						<div class="logon_password_icon"></div>
					</div>
					<div class="logon_right">
						<input class="standard_tile_input" type="password" name="password" maxlength="30">
					</div>
				</div> 
				<div class="logon_signin">
				<button type="button" value="Login" class="signinbutton" onclick="formhash(this.form, this.form.password);">
					SIGN IN
				</button>
				</div>
				<br>
				<br>			
				<h3><a href="#" class="standard_tile_link">Forgot user name or password?</a></h3>
				<br>
				<div class="logon_socmed">
					<div class="logon_facebook_button"></div>
				</div>
				<div class="logon_socmed">
					<div class="logon_twitter_button"></div>
				</div>
				<br>
				<br>
			</form>
			</div>
		</div>
	<?php } else { ?>
		<div class="logon">
			<div class="standard_tile">
				<h1>Welcome <?php echo $_smarty_tpl->tpl_vars['user_session']->value['userid'];?>
</h1>
				<div class="standard_tile_line"></div>
				<div class="logon_input_usn">
					<div class="logon_left">
						<div class="logon_username_icon"></div>
					</div>
					<div class="logon_right">
						<input class="standard_tile_input" type="text" name="userid" maxlength="30">
					</div>
				</div>
				<div class="logon_input_pwd">
					<div class="logon_left">
						<div class="logon_password_icon"></div>
					</div>
					<div class="logon_right">
						<input class="standard_tile_input" type="password" name="password" maxlength="30">
					</div>
				</div> 
				<div class="logon_signin">
				<button type="button" value="Login" class="signinbutton">
					<a href="../includes/user_logout.php" class="standard_tile_link_button">LOG OUT</a>
				</button>
				</div>
				<br>
				
				<?php if ($_smarty_tpl->tpl_vars['user_session']->value['permission'] == 1) {?>
				<h3><a href="../../admin/" class="standard_tile_link">Go to Cpanel</a></h3>
				<br>	
				<?php }?>
				<h3><a href="#" class="standard_tile_link">Forgot user name or password?</a></h3>
				<br>
				<br>
				<h3><span class="statistics_dark">Your last visit was on Saturday, September 6, 666. Stay Atari!</span></h3>
				<h3><span class="statistics_dark">Some more lines of text have been placed here temporary so the layout is not screwed up</span></h3>
				<h3><span class="statistics_dark">Some more lines of text have been placed here temporary so the layout is not screwed up</span></h3>
				<br>
				<br>
			</div>
		</div>
	<?php }
}
/* {/block 'user_login_tile'} */
}
