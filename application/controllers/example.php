<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

class PaymentMethod extends CI_Controller {

    /**
     * Construtor da classe
     */
    public function __construct() {
        parent::__construct ();
        $this->load->config('pagarme');
        $this->load->library('PagarmeLibrary');
    }

    public function pagarme()
    {
        $this->pagarme();
    }
}