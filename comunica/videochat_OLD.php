<?php
/**
 * VIDEOCHAT.
 * 
 * @package		videochat
 * @author		Stefano Penge <steve@lynxlab.com>
 * @author		Maurizio "Graffio" Mazzoneschi <graffio@lynxlab.com>
 * @author		Vito Modena <vito@lynxlab.com>
 * @copyright	Copyright (c) 2009, Lynx s.r.l.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU Public License v.2
 * @link		view			
 * @version		0.1
 */

/**
 * Base config file 
 */
require_once realpath(dirname(__FILE__)).'/../config_path.inc.php';

/**
 * Specific Openmeetings config file 
 */
require_once 'include/videochat_config.inc.php';

/**
 * Clear node and layout variable in $_SESSION
 */


$variableToClearAR = array();
array_push($variableToClearAR, 'layout');
array_push($variableToClearAR, 'user');
array_push($variableToClearAR, 'course');
array_push($variableToClearAR, 'course_instance');

/**
 * Users (types) allowed to access this module.
 */
$allowedUsersAr = array(AMA_TYPE_STUDENT, AMA_TYPE_TUTOR);

/**
 * Performs basic controls before entering this module
 */
$neededObjAr = array(
  AMA_TYPE_STUDENT         => array('layout','tutor','course','course_instance', 'videoroom'),
  AMA_TYPE_TUTOR => array('layout','tutor','course','course_instance','videoroom')
);



/**
 * Performs basic controls before entering this module
 */
require_once ROOT_DIR.'/include/module_init.inc.php';
$self = whoami();

include_once 'include/comunica_functions.inc.php';

/* 
 * Redirect to correct home if comunication not enabled
 if (!$com_enabled){
  $homepage = $userObj->getHomepage();
  $msg =   translateFN("Utente non autorizzato");
  header("Location: $homepage?err_msg=$msg");
  exit;
 }
 * FINE Redirect to correct home if comunication not enabled
 */

/**
* VERSIONE CHE ALIMENTA UN IFRAME!!!
* 
if (!isset($_SESSION['sess_id_user'])) {
       $_SESSION['sess_backurl'] = $_SERVER['REQUEST_URI'];
       header("Location: $http_root_dir"); // to login page
       exit();
}
*/

/*
$host = OPENMEETINGS_HOST;
$port = OPENMEETINGS_PORT;
$dir = OPENMEETINGS_DIR;
$roomid = $_REQUEST['room_id'];
$sid = $_REQUEST['sid'];
$language = ROOM_DEFAULT_LANGUAGE;
$width = FRAME_WIDTH;
$height = FRAME_HEIGHT;

$iframe = "
<iframe src='show_videochat.php?room_id=".$videoroomObj->id_room."&sid=".$videoroomObj->session_id.
	"&host=".$host."&port=$port&language=$language&dir=$dir"."' width='$width' height = '$height'"; // width='%s' height='%s' />;
* FINE ALIMENTAZIONE IFRAME
*/

$content = "<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0\" width=\"100%\" height=\"600\">
                        <param name=movie value=\"$videoroomObj->link_to_room\">
                        <param name=quality value=high>
                        <embed src=\"$videoroomObj->link_to_room\" quality=high pluginspage=\"http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash\" type=\"application/x-shockwave-flash\" width=\"100%\" height=\"600\">
                        </embed>
                        </object>";
$menu_01 = "<a href=\"close_videochat.php?id_room=".$videoroomObj->id_room ."&event_token=$event_token\">" . translateFN("Chiudi") . "</a>";
$content_dataAr = array (
	'data'      => $content,
	'menu_01'	=> $menu_01
);


ARE::render($layout_dataAr,$content_dataAr,NULL,$options_Ar);

?>