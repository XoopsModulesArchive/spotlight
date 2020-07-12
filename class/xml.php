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

class SpotlightXml extends XoopsObject {
	function SpotlightXml(){
		$this->XoopsObject();
	//	key, data_type, value, req, max, opt
		$this->initVar("xml_id", XOBJ_DTYPE_INT);
		$this->initVar("xml_url", XOBJ_DTYPE_TXTBOX, '', false, 255);
		$this->initVar("xml_title", XOBJ_DTYPE_TXTBOX, '', true, 255);
		$this->initVar("xml_text", XOBJ_DTYPE_TXTAREA, '', true);
		$this->initVar("xml_order", XOBJ_DTYPE_INT, 0, false, 2);
	}
	
	function editForm($caption){
		$form = new XoopsThemeForm($caption, 'xml', xoops_getenv('PHP_SELF'));
		$t_url = new XoopsFormText(_AM_KUHT_XML_URL, 'xml_url', 50, 255, $this->getVar('xml_url', 'e'));
		$t_url->setDescription(_AM_KUHT_XML_URL_DESC);
	
		$form->addELement(new XoopsFormText(_AM_KUHT_XML_ORDER, 'xml_order', 3, 2, $this->getVar('xml_order', 'e')));
		$form->addElement($t_url);
		$form->addELement(new XoopsFormText(_AM_KUHT_XML_TITLE, 'xml_title', 50, 255, $this->getVar('xml_title', 'e')), true);
		$form->addElement(new XoopsFormTextArea(_AM_KUHT_XML_TEXT, 'xml_text', $this->getVar('xml_text', 'e'), 10), true);
		$form->addElement(new XoopsFormButton('', '', _AM_SUBMIT, 'submit'));
		$form->addElement(new XoopsFormHidden('op', 'save'));
		if( !$this->isNew() ){
			$form->addElement(new XoopsFormHidden('xml_id', $this->getVar('xml_id')));
		}
		return $form;
	}
}

class SpotlightXmlHandler extends XoopsObjectHandler {
	var $db;
	var $db_table;
	var $obj_class = 'SpotlightXml';
	
	function SpotlightXmlHandler(&$db){
		$this->db =& $db;
		$this->db_table = $this->db->prefix('spotlight_xml');
	}
	
	function &getInstance(&$db){
		static $instance;
		if (!isset($instance)){
			$instance = new SpotlightXmlHandler($db);
		}
		return $instance;
	}

	function &create(){
		$obj = new $this->obj_class();
		$obj->setNew();
		return $obj;
	}
	
	function &get($id, $query='*'){
		$id = intval($id);
		if( $id > 0 ){
			$sql = 'SELECT '.$query.' FROM '.$this->db_table.' WHERE xml_id='.$id;
			if( !$result = $this->db->query($sql) ){
				return false;
			}
			$numrows = $this->db->getRowsNum($result);
			if( $numrows == 1 ){
				$obj = new $this->obj_class();
				$obj->assignVars($this->db->fetchArray($result));
				return $obj;
			}
			return false;
		}
		return false;
	}

    function getCount($criteria = null){
		$sql = 'SELECT COUNT(*) FROM '.$this->db_table;
		if( isset($criteria) && is_subclass_of($criteria, 'criteriaelement') ){
			$sql .= ' '.$criteria->renderWhere();
		}
		if( !$result =& $this->db->query($sql) ){
			return false;
		}
		list($count) = $this->db->fetchRow($result);
		return $count;
	}

	function &getObjects($criteria=null, $id_as_key = false){
		$ret = array();
		$limit = $start = 0;
		$sql = 'SELECT * FROM '.$this->db_table;
		if( isset($criteria) && is_subclass_of($criteria, 'criteriaelement') ){
			$sql .= ' '.$criteria->renderWhere();
			if( $criteria->getSort() != '' ){
				$sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
			}
			$limit = $criteria->getLimit();
			$start = $criteria->getStart();
		}
		if( !preg_match('/ORDER\ BY/', $sql) ){
				$sql .= ' ORDER BY xml_order ASC';
		}
// 		die($sql);exit();
		$result = $this->db->query($sql, $limit, $start);
		if( !$result ){
			return false;
		}
		while( $myrow = $this->db->fetchArray($result) ){
			$obj = new $this->obj_class();
			$obj->assignVars($myrow);
			if( !$id_as_key ){
				$ret[] =& $obj;
			}else{
				$ret[$myrow['xml_id']] =& $obj;
			}
			unset($obj);
		}
		return (count($ret) > 0) ? $ret : false;
	}
	
	function insert(&$obj, $force = false){
        // if( strtolower(get_class($obj)) != strtolower($this->obj_class) ){ et modif thecat
		if (strtolower(get_class($obj)) != strtolower($this->obj_class) {
            return false;
        }
        if( !$obj->isDirty() ){
            return true;
        }
        if( !$obj->cleanVars() ){
            return false;
        }
		foreach( $obj->cleanVars as $k=>$v ){
			${$k} = $v;
		}
		if( count($obj->getErrors()) > 0 ){
            return false;
		}
		if( $obj->isNew() || empty($xml_id) ){
			$xml_id = $this->db->genId($this->db_table."_xml_id_seq");
			$sql = sprintf("INSERT INTO %s (
				xml_id, xml_url, xml_title, xml_text, xml_order
				) VALUES (
				%u, %s, %s, %s, %u
				)",
				$this->db_table,
				$xml_id,
				$this->db->quoteString($xml_url),
				$this->db->quoteString($xml_title),
				$this->db->quoteString($xml_text),
				$xml_order
				);
		}else{
			$sql = sprintf("UPDATE %s SET
				xml_url = %s,
				xml_title = %s,
				xml_text = %s,
				xml_order = %u
				WHERE xml_id = %u",
				$this->db_table,
				$this->db->quoteString($xml_url),
				$this->db->quoteString($xml_title),
				$this->db->quoteString($xml_text),
				$xml_order,
				$xml_id
			);
		}
        if( false != $force ){
            $result = $this->db->queryF($sql);
        }else{
            $result = $this->db->query($sql);
        }
		if( !$result ){
			$obj->setErrors("Could not store data in the database.<br />".$this->db->error().' ('.$this->db->errno().')<br />'.$sql);
			return false;
		}
		if( empty($xml_id) ){
			$xml_id = $this->db->getInsertId();
		}
        $obj->assignVar('xml_id', $xml_id);
		return $xml_id;
	}

    function deleteAll($criteria = null){
		$sql = 'DELETE FROM '.$this->db_table;
		if( isset($criteria) && is_subclass_of($criteria, 'criteriaelement') ){
			$sql .= ' '.$criteria->renderWhere();
		}
		if( !$result = $this->db->query($sql) ){
			return $this->db->error().' ('.$this->db->errno().')<br />'.$sql;
		}
		return false;
	}
	
	function genXml(){
		if( $ticks =& $this->getObjects() ){
			$xml = '';
			$tmpl = "<news>\n\t<header>\n\t\t%s\n\t</header>\n\t<body>\n\t\t%s\n\t</body>\n\t<link>\n\t\t%s\n\t</link>\n</news>\n";
			foreach( $ticks as $t ){
				$xml .= sprintf($tmpl, $t->getVar('xml_title', 'n'),
										$t->getVar('xml_text', 'n'),
										str_replace('{X_SITEURL}', XOOPS_URL.'/', $t->getVar('xml_url', 'n'))
									);
			}
			$filename = XOOPS_CACHE_PATH.'/newsticker.xml';
			if( $file = @fopen($filename, "w") ){
				fwrite($file, $xml);
				fclose($file);
			}
		}
		return $xml;
	}

}
?>