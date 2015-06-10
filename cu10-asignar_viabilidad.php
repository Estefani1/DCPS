<?php

require('configs/include.php');

class c_asignar_viabilidad extends super_controller {
    
    var $sinviabilidad;
    
    public function add() {

        $viabilidad = new viabilidad($this->post);
        if (is_empty($viabilidad->get('codigo')) || is_empty($viabilidad->get('prediseno')) || 
                is_empty($viabilidad->get('resultado')) || is_empty($viabilidad->get('causa'))) {
            $this->verificar_completitud();
        }
        else{

        $viabilidad->set('analista', $this->session['id']);
        //---Obtengo la idea del prediseño que seleccone
        $options['prediseno']['lvl2'] = 'all';
        $cod['prediseno']['codigo'] = $this->post->prediseno;


        $this->orm->connect();

        $this->orm->insert_data("normal", $viabilidad);
        $this->orm->read_data(array("prediseno"), $options, $cod);
        $prediseno = $this->orm->get_objects("prediseno");

        $options1['idea']['lvl2'] = 'one';
        $cod1['idea']['nombre'] = $prediseno[0]->get('idea');

        $this->orm->read_data(array("idea"), $options1, $cod1);
        $ide = $this->orm->get_objects("idea");



        settype($idea, 'object');
        $idea->nombre = $ide[0]->get('nombre');
        $idea->etapa = $this->post->resultado;

        $idea1 = new idea($idea);
        if ($this->post->resultado == "Modificable") {
            $this->orm->update_data("modificable", $idea1);
        }
        $this->orm->close();


        $this->engine->assign(alerta, "ms.alertify_asignar_viabilidad()");
    }
    }
    
    public function verificar_completitud() {
        $this->engine->assign(alerta, "ms.alertify_error()");
    }

    public function VerificarViabilidad($predis) {
        if (is_empty($predis)) {
            $this->sinviabilidad = 'opciones_analista.tpl';
            $this->engine->assign(alerta, "ms.alertify_asignar_viabilidad_error1()");
        }
    }
    
    public function verificar_rol() {
        if (!isset($this->session['id'])) header('Location: cu1-login.php');
        else
            if ($this->session['tipo2'] != "analista de negocios") header('Location: opciones_analista.php');
    }

    public function display() {
        $options['prediseno']['lvl2'] = 'sinviabilidad';
        $this->orm->connect();
        $this->orm->read_data(array("prediseno"), $options);
        $predis = $this->orm->get_objects("prediseno");
        $this->orm->close();
        $this->engine->assign('predis', $predis);
        $this->VerificarViabilidad($predis);
        
        $this->engine->assign('title', 'Asiganar viabilidad');
        $this->engine->display('header.tpl');
        $this->engine->display('opciones_analista.tpl');
        $this->engine->display($this->temp_aux);
        if (!isset($this->sinviabilidad)) $this->engine->display('cu10-asignar_viabilidad.tpl');
        else $this->engine->display('fondo_perro.tpl');
        $this->engine->display('footer.tpl');
    }

    public function run() {
        try {
            $this->verificar_rol();
            if (isset($this->get->option)) $this->{$this->get->option}();
        } catch (Exception $e) {
            $this->error = 1;
            $this->msg_warning = $e->getMessage();
            $this->engine->assign('type_warning', $this->type_warning);
            $this->engine->assign('msg_warning', $this->msg_warning);
            $this->temp_aux = 'message.tpl';
        }
        $this->display();
    }

}

$ob = new c_asignar_viabilidad();
$ob->run();
?>