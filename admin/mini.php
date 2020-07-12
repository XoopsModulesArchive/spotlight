<?php
/*
* Mini Spotlights
* Presented by Brandycoke Productions  <http://www.brandycoke.com/>
* Programmed exclusively for GuitarGearHeads <http://www.guitargearheads.com>
* Licensed under the terms of GNU General Public License
* http://www.gnu.org/copyleft/gpl.html
*
* XOOPS - PHP Content Management System
* Copyright (c) 2000 XOOPS.org <http://www.xoops.org/>
*/
$op = isset($_GET['op']) ? trim($_GET['op']) : '';
$op = isset($_POST['op']) ? trim($_POST['op']) : $op;
$max = 6;

include 'admin_header.php';
$minis_handler =& xoops_getmodulehandler('mini');

switch($op){
default:
	include_once XOOPS_ROOT_PATH . "/class/xoopstree.php";
	include_once XOOPS_ROOT_PATH.'/modules/news/class/class.newsstory.php';
	include_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
	#$news = new XoopsTree($xoopsDB->prefix("stories"), "storyid", "0");
	$news = new XoopsTree($xoopsDB->prefix("topics"), "topic_id", "0");
	$imgs =& XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['uploaddir']);
	xoops_cp_header();
	spot_adminmenu(_AM_KUHT_NAME_MINI);
	$form = new XoopsThemeForm(_AM_KUHT_NAME_MINI, 'mini', xoops_getenv('PHP_SELF'));
	for( $i=1; $i<$max; $i++ ){
		if( !$mini =& $minis_handler->get($i) ){
			$mini =& $minis_handler->create();
		}
		ob_start();
		#$news->makeMySelBox("title", "title", $mini->getVar('storyid'), 1, 'story['.$i.']');
		$news->makeMySelBox("topic_title", "topic_title", $mini->getVar('topicid'), 1, 'topic['.$i.']');
		$stories[$i] = new XoopsFormLabel(_AM_SELECT_SPOTLIGHT_TOPIC, ob_get_contents());
		ob_end_clean();
		$align[$i] = new XoopsFormSelect(_AM_SPOT_IMAGEALIGN, 'align['.$i.']', $mini->getVar('mini_align'));
		$align[$i]->addOptionArray(array(0 => _AM_SPOT_LEFT, 1 => _AM_SPOT_RIGHT));
		
		$img = $mini->getVar('mini_img') != '' ? XOOPS_URL.'/'.$xoopsModuleConfig['uploaddir'].'/'.$mini->getVar('mini_img') : XOOPS_UPLOAD_URL.'/blank.gif';
		$tray[$i] = new XoopsFormElementTray(_AM_SELECT_IMG, '<br />');
		$select_img[$i] = new XoopsFormSelect('', 'img['.$i.']', $mini->getVar('mini_img'));
		$select_img[$i]->addOption('', '----');
		$select_img[$i]->addOptionArray($imgs);
		$select_img[$i]->setExtra(
		'onchange="if( this.options[this.selectedIndex].value != \'\' ){ document.mini.img'
		.$i.'.src=\''.XOOPS_URL.'/'.$xoopsModuleConfig['uploaddir'].'/'
		.'\' + this.options[this.selectedIndex].value; }else{ document.mini.img'
		.$i.'.src=\''.XOOPS_UPLOAD_URL.'/blank.gif\'; }"');
		$tray[$i]->addElement($select_img[$i]);
		$tray[$i]->addElement(new XoopsFormLabel('', '<img id="img'.$i.'" src="'.$img.'" alt="'.$mini->getVar('mini_img').'" />'));

		$form->addElement(new XoopsFormLabel('', '<strong>'._AM_KUHT_MINI.$i.'</strong>'));
		$form->addElement(new XoopsFormRadioYN(_AM_KUHT_MINI_SHOW, 'show['.$i.']', $mini->getVar('mini_show')));
		$form->addElement($stories[$i]);
		$form->addElement($align[$i]);
		$form->addElement($tray[$i]);
		$form->addElement(new XoopsFormDhtmlTextArea(_AM_KUHT_MINI_TEXT, 'text['.$i.']', $mini->getVar('mini_text', 'e')));
	}
	$form->addElement(new XoopsFormHidden('op', 'save'));
	$form->addElement(new XoopsFormButton('', '', _AM_SUBMIT, 'submit'));
	$form->display();
break;
case 'save':
	extract($_POST);
	$errors = array();
	for( $i=1; $i<$max; $i++ ){
		if( !$mini =& $minis_handler->get($i) ){
			$mini =& $minis_handler->create();
		}
		$mini->setVar('mini_show', $show[$i]);
		$mini->setVar('topicid', $topic[$i]);
		$mini->setVar('mini_img', $img[$i]);
		$mini->setVar('mini_text', trim($text[$i]));
		$mini->setVar('mini_align', $align[$i]);
		if( !$inserted = $minis_handler->insert($mini) ){
			$errors[] = $mini->getHtmlErrors();
		}
	}
	if( count($errors) < 1 ){
		redirect_header("index.php", 0, _AM_MESSAGE);
	}else{
		xoops_cp_header();
		foreach( $errors as $e ){
			echo $e;
		}
	}
break;
}

xoops_cp_footer();
?>
