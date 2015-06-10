<?php
require ('configs/include.php');
class c_realizar_calificacion extends super_controller {
    public function calificar() {
        $cal = $this->post->calificacion;
        $ide = $this->post->idea;
        $calificacion = new calificacion();
        $calificacion->set('idea', $ide);
        $calificacion->set('valor', $cal);
        if (is_empty($calificacion->get('valor'))||$ide=="Seleccione idea"){
            $this->verificar_completitud();
        }
        else{
                
        $code['idea']['nombre'] = $ide;
        $options['idea']['lvl2'] = "one";
        $this->orm->connect();
        $this->orm->read_data(array("idea"), $options, $code);
        $ideas = $this->orm->get_objects("idea");
        if ($ideas[0]->get('miembro') == $this->session['id']) {
            $this->verificarmiembro();
        } else {
            $calificacion->set('miembro', $this->session['id']);
            $this->orm->insert_data("normal", $calificacion);
            $this->orm->close();
            $this->engine->assign(alerta, "ms.alertify_calificacion()");
        }
        }
    }
    
    public function verificarmiembro() {
        $this->engine->assign(alerta, "ms.alertify_error_calificacion()");
    }
    
    public function verificarreunion($idea) {
        if (is_empty($idea)) {
            $this->engine->assign(alerta, "ms.alertify_reunion_calificacion()");
        }
    }
    
    public function verificar_completitud() {
        $this->engine->assign(alerta, "ms.alertify_error_proponer()");
        //elseif (is_empty($calificacion->get('idea'))) throw_exception("Seleccione una idea");
    }
    
    public function verificar_rol() {
        if (!isset($this->session['id'])) header('Location: cu1-login.php');
            else 
                if ($this->session['tipo1'] != "miembro") header($this->session['header']);
    }
    public function display() {
        $this->engine->assign('title', 'Realizar calificacion');
        $this->engine->display('header.tpl');
        if($this->session['id'] == 1234){
            $this->engine->display('opciones_especialista.tpl');
        }else if($this->session['id'] == 2345){
            $this->engine->display('opciones_analista.tpl');
        }else if($this->session['id'] == 3456){
            $this->engine->display('opciones_gerente.tpl');
        }else if($this->session['id'] == 4567){
            $this->engine->display('opciones_ingeniero.tpl');
        }else if($this->session['id'] == 5678){
            $this->engine->display('opciones_arquitecto.tpl');
        }
        $this->engine->display($this->temp_aux);
        $this->engine->display('cu3-realizar_calificacion.tpl');
        $this->engine->display('footer.tpl');
    }
    public function run() {
        try {
            $this->verificar_rol();
            $options['idea']['lvl2'] = "reunion";
            $this->orm->connect();
            $this->orm->read_data(array("idea"), $options);
            $idea = $this->orm->get_objects("idea");
            $this->orm->close();
            $this->verificarreunion($idea);
            $this->engine->assign('idea', $idea);
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
$call = new c_realizar_calificacion();
$call->run();
?>