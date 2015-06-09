<?php

require('configs/include.php');

class c_opciones_especialista extends super_controller {

    public function display() {


        $this->engine->display('header.tpl');
        $this->engine->display('opciones_especialista.tpl');
        $this->engine->display('fondo_perro.tpl');
        $this->engine->display('footer.tpl');
    }

    public function run() {
        if(!isset($this->session['id'])){
            header('Location: cu1-login.php');
        }elseif($this->session['tipo2']!= "especialista en desarrollo del producto"){
            header($this->session['header']);
        }else{
           if (isset($this->get->option)) {

                $this->{$this->get->option}();
            }
        }
        

        $this->display();
    }

}

$ob = new c_opciones_especialista();
$ob->run();
?>