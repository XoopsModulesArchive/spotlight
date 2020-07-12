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

class SpotlightMini extends XoopsObject {
	function SpotlightMini(){
		$this->XoopsObject();
	//	key, data_type, value, req, max, opt
		$this->initVar("mini_id", XOBJ_DTYPE_INT);
		$this->initVar("topicid", XOBJ_DTYPE_INT, 0, false, 8);
		$this->initVar("mini_img", XOBJ_DTYPE_TXTBOX, '', false, 50);
		$this->initVar("mini_text", XOBJ_DTYPE_TXTAREA, '');
		$this->initVar("mini_align", XOBJ_DTYPE_INT, 0, false, 1);
		$this->initVar("mini_show", XOBJ_DTYPE_INT, 0);
		$this->initVar("title", XOBJ_DTYPE_TXTBOX);
		$this->initVar("published", XOBJ_DTYPE_INT);
		$this->initVar("expired", XOBJ_DTYPE_INT);
	}
}

class SpotlightMiniHandler extends XoopsObjectHandler {
	var $db;
	var $db_table;
	var $obj_class = 'SpotlightMini';
	
	function SpotlightMiniHandler(&$db){
		$this->db =& $db;
		$this->db_table = $this->db->prefix('spotlight_mini');
	}
	
	function &getInstance(&$db){
		static $instance;
		if (!isset($instance)){
			$instance = new SpotlightMiniHandler($db);
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
			$sql = 'SELECT '.$query.' FROM '.$this->db_table.' WHERE mini_id='.$id;
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

	function &getObjects($show_only=true, $id_as_key = false){
		$ret = array();
		$sql = 'SELECT m.*, n.title, n.published, n.expired FROM '
				.$this->db_table.' m, '
				.$this->db->prefix('stories').' n'
				;
		$criteria = new CriteriaCompo();
		if( $show_only ){
			$criteria->add(new Criteria('m.mini_show', 1));
		}
		$criteria->add(new Criteria('m.topicid', 0, '>'));
		$criteria->add(new Criteria('m.topicid', 'n.`topicid`'));
		$sql .= ' '.$criteria->renderWhere();
		$sql .= ' ORDER BY m.mini_id ASC';
		$result = $this->db->query($sql);
		if( !$result ){
			return false;
		}
// 		die($sql);exit();
		while( $myrow = $this->db->fetchArray($result) ){
			$obj = new $this->obj_class();
			$obj->assignVars($myrow);
			if( !$id_as_key ){
				$ret[] =& $obj;
			}else{
				$ret[$myrow['mini_id']] =& $obj;
			}
			unset($obj);
		}
		return count($ret) > 0 ? $ret : false;
	}
	
	function insert(&$obj, $force = false){
        // if( strtolower(get_class($obj)) != strtolower($this->obj_class) ){ modif thecat
		if (strtolower(get_class($obj)) != strtolower($this->obj_class) ){
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
		if( $obj->isNew() || empty($mini_id) ){
			$mini_id = $this->db->genId($this->db_table."_mini_id_seq");
			$sql = sprintf("INSERT INTO %s (
				mini_id, topicid, mini_img, mini_text,
				mini_show, mini_align
				) VALUES (
				%u, %u, %s, %s,
				%u, %u
				)",
				$this->db_table,
				$mini_id,
				$topicid,
				$this->db->quoteString($mini_img),
				$this->db->quoteString($mini_text),
				$mini_show,
				$mini_align
				);
		}else{
			$sql = sprintf("UPDATE %s SET
				topicid = %u,
				mini_img = %s,
				mini_text = %s,
				mini_show = %u,
				mini_align = %u
				WHERE mini_id = %u",
				$this->db_table,
				$topicid,
				$this->db->quoteString($mini_img),
				$this->db->quoteString($mini_text),
				$mini_show,
				$mini_align,
				$mini_id
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
		if( empty($mini_id) ){
			$mini_id = $this->db->getInsertId();
		}
        $obj->assignVar('mini_id', $mini_id);
		return $mini_id;
	}

}
?>
