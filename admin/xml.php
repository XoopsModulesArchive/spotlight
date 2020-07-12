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
$xml_id = isset($_GET['xml_id']) ? trim($_GET['xml_id']) : 0;
$xml_id = isset($_POST['xml_id']) ? trim($_POST['xml_id']) : $xml_id;
include 'admin_header.php';
$nt_handler =& xoops_getmodulehandler('xml');
if( !empty($xml_id) ){
	$nt =& $nt_handler->get($xml_id);
	$caption = sprintf(_AM_KUHT_XML_EDIT_ITEM, $xml_id);
}
if( !isset($nt) || !$nt ){
	$nt =& $nt_handler->create();
	$caption = _AM_KUHT_XML_NEW_ITEM;
}

switch($op){
default:
	xoops_cp_header();
	spot_adminmenu(_AM_KUHT_NAME_XML);
	if( $ticks =& $nt_handler->getObjects() ){
		echo '
<form action="xml.php" method="post">	
	<table class="outer" cellspacing="1">
		<tr>
			<th>'._AM_KUHT_XML_ID.'</th>
			<th>'._AM_KUHT_XML_TITLE.' / '._AM_KUHT_XML_URL.'</th>
			<th colspan="2" width="25%">'._AM_KUHT_XML_MANAGE.'</th>
		</tr>
';
		foreach( $ticks as $t ){
			$id = $t->getVar('xml_id');
			echo '<tr>'
				.'<td align="center">'.$id.'</td>'
				.'<td align="left">'
				.'<a href="xml.php?op=edit&amp;xml_id='.$t->getVar('xml_id').'">'
				.$t->getVar('xml_title').'</a><br />'
				.str_replace('{X_SITEURL}', XOOPS_URL.'/', $t->getVar('xml_url'))
				.'</td>'
				.'<td align="center">'
				.'<input type="text" id="order'.$id
				.'" name="order['.$id.']" value="'.$t->getVar('xml_order')
				.'" size="3" maxlength="2" />'
				.'</td>'
				.'<td align="center">'
				.'<input type="checkbox" id="del'.$id
				.'" name="del[]" value="'.$id.'" /> '._DELETE.'</td>'
				."</tr>\n";
		}
		echo '<tr><td class="foot" colspan="4" align="right">'
			.'<input type="submit" id="submit" name="submit" value="'
			._AM_KUHT_XML_MANAGE.'" /></td>
			<input type="hidden" name="op" value="manage" />
			</tr>
	</table>
</form>';
	}
	$form = $nt->editForm($caption);
	$form->display();
break;
case 'edit':
	xoops_cp_header();
	spot_adminmenu(_AM_KUHT_NAME_XML);
	$form = $nt->editForm($caption);
	$form->display();
break;
case 'save':
	extract($_POST);
	$url = trim(str_replace('{X_SITEURL}', XOOPS_URL.'/', $xml_url));
	$nt->setVar('xml_url', trim($xml_url));
	$nt->setVar('xml_title', trim($xml_title));
	$nt->setVar('xml_text', trim($xml_text));
	$nt->setVar('xml_order', intval($xml_order));
	if( !$inserted = $nt_handler->insert($nt) ){
		xoops_cp_header();
		echo $nt->getHtmlErrors();
	}else{
		$nt_handler->genXml();
		redirect_header("xml.php", 0, _AM_MESSAGE);
	}
break;
case 'manage':
	$del = isset($_POST['del']) ? $_POST['del'] : array();
	if( count($del) > 0 ){
		$ids = implode(',', $del);
		$criteria = new Criteria('xml_id', '('.$ids.')', 'IN');
		if( $result = $nt_handler->deleteAll($criteria) ){
			xoops_cp_header();
			echo $result;
		}
	}
	foreach( $_POST['order'] as $k => $v ){
		if( !in_array($k, $del) ){
			$tick =& $nt_handler->get($k);
			if( false != $tick ){
				$tick->setVar('xml_order', $v);
				$nt_handler->insert($tick);
			}
		}
	}
	$nt_handler->genXml();
	redirect_header("xml.php", 0, _AM_MESSAGE);
break;
}

xoops_cp_footer();
?>