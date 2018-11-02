<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

	public function _construct () {
		parent::_construct();
		echo "<pre>";
			print_r($this->session->all_userdata());
		echo "</pre>";	
	}

	public function index($page_slug = null) {
		if($page_slug) {
			$this->db->where('page_slug', $page_slug);
		}else{
			$this->db->where('page_frontpage',1);
		}

			$sqlQuery = $this->db->get('pages');

			$data = $sqlQuery->row_array();

			$data['page_published'] = date('d-m-Y', $data['page_published']);

			//Henter menupunkterne fra pages tabellen og opdatere automatisk navbaren
			$data['nav'] = $this->db->get('pages')->result_array();

			$this->parser->parse('template/header');
			$this->parser->parse('template/nav');
			$this->parser->parse('template/mainstart');
			$this->parser->parse('post');
			$this->parser->parse('template/mainend');
			$this->parser->parse('template/footer');
	}
}
