<?php

require('configs/include.php');

class c_Modificar_idea extends super_controller {

    public function Modificaridea() {
        if ($this->post->descripcion == NULL || $this->post->necesidad == "Seleccione necesidad"||
                $this->post->ddl =="Seleccione idea") {
            $this->verificar_completitud();
        }
        else{
        //acà actualizo
        $ide = new idea($this->post);
        $ide->set('miembro',$this->session['id']);
        $ide->set('etapa',"Modificada");
        print_r2($ide);
        $this->orm->connect();
        $this->orm->update_data("normal", $ide);
        $this->orm->close();
        //acà finaliza la actualizacion 
        $this->engine->assign(alerta, "ms.alertify_modificar_idea()");
        }
    }
    
    public function verificar_completitud() {
        $this->engine->assign(alerta, "ms.alertify_error()");
    }
    
    public function verificar_rol() {
        if (!isset($this->session['id'])) header('Location: cu1-login.php');
        else
            if ($this->session['tipo1'] != "miembro") header('Location: disenador.php');
    }

    public function display() {

        $options['idea']['lvl2'] = 'modificables';
        $this->orm->connect();
        $this->orm->read_data(array("idea"), $options);
        $idea = $this->orm->get_objects("idea");
        $this->orm->close();
        $this->engine->assign('ide', $idea);
        
        $options['necesidad']['lvl2'] = "all";
        $this->orm->connect();
        $this->orm->read_data(array("necesidad"), $options);
        $necesidad = $this->orm->get_objects("necesidad");
        $this->orm->close();
        $this->engine->assign('necesidad', $necesidad);
        
        $this->engine->display('header.tpl');
        $this->engine->display($this->session['display']);
        $this->engine->display($this->temp_aux);
        $this->engine->display('cu12-Modificar_idea.tpl');
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
        $this->display();
    }

}

$ob = new c_Modificar_idea();
$ob->run();
?>