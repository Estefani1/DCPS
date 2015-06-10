<!--Para usar la ñ-->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<form action="{$gvar.l__global}cu9-Registrar_prediseno.php?option=Agregar_prediseno" method="post">
    <body {if isset($alerta)} onload="{$alerta}"{/if}>   
    <div class="col-md-4 col-md-offset-3 fondo tr">
    
                Ingrese el código del prediseño por favor:
                <input class="form-control" type="text" name="codigo" />
            
                Seleccione la idea asociada a este prediseño
                <select class="form-control"  name="idea">
                                <option>Seleccione idea</option>
                                {section loop=$ideas name=i }
                                    <option>{$ideas[i]->get('nombre')}</option>                 
                                {/section}
                        </select>
            
                <input class="btn btn-primary" type="submit" value="Registrar" name="Registrar" />
            
</form>
                        
</div>
<div class="col-md-3">

</div>
</body>
</div>