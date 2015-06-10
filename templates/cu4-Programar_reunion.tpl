<!--Para usar la ñ-->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<form action="{$gvar.l__global}cu4-Programar_reunion.php?option=agregar_reunion" method="post">
    <body {if isset($alerta)} onload="{$alerta}"{/if}>
    <div class="col-md-4 col-md-offset-3 fondo tr">
    
                Ingrese el código de la reunion: 
                <input class="form-control" name="codigo" type="text">
                <br/>
                Seleccione fecha de la reunion: 
                <input class="form-control" name="fecha" type="date">
                <br/>
                Seleccionar idea:
                <select class="form-control" name="idea">
                        <option value="">Seleccione idea</option>
                        {section loop=$ide name=i}
                            <option value= '{$ide[i]->get('nombre')}'> {$ide[i]->get('nombre')}</option>
                        {/section}

                    </select>
                        <br/>
                <input class="btn btn-primary" type="submit" value="Programar reunion" name="reunion" />

           
</form>
                        </div>
<div class="col-md-3">

</div>
</body>
</div>
