<!--Para usar la ñ-->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script lang="javascript" src="js/jquery-2.1.3.min.js"></script>
<body {if isset($alerta)} onload="{$alerta}"{/if}>
<div class="col-md-4 col-md-offset-3 fondo tr">
    <form action="{$gvar.l_global}cu6-definirsoftware.php?option=add" method="post">
        <b>Definir dispositivo</b>
        <br/>
        <br/>
                    <b>Ingrese el codigo del software</b>
                    
                        <input class="form-control" type="text" name="codigo" />
                  <br/>
                    <b>Defina el lenguaje de programacion</b>
                    
                        <select class="form-control" name="lenguaje">
                            <option>Lenguaje</option>  
                            <option value="C#">C#</option>  
                            <option value="C++">C++</option>
                            <option value="Java">Java</option> 
                            <option value="Python">Python</option> 
                            <option value="Ruby">Ruby</option>


                        </select>
                   
                    <br/>
                
                    <b>Seleccione el prediseño</b>
                    
                        <select class="form-control" name="prediseno" id="mySelect" onchange="myFunction()" >
                            <option>Prediseno</option>
                            {section loop=$predis name=i }
                                <option value="{$predis[i]->get(codigo)}">{$predis[i]->get('codigo')}</option>                 
                            {/section}
                        </select>
                    
                <div  class="cideaprediseno" id="idideaprediseno">
                    <br/>
                    <b>Idea del dispositivo:</b>
                    
                        {section loop=$predis name=i }
                            <a class="cidea letra" id="ididea_{$predis[i]->get(codigo)}"> {$predis[i]->get('idea')}</a>
                        {/section}


                    
                </div>
                <br/>
                    <input class="btn btn-primary" type="submit" value="Definir software" />
                
        <script>
            function myFunction() {
                var x = $("#mySelect").val();
                $('#idideaprediseno').show();
                $('#ididea_' + x).show();
            }
            $(document).ready(function () {
                $('.cideaprediseno').hide();
                $('.cidea').hide();

            });
        </script>

    </form>
</div>
<div class="col-md-3">

</div>
</body>
</div>

