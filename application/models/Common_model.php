<?php
class Common_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->helper('url');

	}
    //----------------------------- Common save ---------------------------------//
	function save($table, $data){
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}
}