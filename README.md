# Pagar.me Codeigniter 3
Pagar.me integration library for Codeigniter 3

## Instalation
Download integrations files on repository for your application in `application/libraries`.

## How to
### Settings
Set the parameters settings Pagar.me on `application/config/pagarme.php`.
### Controller
```
<?php

class MeuController extends CI_Controller {
  public function __construct() {
  	parent::__construct ();
    
    $this->load->config('pagarme');
    $this->load->library('PagarmeLibrary');
  }
}
```
## Autoload
```
<?php

$autoload['config'] = array('pagarme');
$autoload['libraries'] = array('PagarmeLibrary');
```

* See examples on `controllers/example.php`