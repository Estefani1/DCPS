<?php

require('configs/include.php');

class c_Registrar_prediseno extends super_controller {

    public function Agregar_prediseno() {

        $this->verificar_completitud();
        if (!is_empty($this->post->codigo)&&$this->post->idea != "Seleccione idea"){
            $pred = new prediseno($this->post);
            $pred->set('especialista',$this->session['id']);
            $this->orm->connect();
            $this->orm->insert_data("insert", $pred);
            $this->orm->close();
            $this->engine->assign(alerta, "ms.alertify_registrar_prediseno()");
        }
    }
    
    public function verificar_completitud() {
        if ($this->post->idea == "Seleccione idea") 
            $this->engine->assign(alerta, "ms.alertify_registrar_prediseno_error2()");
        if (is_empty($this->post->codigo)) 
            $this->engine->assign(alerta, "ms.alertify_registrar_prediseno_error1()");
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
    
    public function verificar_rol() {
        if (!isset($this->session['id'])) header('Location: cu1-login.php');
        else
            if ($this->session['tipo2'] !="especialista en desarrollo del producto") header($this->session['header']);
    }

    public function display() {
        $this->actualizar_ideas();
        $options['idea']['lvl2'] = "Aceptadas";
        $this->orm->connect();
        $this->orm->read_data(array("idea"), $options, $cod);
        $ideas = $this->orm->get_objects("idea");
        $this->engine->assign('ideas',$ideas);
        $this->orm->close();
                
        $this->engine->display('header.tpl');
        $this->engine->display($this->session['display']);
        //$this->engine->display($this->temp_aux);
        $this->engine->display('cu9-Registrar_prediseno.tpl');
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
$call = new c_Registrar_prediseno();
$call->run();
?>