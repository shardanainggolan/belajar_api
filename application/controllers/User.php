<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		// echo $id;
		// var_dump($this->input->get('id', TRUE));
		// die();
		// var_dump($this->input->server('REQUEST_METHOD'));
		// die();

		if($this->input->server('REQUEST_METHOD') == 'GET')
		{
			if($this->input->get('id', TRUE) != null) {
				$data = $this->db->where('user_id', $this->input->get('id', TRUE))->get('users')->row_array();

				if($data == null) {
					echo json_encode(array(
						'success'	=> FALSE,
						'msg'	=> 'Data tidak ditemukan!'
					));
				} else {
					echo json_encode(array(
						'success'	=> TRUE,
						'msg'		=> 'Data ditemukan!',
						'data'		=> $data
					));
				}
			} else {
				$users = $this->db->get('users')->result_array();

				echo json_encode(array(
					'data' => $users
				));
			}

			
		}
		
		if($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$data = array(
				'name' 		=> $this->input->post('name'),
				'email' 	=> $this->input->post('email'),
				'password' 	=> $this->input->post('password'),
			);

			$insert = $this->db->insert('users', $data);
			$insertId = $this->db->insert_id();

			// Ambil data ygbaru ditambahkan
			$user = $this->db->where('user_id', $insertId)->get('users')->row_array();

			if($insert) {
				echo json_encode(array(
					'success' => TRUE,
					'msg'	=> 'Data berhasil di tambahkan!',
					'data'	=> $user
				));
			}
		}
	}
}
