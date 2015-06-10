<?php

require('configs/include.php');

class c_Registrar_prediseno extends super_controller {

    public function Agregar_prediseno() {
        if (is_empty($this->post->codigo)) {
            $message1 = "Ingrese el codigo por favor. ";
        }
        if (!is_empty($message1))
            throw_exception($message1);

        if (!is_numeric($this->post->codigo)) {
            $message2 = "El codigo del prediseño debe ser numerico";
        }
        if (!is_empty($message2))
            throw_exception($message2);

        if (!$this->select_prediseno() == 0) {
            $message3 = "Ya existe un prediseño con este codigo";
        }
        if (!is_empty($message1) || !is_empty($message2) || !is_empty($message3))
            $this->engine->assign(alerta, "ms.alertify_error()");

        $pred = new prediseno($this->post);
        $pred->set('especialista',$this->session['id']);
        $this->orm->connect();
        $this->orm->insert_data("insert", $pred);
        $this->orm->close();
        $this->engine->assign(alerta, "ms.alertify_registrar_prediseno()");
        
      
    }

    public function select_prediseno() {
        $options['prediseno']['lvl2'] = "all";
        $cod['prediseno']['Codigo'] = $this->post->codigo;
        $this->orm->connect();
        $this->orm->read_data(array("prediseno"), $options, $cod);
        $predise = $this->orm->get_objects("prediseno");
        $this->orm->close();
        return count($predise);
    }
    public function actualizar_ideas(){
        $options['calificacion']['lvl2']="prom";
        $this->orm->connect();
        $this->orm->read_data(array("calificacion"), $options);
        $califica = $this->orm->get_objects("calificacion");
        if(is_empty($califica)){
            $this->engine->assign(alerta, "ms.alertify_registrar_prediseno_error()");
        }else{
            foreach ($califica as $key => $cal) {
                if($cal->get('valor') < 3){
                    $etapa = 'No aceptada';
                }else{
                    $etapa = 'Aceptada';
                }
                $code['idea']['nombre'] = $cal->get('idea');
                $options['idea']['lvl2']= "one";
                $this->orm->read_data(array("idea"), $options, $code);
                $ii = $this->orm->get_objects("idea");
                $ii[0]->set('etapa', $etapa);
                $this->orm->update_data("normal",$ii[0]);
            }
        }
        $this->orm->close();
    }

    public function display() {
    
        $this->engine->display('header.tpl');
        $this->engine->display('opciones_analista.tpl');
        $this->engine->display($this->temp_aux);
        $this->engine->display('cu9-Registrar_prediseno.tpl');
        $this->engine->display('footer.tpl');
    }

    public function run() {
        try {if(!isset($this->session['id'])){header('Location: cu1-login.php');}
            elseif($this->session['tipo2']=="especialista en desarrollo del producto"){
                if (isset($this->get->option)) {
                    $this->{$this->get->option}();
                }
                $this->actualizar_ideas();
                $options['idea']['lvl2'] = "Aceptadas";
                $this->orm->connect();
                $this->orm->read_data(array("idea"), $options, $cod);
                $ideas = $this->orm->get_objects("idea");
                $this->engine->assign('ideas',$ideas);
            }else{
                header($this->session['header']);
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
$call = new c_Registrar_prediseno();
$call->run();
?>