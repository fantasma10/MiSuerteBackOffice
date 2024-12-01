<?php


class Map{

	public function index()
	{
		add_js('map/map.js');
		#add_first_function_js('initPrealta');

		$this->load->view('common/header');
		$this->load->view('common/menu_dinamico');
		$this->load->view('map/map');
		$this->load->view('common/footer');
	} # index

	public function showLocation(){
		$data = array(
			'lat'	=> $this->input->post('lat', true),
			'lng'	=> $this->input->post('lng', true)
		);

		$this->load->view('map/modal_map', $data);
	} # showLocation

	public function localizame(){

		add_js('map/localizame.js');

		$this->load->view('common/header');
		$this->load->view('common/menu_dinamico');
		$this->load->view('map/localiza');
		$this->load->view('common/footer');
	}

	public function direccion(){
		#$this->load->view('common/header');
		#$this->load->view('common/menu_dinamico');
		$this->load->view('map/direccion');
		#$this->load->view('common/footer');
	}
}# EOF Logout
