<?php

require('configs/include.php');

class c_index extends super_controller {
	
	public function display()
	{
                header('Location: cu1-login.php');
		$contenido_main = 'empty.tpl';
		
		if($this->get->cod != 765){
			$this->error = 1;
			$this->msg_warning = "Zona Prohibida";
			$this->temp_aux = 'message.tpl';
			$this->engine->assign('type_warning', $this->type_warning);
			$this->engine->assign('msg_warning', $this->msg_warning);
		}else{	
			$contenido_main = 'index.tpl';
		}
		$this->engine->assign('title',$this->gvar['n_index']);
		$this->engine->display('header.tpl');
		$this->engine->display($this->temp_aux);
		$this->engine->display($contenido_main);
		$this->engine->display('footer.tpl');
			
			
			
	}
	
	public function run()
	{
		$this->display();
	}
}

$call = new c_index();
$call->run();

?>