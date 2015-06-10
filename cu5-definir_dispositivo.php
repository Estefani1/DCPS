<?php

require('configs/include.php');

class c_definir_dispositivo extends super_controller {

    public function add() {
        
        $dispositivo = new dispositivo($this->post);
        if (is_null($dispositivo->get('codigo'))) {
            $message1 = "Por favor ingrese el codigo";
            $this->engine->assign(alerta, "ms.alertify_reunion2()");
        }
        elseif (is_null($dispositivo->get('costo'))) {
            $message2 = "Por favor ingrese el costo";
            $this->engine->assign(alerta, "ms.alertify_definir_dispositivo_error1()");            
        }
        elseif (is_null($dispositivo->get('funcion'))) {
            $message3 = "Por favor ingrese la funcion";
            $this->engine->assign(alerta, "ms.alertify_definir_dispositivo_error2()"); 
        }
        elseif (($dispositivo->get('prediseno') == "Prediseno")) {
            $message4 = "Por favor seleccione el prediseno";
            $this->engine->assign(alerta, "ms.alertify_definir_dispositivo_error3()"); 
        }
        
        else{
        $this->orm->connect();
        $this->orm->insert_data("normal", $dispositivo);
        $this->orm->close();
        $this->engine->assign(alerta, "ms.alertify_definir_dispositivo()");
        }
    }

    public function selectprediseno() {
        $options['prediseno']['lvl2'] = 'todospredisenos';
        $this->orm->connect();
        $this->orm->read_data(array("prediseno"), $options);
        $predis = $this->orm->get_objects("prediseno");
        $this->orm->close();
        $this->engine->assign('predis', $predis);
    }

    public function display() {
        $this->selectprediseno();
        $this->engine->display('header.tpl');
        $this->engine->display($this->session['display']);
        $this->engine->display($this->temp_aux);
        $this->engine->display('cu5-definir_dispositivo.tpl');
        $this->engine->display('footer.tpl');
    }

    public function run() {
        try {
            if (!isset($this->session['id'])) {
                header('Location: cu1-login.php');
            } else {
                if ($this->session['tipo2'] == "especialista en desarrollo del producto") {
                    if (isset($this->get->option)) {
                        $this->{$this->get->option}();
                    }
                } else {
                    header($this->session['header']);
                }
            }
        } catch (Exception $e) {
            $this->error = 1;
            $this->type_warning = "error";
            $this->msg_warning = $e->getMessage();
            $this->temp_aux = 'message.tpl';
            $this->engine->assign('type_warning', $this->type_warning);
            $this->engine->assign('msg_warning', $this->msg_warning);
        }
        $this->display();
    }

}

$call = new c_definir_dispositivo();
$call->run
();
?>


