<?php

require ('configs/include.php');

class c_definirsoftware extends super_controller {

    public function add() {
        $software = new software($this->post);
 
       if (is_null($software->get('codigo'))) {
            $message1 = "Por favor ingrese el codigo";
            $this->engine->assign(alerta, "ms.alertify_reunion2()");
        }
        elseif (($software->get('prediseno') == "Prediseno")) {
            $message2 = "Por favor seleccione el prediseno";
            $this->engine->assign(alerta, "ms.alertify_definir_dispositivo_error3()"); 
        }

        elseif (($software->get('lenguaje') == "Lenguaje")) {
            $message3 = "Por favor seleccione el lenguaje";
            $this->engine->assign(alerta, "ms.alertify_definir_software_error()");
        }
        else{

        $this->orm->connect();
        $this->orm->insert_data("normal", $software);
        $this->orm->close();
        $this->engine->assign(alerta, "ms.alertify_definir_software()");
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
        $this->engine->assign('title', 'Definir Software');
        $this->engine->display('header.tpl');
        $this->engine->display('opciones_arquitecto.tpl');
        $this->engine->display($this->temp_aux);
        $this->engine->display('cu6-definirrsoftware.tpl');
        $this->engine->display('footer.tpl');
    }

    public function run() {
      try {
            if(!isset($this->session['id'])){
                header('Location: cu1-login.php');
            }else{
                if($this->session['tipo1']=="miembro"){
                    if (isset($this->get->option)){$this->{$this->get->option}();}
                }else{
                    header($this->session['header']);
                }
            }
        } catch (Exception $e) {
            $this->error = 1;
            $this->msg_warning = $e->getMessage();
            $this->temp_aux = 'message.tpl';
            $this->engine->assign('type_warning', $this->type_warning);
            $this->engine->assign('msg_warning', $this->msg_warning);
        }
    
        $this->display();
    }

}

$call = new c_definirsoftware();
$call->run();
?>

