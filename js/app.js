var managerScreen = managerScreen || {};
managerScreen = {
    
    
    alertify: function(){
        //alertify .alert("Message");
        alertify.log("Falta ingresar Usuario o Contraseña", "Error", 10000);
        //alertify.log("Notification", "Success", 10000);
    },
    
    alertify_login: function(){
        //alertify .alert("Message");
        alertify.log("Usuario o contraseña incorrecto", "Error", 10000);
        //alertify.log("Notification", "Success", 10000);
    },
    
    alertify_error: function(){
        alertify.log("Faltan datos", "Error", 10000);
    },
    
    alertify_error_proponer: function(){
        alertify.log("Completa todos los campos", "Error", 10000);
    },  
    
    alertify_proponer_idea: function(){
        alertify.log("Idea propuesta correctamente", "Success", 10000);      
    },
    
    alertify_nombre_usado: function(){
        alertify.log("Nombre ya usado, pruebe con otro", "Error", 10000);      
    },
    
    alertify_error_calificacion: function(){
        alertify.log("Usted propuso esta idea, por lo tanto no debería calificarla", "Error", 10000);      
    },
    alertify_error_cal: function(){
        alertify.log("Ingrese una calificacion", "Error", 10000);      
    },
    
    alertify_calificacion: function(){
        alertify.log("Idea calificada correctamente", "Error", 10000);      
    },
    alertify_reunion1: function(){
        alertify.log("Seleccione la fecha por favor.", "Error", 10000);      
    },
     alertify_reunion2: function(){
        alertify.log("Ingrese el codigo por favor.", "Error", 10000);      
    },
    
    alertify_reunion3: function(){
        alertify.log("Seleccione la idea por favor.", "Error", 10000);      
    },
    
    
    alertify_reunion_calificacion: function(){
        alertify.log("No existen reuniones para hoy", "Error", 10000);      
    },
    
    alertify_programar_reunion: function(){
        alertify.log("Programación de la reunion con éxito", "Success", 10000);      
    },
    
    alertify_definir_dispositivo_error1: function(){
        alertify.log("Por favor ingrese el costo", "Error", 10000);      
    },
    
    alertify_definir_dispositivo_error2: function(){
        alertify.log("Por favor ingrese la funcion", "Error", 10000);      
    },
    
    alertify_definir_dispositivo_error3: function(){
        alertify.log("Por favor seleccione el prediseno", "Error", 10000);      
    },
    
    alertify_definir_dispositivo: function(){
        alertify.log("Dispositivo definido correctamente", "Success", 10000);      
    },
    
    alertify_definir_software_error: function(){
        alertify.log("Por favor seleccione el lenguaje", "Error", 10000);      
    },
    
    alertify_definir_software: function(){
        alertify.log("Software definido correctamente", "Success", 10000);      
    },
    
    alertify_realizar_diseno_error1: function(){
        alertify.log("Por favor seleccione el dispositivo", "Error", 10000);      
    },
    
    alertify_realizar_diseno_error2: function(){
        alertify.log("Por favor seleccione el software", "Error", 10000);      
    },
    
    alertify_realizar_diseno: function(){
        alertify.log("Diseno exitoso", "Success", 10000);      
    },
    
    alertify_revisar_diseno_error1: function(){
        alertify.log("Por favor califique el diseño", "Error", 10000);      
    },
    
    alertify_revisar_diseno_error2: function(){
        alertify.log("Seleccione el codigo del prediseño", "Error", 10000);      
    },
    
    alertify_revisar_diseno: function(){
        alertify.log("Revision exitosa", "Success", 10000);      
    },
    
    alertify_revisar_diseno_error: function(){
        alertify.log("No hay diseño para revisar", "Error", 10000);      
    },
    
    alertify_registrar_prediseno: function(){
        alertify.log("Completo", "Success", 10000);      
    },
    
    alertify_registrar_prediseno_error: function(){
        alertify.log("No hay ideas calificadas", "Error", 10000);      
    },
    
    alertify_asignar_viabilidad_error1: function(){
        alertify.log("Por favor seleccione el prediseno", "Error", 10000);      
    },
    
    alertify_asignar_viabilidad_error2: function(){
        alertify.log("Por favor seleccione el Resultado", "Error", 10000);      
    },
    
    alertify_asignar_viabilidad_error3: function(){
        alertify.log("Por favor ingrese la causa", "Error", 10000);      
    },
    
    alertify_asignar_viabilidad: function(){
        alertify.log("Asignacion exitosa", "Success", 10000);      
    },
    
    alertify_calificar_prediseno_error1: function(){
        alertify.log("Seleccione el prediseño.", "Error", 10000);      
    },
    
    alertify_calificar_prediseno: function(){
        alertify.log("Calificacion exitosa", "Success", 10000);      
    },
    
    alertify_calificar_prediseno_error: function(){
        alertify.log("No hay predisenos para calificar", "Error", 10000);      
    },
    
    alertify_modificar_idea_error: function(){
        alertify.log("Ingrese nueva descripcion por favor.", "Error", 10000);      
    },
    
    alertify_modificar_idea: function(){
        alertify.log("Modificacion de la idea exitosa", "Success", 10000);      
    }
    
};


var ms = managerScreen;