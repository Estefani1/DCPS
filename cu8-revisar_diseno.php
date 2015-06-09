<?php

require('configs/include.php');

class c_revisar_diseno extends super_controller {

    public function add() {
        if ($this->post->evaluacion == "Seleccione") {
            $message1 = "Por favor califique el diseño";
            $this->engine->assign(alerta, "ms.alertify_revisar_diseno_error1()");
        }
        elseif($this->post->codigo == "Seleccione codigo") {
            $message2= "Seleccione el codigo del prediseño";
            $this->engine->assign(alerta, "ms.alertify_revisar_diseno_error2()");
        }
        else{        
        $diseno = new diseno($this->post);
        $codp = $this->post->codigo;
        $cali = $this->post->evaluacion;
        if (is_empty($codp)) {
            $this->engine->assign(alerta, "ms.alertify_error()");
        }
        if (is_empty($cali)) {
            $this->engine->assign(alerta, "ms.alertify_error()");
        }

        $this->orm->connect();
        $this->orm->update_data("revision", $diseno);
        $this->orm->close();
        $this->engine->assign(alerta, "ms.alertify_revisar_diseno()");
        }
    }

    public function display() {
        $option['diseno']['lvl2'] = "all";
        $this->orm->connect();
        $this->orm->read_data(array("diseno"), $option);
        $diseno = $this->orm->get_objects("diseno");
        $this->orm->close();

        if (!isset($diseno)) {
            $this->engine->assign(alerta, "ms.alertify_revisar_diseno_error()");
            //header($this->session['header']);
        }

        $this->engine->assign('diseno', $diseno);
        $this->engine->assign('title', 'Revisar diseño');
        $this->engine->display('header.tpl');
        $this->engine->display('opciones_especialista.tpl');
        $this->engine->display($this->temp_aux);
        $this->engine->display('cu8-revisar_diseno.tpl');
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
            $this->msg_warning = $e->getMessage();
            $this->engine->assign('type_warning', $this->type_warning);
            $this->engine->assign('msg_warning', $this->msg_warning);
            $this->temp_aux = 'message.tpl';
        }
        $this->display();
    }

}

$ob = new c_revisar_diseno();
$ob->run();
?>