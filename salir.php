<?php
require ('configs/include.php');
class c_salir extends super_controller {
       
    public function display() {
         $_SESSION['miembro'] = NULL;
         $_SESSION['identi'] = NULL;
         $_SESSION['id'] = NULL;
         $_SESSION['tipo1'] = NULL;
         $_SESSION['header'] = NULL;
         $this->session = NULL;
         header('Location: cu1-login.php');
     
    }
    public function run() {
        try {
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
$call = new c_salir();
$call->run();
?>