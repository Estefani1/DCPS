<?php

require('configs/include.php');

class c_Programar_reunion extends super_controller {

    public function agregar_reunion() {
   
        if (is_empty($this->post->fecha)||is_empty($this->post->codigo)||is_empty($this->post->idea)) {
            $this->verificar_completitud();
        }
        else{
        $reun = new reunion($this->post);
        $idear = new idea();
        $idear->set('nombre', $this->post->idea);
        $idear->set('reunion', $this->post->codigo);

        $this->orm->connect();
        $this->orm->insert_data("normal", $reun);
        $this->orm->update_data("reunion", $idear);
        $this->orm->close();
        $this->engine->assign(alerta, "ms.alertify_programar_reunion()");
        }
    }
    
    public function verificar_completitud() {
        $this->engine->assign(alerta, "ms.alertify_error()");
    }
    
    public function verificar_rol() {
        if (!isset($this->session['id'])) header('Location: cu1-login.php');
        else
            if ($this->session['tipo2'] != "gerente de negocios") header($this->session['header']);
    }
    
    public function selectideas() {

        $options['idea']['lvl2'] = 'Por revisar';
        $this->orm->connect();
        $this->orm->read_data(array("idea"), $options);
        $idea = $this->orm->get_objects("idea");
        $this->orm->close();
        $this->engine->assign('ide', $idea);
        //echo $idea[1]->get('nombre');
        //print_r2($idea);
    }

    public function selectreuniones() {
        $options['reunion']['lvl2'] = "all";
        $auxiliars['reunion'] = array("Nombre_de_la_idea");
        $this->orm->connect();
        $this->orm->read_data(array("reunion"), $options);
        $reuniones = $this->orm->get_objects("reunion", NULL, $auxiliars);
        $this->engine->assign('reuniones', $reuniones);
    }

    public function display() {
        // $this->selectreuniones();
        $this->engine->display('header.tpl');
        $this->engine->display($this->session['display']);
        $this->engine->display($this->temp_aux);
        $this->engine->display('cu4-Programar_reunion.tpl');
        $this->engine->display('footer.tpl');
    }

    public function run() {
        try {
            $this->verificar_rol();
            if (isset($this->get->option)) $this->{$this->get->option}();
        } catch (Exception $e) {
            $this->error = 1;
            $this->msg_warning = $e->getMessage();
            $this->temp_aux = 'message.tpl';
            $this->engine->assign('type_warning', $this->type_warning);
            $this->engine->assign('msg_warning', $this->msg_warning);
        }
        $this->selectideas();
        $this->display();
    }

}

$call = new c_Programar_reunion();
$call->run();
?>
