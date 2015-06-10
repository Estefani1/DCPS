<?php

require('configs/include.php');

class c_opcionescliente extends super_controller {

    public function display() {

        $this->engine->display('header.tpl');
        $this->engine->display('opcionescliente.tpl');
        $this->engine->display('cu2-proponeridea.tpl');
        $this->engine->display('footer.tpl');
    }

    public function run() {

    	if(!isset($this->session['id'])){
    		header('Location: cu1-login.php');
    	}elseif($this->session['tipo1']!= "cliente"){
    		header($this->session['header']);
    	}else{
    		
    	}
        $this->display();
    }

}

$ob = new c_opcionescliente();
$ob->run();
?>