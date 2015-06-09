<?php
require ('configs/include.php');
class c_proponeridea extends super_controller {
    public function add() {
        $idea = new idea($this->post);
        $this->verificar_completitud($idea);
        $this->idea_existente($idea->get('nombre'));
        
        if ($this->session['tipo1'] == "miembro") {
            $idea->set('cliente', 'NULL');
            $idea->set('miembro', $this->session['id']);
        } else {
            $idea->set('miembro', 'NULL');
            $idea->set('cliente', $this->session['id']);
        }
        $this->orm->connect();
        $this->orm->insert_data("normal", $idea);
        $this->orm->close();
        //$this->type_warning = "ms.alertify()";
        //$this->msg_warning = "Idea propuesta correctamente";
        //$this->temp_aux = 'message.tpl';
        //$this->engine->assign('type_warning', $this->type_warning);
        //$this->engine->assign('msg_warning', $this->msg_warning);
        $this->engine->assign(alerta2, "ms.alertify_proponer_idea()");
    }
    
    public function verificar_completitud($idea) {
        if (is_empty($idea->get('nombre')) || is_empty($idea->get('descripcion')) || ($idea->get('necesidad') == "Seleccione necesidad")) {
            $this->engine->assign(alerta2, "ms.alertify_error_proponer()");
        }
    }
    
    public function idea_existente($nombre) {
        $cod['idea']['nombre'] = $nombre;
        $options['idea']['lvl2'] = "one";
        $this->orm->connect();
        $this->orm->read_data(array("idea"), $options,$cod);
        $cidea = $this->orm->get_objects("idea");
        $this->orm->close();
        if (!is_empty($cidea)){
            $this->engine->assign(alerta2, "ms.alertify_nombre_usado()");
        }
    }
    
    public function CargarNecesidad() {
        $options['necesidad']['lvl2'] = "all";
        $this->orm->connect();
        $this->orm->read_data(array("necesidad"), $options);
        $necesidad = $this->orm->get_objects("necesidad");
        $this->orm->close();
        $this->engine->assign('necesidad', $necesidad);
    }
    
    public function verificar_rol() {
        if (!isset($this->session['id'])) header('Location: cu1-login.php');    
        else 
            if ($this->session['tipo1'] != "cliente" && $this->session['tipo1'] != "miembro") 
                    header('Location: disenador.php');
    }
    
    public function display() {
        $this->CargarNecesidad();
        $this->engine->assign('title', 'proponer idea');
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
        //$this->engine->display($this->temp_aux);
        $this->engine->display('cu2-proponeridea.tpl');
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
$call = new c_proponeridea();
$call->run();
?>
