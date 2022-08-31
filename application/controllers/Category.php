<?php

class Category extends CI_Controller {

	public function kategori_1()
	{
		$data['title'] = 'Hias';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['list_data'] = $this->model_category->kategori_1()->result();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('category/list', $data);
        $this->load->view('templates/footer');
    }
    
    public function kategori_2()
	{
		$data['title'] = 'Langka';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['list_data'] = $this->model_category->kategori_2()->result();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('category/list', $data);
        $this->load->view('templates/footer');
    }
    
    public function kategori_3()
	{
		$data['title'] = 'Bonsai';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['list_data'] = $this->model_category->kategori_3()->result();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('category/list', $data);
        $this->load->view('templates/footer');
    }
    
    public function kategori_4()
	{
		$data['title'] = 'Herbal';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['list_data'] = $this->model_category->kategori_4()->result();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('category/list', $data);
        $this->load->view('templates/footer');
	}
}


