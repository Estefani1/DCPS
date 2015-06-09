<?php

require('configs/include.php');

class c_Modificar_idea extends super_controller {

    public function Modificaridea() {
        if ($this->post->descripcion == NULL) {
            $message1 = "Ingrese nueva descripcion por favor. ";
        }
        if (!is_empty($message1))
            $this->engine->assign(alerta, "ms.alertify_modificar_idea_error()");
        else{
        $_SESSION['nombre'] = $this->post->ddl;
        //acà actualizo
        $ide = new idea($this->post);
        $ide->set('miembro',$this->session['id']);
        $ide->set('etapa',"Modificada");
        $this->orm->connect();
        $this->orm->update_data("normal", $ide);
        $this->orm->close();
        //acà finaliza la actualizacion 
        $this->engine->assign(alerta, "ms.alertify_modificar_idea()");
        }
    }

    public function selectideas() {

        $options['idea']['lvl2'] = 'modificables';
        $this->orm->connect();
        $this->orm->read_data(array("idea"), $options);
        $idea = $this->orm->get_objects("idea");
        $this->orm->close();
        $this->engine->assign('ide', $idea);
        //echo $idea[1]->get('nombre');
    }

    public function display() {

        $this->selectideas();
        $this->engine->display('header.tpl');
        if($this->session['id'] == 1234){
            $this->engine->display('opciones_especialista.tpl');
        }else if($this->session['id'] == 2345){
            $this->engine->display('opciones_analista.tpl');
        }else if($this->session['id'] == 4567){
            $this->engine->display('opciones_ingeniero.tpl');
        }else if($this->session['id'] == 5678){
            $this->engine->display('opciones_arquitecto.tpl');
        }
        $this->engine->display($this->temp_aux);
        $this->engine->display('cu12-Modificar_idea.tpl');
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

$ob = new c_Modificar_idea();
$ob->run();
?>