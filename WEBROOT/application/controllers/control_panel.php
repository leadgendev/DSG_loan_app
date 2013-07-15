<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
////////////////////////////////////////////////////////////////
// File: application/controller/control_panel.php
////////////////////////////////////////////////////////////////

class Control_panel extends CI_Controller
{
	public function __construct ()
	{
		parent::__construct();
		
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->database();
	}
	
	public function index ()
	{
		$url = "https://secure.cashmoneynow.net/secure/DSG_loan_app/index.php/control_panel/";
		
		if ( $this->__check_user_logged_in() ) {
			redirect( $url . 'dashboard/' );
			die;
		}
		
		$this->load->view( 'control_panel/login' );
	}
	
	public function login ( $username, $password )
	{
		$_username = urldecode( $username );
		$_password = urldecode( $password );
		$this->db->from( 'users' );
		$this->db->select( '*' );
		$this->db->where( 'username', $_username );
		$query = $this->db->get();
		$row = $query->row();
		
		//if ( true ) {
			//echo "$username \n\n $password \n\n";
			//echo $row->username . " \n\n " . $row->password . " \n\n ";
			//die;
		if ( $_password == $row->password ) {
			$this->session->set_userdata( 'uid', $row->id );
			redirect( "https://secure.cashmoneynow.net/secure/DSG_loan_app/index.php/control_panel/dashboard/" );
			die;
		} else {
			redirect( "https://secure.cashmoneynow.net/secure/DSG_loan_app/index.php/control_panel/" );
			die;
		}
	}
	
	public function logout ()
	{
		$this->session->sess_destroy();
		redirect( "https://secure.cashmoneynow.net/secure/DSG_loan_app/index.php/control_panel/" );
	}
	
	public function dashboard ()
	{
		if ( ! $this->__check_user_logged_in() ) {
			redirect( "https://secure.cashmoneynow.net/secure/DSG_loan_app/index.php/control_panel/" );
			die;
		}
		
		$this->load->view( 'control_panel/dashboard' );
	}
	
	public function section ( $id )
	{
	
	}
	
	public function create_site_configuration ()
	{
	
	}
	
	public function site_configurations ()
	{
		$this->load->model( 'site_configuration' );
		
		$site_configurations = $this->site_configuration->list_all();
		$json = json_encode( array( 'site_configurations' => $site_configurations ));
		
		$this->output->set_content_type( 'application/json' );
		$this->output->set_output( $json );
	}
	
	public function site_configuration ( $id )
	{
		$this->load->model( 'site_configuration' );
		
		$this->site_configuration->id = $id;
		$this->site_configuration->load();
		
		$json = json_encode( array(
			'site_configuration' => array (
				'id' => $this->site_configuration->id,
				'name' => $this->site_configuration->name,
				'configuration_file' => $this->site_configuration->configuration_file,
				'created' => $this->site_configuration->created,
				'landing' => $this->site_configuration->landing,
				'short_form' => $this->site_configuration->short_form,
				'long_form' => $this->site_configuration->long_form,
				'banner' => $this->site_configuration->banner,
				'ping_tree_1' => $this->site_configuration->ping_tree_1,
				'ping_tree_2' => $this->site_configuration->ping_tree_2,
				'ping_tree_3' => $this->site_configuration->ping_tree_3,
				'ping_tree_4' => $this->site_configuration->ping_tree_4,
				'mutex_meta' => $this->site_configuration->mutex_meta
			)
		));
		
		$this->output->set_content_type( 'application/json' );
		$this->output->set_output( $json );
	}
	
	public function update_site_configuration ()
	{
	
	}
	
	private function __check_user_logged_in ()
	{
		if ( ! $this->session->userdata( 'uid' ) ) {
			return false;
		} else {
			return true;
		}
	}
}

////////////////////////////////////////////////////////////////
// End of file: application/controller/control_panel.php
////////////////////////////////////////////////////////////////