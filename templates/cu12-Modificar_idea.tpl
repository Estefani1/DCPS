<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <script lang="javascript" src="js/jquery-2.1.3.min.js"></script>
    <body {if isset($alerta)} onload="{$alerta}"{/if}>    
        <form action="{$gvar.l__global}cu12-Modificar_idea.php?option=Modificaridea" method="post">
             <div class="col-md-4 col-md-offset-3 fondo tr">

            <b>Modificar idea:</b>
            <select class="form-control" name="ddl" id="mySelect" onchange="myFunction()" >
                                <option > Seleccione idea</option>
                                {section loop=$ide name=i }

                                    <option value= {$ide[i]->get('nombre')}> {$ide[i]->get('nombre')}</option>                 
                                {/section}

                            </select>
                    
                                <a class="des" id="desc"><b>Descripción actual:</b></a> 
                         
                            {section loop=$ide name=i }
                                <a  class="idea_descripcion" id="idea_descripcion_{$ide[i]->get('nombre')}" > {$ide[i]->get('descripcion')}</a>                 
                            {/section}

                        
                        <div class="des1" id="desc1">
                            <a >Nueva descripcion:</a> </br>

                            <textarea class="form-control" id="textAread_id" name = "descripcion" rows = "8" cols = "40" class = "input" WRAP ></textarea> </br>
                            <p>
                                <label for="select">Necesidad:</label>
                                <select  class="form-control" name="necesidad">
                                <option > Seleccione necesidad</option>
                                {section loop=$necesidad name=i}
                                <option value="{$necesidad[i]->get('codigo')}">{$necesidad[i]->get('nombre')}</option>
                                {/section}
                                </select>
                              </p>
                              <input class="btn btn-primary" type="submit" value="Modificar" />
                        </div>
 

            <script>
                function myFunction() {
                    var x = $("#mySelect").val();
                    $('.idea_descripcion').hide();
                    $('#idea_descripcion_' + x).show();

                    $('.des').hide();
                    $('#desc').show();

                    $('.des1').hide();
                    $('#desc1').show();

                }
                $(document).ready(function () {
                    $('.idea_descripcion').hide();
                    $('.des').hide();
                    $('.des1').hide();
                });
            </script>
        </form>
                            
 </div>
<div class="col-md-3">

</div>
</body>
</div>
    </body>
</html>