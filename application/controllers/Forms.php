<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Forms extends CI_Controller
{

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
     * @see https://codeigniter.com/userguide3/general/urls.html
     */
    public function tanya_spmb()
    {
        $nama = $this->input->post('nama');
        $alamat = $this->input->post('alamat');
        $pesan = $this->input->post('pesan');

        redirect('https://wa.me/6289698070466?text=Assalamualaikum ... Perkenalkan saya ' . $nama . ', saya berasal dari ' . $alamat . ', bermaksud menanyakan tentan SPMB SMA Negeri 1 Sukra, berikut pertanyaannya ' . $pesan);
    }
}
