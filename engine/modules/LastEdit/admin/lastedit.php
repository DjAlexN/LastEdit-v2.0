<?PHP
/***********************************************************
* Translate: 	 NOVAK Studio
* Version: 		 1.0
* Version DLE: 	 14.0 +
* Version PHP:	 7.0 +
* Dev team: 	 NOVAK Studio
* Name Script:	 Moduł LastEdit by NOVAK Studio
***********************************************************/
eval(base64_decode(""));

if( !defined( 'DATALIFEENGINE' ) OR !defined( 'LOGGED_IN' ) ) {
	die( "Hacking attempt!" );
}
if( $member_id['user_group'] != 1 ) {
	msg( "error", $lang['index_denied'], $lang['index_denied'] );
}
 
require_once (ENGINE_DIR . '/modules/LastEdit/data/config.php');
require_once (ENGINE_DIR . '/modules/LastEdit/data/lastedit.lng');



if( $action == "save" ) {

	if( $_REQUEST['user_hash'] == "" OR $_REQUEST['user_hash'] != $dle_login_hash ) {
		
		die( "Hacking attempt! User not found" );
	
	}

	if( $member_id['user_group'] != 1 ) {
		msg( "error", $lang['opt_denied'], $lang['opt_denied'] );
	}

	$db->query( "INSERT INTO " . USERPREFIX . "_admin_logs (name, date, ip, action, extras) values ('".$db->safesql($member_id['name'])."', '{$_TIME}', '{$_IP}', '48', '')" );
	
	$save_con = $_POST['save_con'];	
//	$save_con['chat_status'] = intval($save_con['chat_status']);


	$find = array();
	$replace = array();
	
	$find[] = "'\r'";
	$replace[] = "";
	$find[] = "'\n'";
	$replace[] = "";

	if( $auto_detect_config ) $config['http_home_url'] = "";
	
	$save_con = $save_con + $lastedit_config;

	$handler = fopen( ENGINE_DIR . '/modules/LastEdit/data/config.php', "w" );
	
	fwrite( $handler, "<?PHP \n\n//Konfiguracja Modułu lastedit\n\n\$lastedit_config = array (\n\n" );
	foreach ( $save_con as $name => $value ) {
		
		
		$value = preg_replace( $find, $replace, $value );
		$value = str_replace( "$", "&#036;", $value );
		$value = str_replace( "{", "&#123;", $value );
		$value = str_replace( "}", "&#125;", $value );
		$value = str_replace( chr(0), "", $value );
		$value = str_replace( chr(92), "", $value );
		$value = str_ireplace( "decode", "dec&#111;de", $value );
		
		$name = preg_replace( $find, $replace, $name );
		$name = str_replace( "$", "&#036;", $name );
		$name = str_replace( "{", "&#123;", $name );
		$name = str_replace( "}", "&#125;", $name );
		$name = str_replace( chr(0), "", $name );
		$name = str_replace( chr(92), "", $name );
		$name = str_replace( '(', "", $name );
		$name = str_replace( ')', "", $name );
		$name = str_ireplace( "decode", "dec&#111;de", $name );
		
		fwrite( $handler, "'{$name}' => '{$value}',\n\n" );
	
	}
	fwrite( $handler, ");\n\n?>" );
	fclose( $handler );
	
	clear_cache();
	msg( "success", $lang['opt_sysok'], $lang['opt_sysok_1'], "$PHP_SELF?mod=lastedit" );


// Koniec testowania modułu 	
}elseif( $action == "updates" ) {
	if( $_REQUEST['user_hash'] == "" OR $_REQUEST['user_hash'] != $dle_login_hash ) {
		
		die( "Hacking attempt! User not found" );
	
	}
	clear_cache();
	msg( "error", "UWAGA!", "<h3 style=\"color:red\"><b>Ta adaptacja nie ma zadnych aktualizacji!</b></h3> <br> Wszelkie pytania mozna zadac <a href=\"https://novak-studio.pl/forum\" target=\"_blank\">Tutaj</a> lub <a href=\"mailto:djalexn.graphic@gmail.com?subject=Pomoc przy orderdesc {$order_config['version']}\">Tutaj</a>", "$PHP_SELF?mod=orderdesc" );


// Koniec testowania modułu 	
}
$count = $row['count'];

	echoheader( "<i class=\"fa fa-users position-left\"></i><span class=\"text-semibold\">Moduł lastedit 2.0 by NOVAK Studio</span>", "Ustawienia Modułu lastedit" );

// ********************************************************************************
// Ustawienia Skryptu
// ********************************************************************************

	if( $member_id['user_group'] != 1 ) {
		msg( "error", $lang['opt_denied'], $lang['opt_denied'] );
	}
	
	function showRows($title = "", $description = "", $field = "", $class = "") {				
		echo "<tr>
        <td class=\"col-xs-6 col-sm-6 col-md-12\"><h6 class=\"media-heading text-semibold\">{$title}</h6><span class=\"text-muted text-size-small hidden-xs\">{$description}</span></td>
        </tr>";
	}	
	function showRow($title = "", $description = "", $field = "", $class = "") {				
		echo "<tr>
        <td class=\"col-xs-6 col-sm-6 col-md-7\"><h6 class=\"media-heading text-semibold\">{$title}</h6><span class=\"text-muted text-size-small hidden-xs\">{$description}</span></td>
        <td class=\"col-xs-6 col-sm-6 col-md-5\">{$field}</td>
        </tr>";
	}
	
	function makeDropDown($options, $name, $selected) {
		$output = "<select class=\"uniform\" name=\"$name\">\r\n";
		foreach ( $options as $value => $description ) {
			$output .= "<option value=\"$value\"";
			if( $selected == $value ) {
				$output .= " selected ";
			}
			$output .= ">$description</option>\n";
		}
		$output .= "</select>";
		return $output;
	}


$opt_category = CategoryNewsSelection( explode( ',', $top100_config['category'] ), 0, FALSE );
	if( ! $top100_config['category'] ) $all_cats = "selected";
	else $all_cats = "";

if( $config['allow_multi_category'] ) $category_multiple = "class=\"categoryselect\" multiple";
	else $category_multiple = "class=\"categoryselect\"";

	
	function makeCheckBox($name, $selected) {

		$selected = $selected ? "checked" : "";
	
		return "<input class=\"switch\" type=\"checkbox\" name=\"{$name}\" value=\"1\" {$selected}>";

	}
	echo <<<HTML
<script>
<!--
        function ChangeOption(obj, selectedOption) {
		
				$("#navbar-filter li").removeClass('active');
				$(obj).parent().addClass('active');
                document.getElementById('info').style.display = "none";
                document.getElementById('config').style.display = "none";
                document.getElementById('licence').style.display = "none";
                document.getElementById(selectedOption).style.display = "";
				
				return false;

       }

	
//-->
</script>



<!-- Toolbar -->
<div class="navbar navbar-default navbar-component navbar-xs systemsettings">
	<ul class="nav navbar-nav visible-xs-block">
		<li class="full-width text-center"><a data-toggle="collapse" data-target="#navbar-filter"><i class="fa fa-bars"></i></a></li>
	</ul>
	<div class="navbar-collapse collapse" id="navbar-filter">
		<ul class="nav navbar-nav" style="width: 100%;">

			<li style="width: 33%; text-align:center;" class="active"><a onclick="ChangeOption(this, 'info');" class="tip" ><img style='max-height: 38px' src='/engine/skins/images/lastedit/icon_info.png' border="0"><br>{$langs['info']}</a></li>
			<li style="width: 33%; text-align:center;"><a onclick="ChangeOption(this,'config');" class="tip" ><img style='max-height: 38px;' src='/engine/skins/images/lastedit/icon_settings.png' border="0"><br>{$langs['config']}</a></li>
			<li style="width: 34%; text-align:center;"><a onclick="ChangeOption(this,'licence');" class="tip" ><img style='max-height: 38px;' src='/engine/skins/images/lastedit/licence.png' border="0"><br>{$langs['licence_top']}</a></li>
		</ul>
	</div>
</div>
<!-- /toolbar -->
HTML;
	
	echo <<<HTML
<div id="info" class="panel panel-flat">
  <div class="table-responsive">
  <table class="table table-striped">
    <tr>
        <td class="col-md-3 white-line">{$langs['licence_top']}</td>
        <td class="col-md-9 white-line"><span style='color:green'><b>Licencja Aktywna - Darmowa</b></span></td>
    </tr>
    <tr>
        <td>{$langs['auth']}</td>
        <td>{$langs['auth_name']}</td>
    </tr>
    <tr>
        <td>{$langs['feedback']}</td>
        <td>{$langs['feedback_1']}</td>
    </tr>
	<tr>
        <td>{$langs['info']}</td>
        <td>{$langs['inf']}</td>
    </tr>
    <tr>
        <td>{$langs['link']}</td>
        <td>{$langs['linki']}</td>
    </tr>
	
	</table></div>
	<div class="panel-footer">

HTML;
		echo <<<HTML
<form action="$PHP_SELF?mod=lastedit&action=updates" method="post" class="systemsettings">
<div style="display:flex;">
 <input type="hidden" name="user_hash" value="{$dle_login_hash}" />
<button type="updates" class="btn bg-slate-600 btn-sm btn-raised position-left"><i class="fa fa-exclamation-circle position-left"></i>{$langs['updates']}</button>
</div>
</form>
HTML;
		echo "</div></div>";

	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

eval (base64_decode(""));
	// Początek Licencji



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
	echo <<<HTML
<form action="$PHP_SELF?mod=lastedit&action=save" method="post" class="systemsettings">
<div id="config" style='display:none'>
<div class="panel panel-flat" >
  <div class="table-responsive">
  <table class="table table-striped">
        <tr>
        <td class="white-line" style="width:58%"><h6>Dozwolone Kategorie</h6><span class="note large">Dozwolone Kategorie w lastedit</span></td>
        <td class="white-line" style="width:42%"><select data-placeholder="{$lang['addnews_cat_sel']}" name="category[]" style="width:100%; max-width:350px;" class="cat_select" multiple >
<option value="0" {$all_cats}>{$lang['edit_all']}</option>
{$opt_category}
</select></td>
    </tr>
HTML;
	showRow( $langs['top_num'], $langs['top_num_def'], "<input type=text class=\"form-control\" style=\"text-align: center;\" name=\"save_con[news_limit]\" value=\"{$lastedit_config['news_limit']}\" size=20>", "white-line" );
	showRow( $langs['top_tem_view'], $langs['top_tem_view1'], "<input type=text class=\"form-control\" style=\"text-align: center;\" name=\"save_con[title_last]\" value=\"{$lastedit_config['title_last']}\" size=40>" );
	showRow( $langs['top_tem_nr'], $langs['top_tem_nr1'], "<input type=text class=\"form-control\" style=\"text-align: center;\" name=\"save_con[title_num]\" value=\"{$lastedit_config['title_num']}\" size=20>" );
	showRow( $langs['top_kol_art'], $langs['top_kol_art1'], "<input type=text class=\"form-control\" style=\"text-align: center;\" name=\"save_con[title_name]\" value=\"{$lastedit_config['title_name']}\" size=40>" );

		echo "</table></div></div>";
		echo <<<HTML
<div style="float:left;">
 <input type="hidden" name="user_hash" value="{$dle_login_hash}" />
<button type="submit" class="btn bg-teal btn-sm btn-raised position-left"><i class="fa fa-floppy-o position-left"></i>{$lang['user_save']}</button></div><br><br>

</form>
HTML;
		echo "</div>";

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		
// Koniec Licencji

		
		eval(base64_decode(""));
// Licencja Początek	
	echo <<<HTML
<div id="licence"  style='display:none'>
<div class="panel panel-flat">
  <div class="table-responsive">
  <table class="table table-striped">
HTML;

	showRows($langs['licence_rules'], $langs['licence_rules1']);
	
echo <<<HTML
</table></div></div></div>
HTML;

	
//Licencja Koniec


	if(!is_writable(ENGINE_DIR . '/modules/LastEdit/data/config.php')) {
		echo "<div class=\"alert alert-warning alert-styled-left alert-arrow-left alert-component\">".str_replace("{file}", "/modules/LastEdit/data/config.php", $lang['stat_system'])."</div>";
	}
	
	echofooter();


?>