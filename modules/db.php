<?php

/**
 * Project:     Framework G - G Light
 * File:        db.php
 * 
 * For questions, help, comments, discussion, etc., please join to the
 * website www.frameworkg.com
 * 
 * @link http://www.frameworkg.com/
 * @copyright 2013-02-07
 * @author Group Framework G  <info at frameworkg dot com>
 * @version 1.2
 */
class db {

    var $server = C_DB_SERVER; //DB server
    var $user = C_DB_USER; //DB user
    var $pass = C_DB_PASS; //DB password
    var $db = dbdcps; //DB database name
    var $limit = C_DB_LIMIT; //DB limit of elements by page
    var $cn;
    var $numpages;

    public function db() {
        
    }

    //connect to database
    public function connect() {
        $this->cn = mysqli_connect($this->server, $this->user, $this->pass);
        if (!$this->cn) {
            die("Failed connection to the database: " . mysqli_error($this->cn));
        }
        if (!mysqli_select_db($this->cn, $this->db)) {
            die("Unable to communicate with the database $db: " . mysqli_error($this->cn));
        }
        mysqli_query($this->cn, "SET NAMES utf8");
    }

    //function for doing multiple queries
    public function do_operation($operation, $class = NULL) {
        $result = mysqli_query($this->cn, $operation);
        if (!$result) {
            $this->throw_sql_exception($class);
        }
    }

    //function for obtain data from db in object form
    private function get_data($operation) {
        $data = array();
        $result = mysqli_query($this->cn, $operation) or die(mysqli_error($this->cn));
        while ($row = mysqli_fetch_object($result)) {
            array_push($data, $row);
        }
        return $data;
    }

    //throw exception to web document
    private function throw_sql_exception($class) {
        $errno = mysqli_errno($this->cn);
        $error = mysqli_error($this->cn);
        $msg = $error . "<br /><br /><b>Error number:</b> " . $errno;
        throw new Exception($msg);
    }

    //for avoid sql injections, this functions cleans the variables
    private function escape_string(&$data) {
        if (is_object($data)) {
            foreach ($data->metadata() as $key => $attribute) {
                if (!is_empty($data->get($key))) {
                    $data->set($key, mysqli_real_escape_string($this->cn, $data->get($key)));
                }
            }
        } else if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (!is_array($value)) {
                    $data[$key] = mysqli_real_escape_string($this->cn, $value);
                }
            }
        }
    }

    //function for add data to db
    public function insert($options, $object) {
        switch ($options['lvl1']) {
            case "user":
                switch ($options['lvl2']) {
                    case "normal":
                        //
                        break;
                }
                break;

            case "calificacion":
                switch ($options['lvl2']) {
                    case "normal":
                        $this->escape_string($object);
                        $miembro = $object->get('miembro');
                        $valor = $object->get('valor');
                        $nombre = $object->get('idea');
                        $this->do_operation("INSERT INTO calificacion (miembro, valor, idea) VALUES ('$miembro','$valor','$nombre');");
                        break;
                }
                break;

            case "dispositivo":
                switch ($options['lvl2']) {
                    case "normal":
                        $codigo = mysqli_real_escape_string($this->cn, $object->get('codigo'));
                        $costo = mysqli_real_escape_string($this->cn, $object->get('costo'));
                        $funcion = mysqli_real_escape_string($this->cn, ($object->get('funcion')));
                        $prediseno = mysqli_real_escape_string($this->cn, ($object->get('prediseno')));
                        $this->do_operation("INSERT INTO dispositivo (codigo, costo, funcion, prediseno) VALUES ('$codigo', '$costo', '$funcion','$prediseno');");
                        break;
                }
                break;
            case "software":
                switch ($options['lvl2']) {
                    case "normal":
                        $codigo = mysqli_real_escape_string($this->cn, $object->get('codigo'));
                        $lenguaje = mysqli_real_escape_string($this->cn, $object->get('lenguaje'));
                        $prediseno = mysqli_real_escape_string($this->cn, ($object->get('prediseno')));
                        $this->do_operation("INSERT INTO software (codigo, lenguaje, prediseno) VALUES ('$codigo', '$lenguaje','$prediseno');");
                        break;
                }
                break;


            case "diseno":
                switch ($options['lvl2']) {
                    case "normal":

                        $codigo = mysqli_real_escape_string($this->cn, $object->get('codigo'));
                        $imagen = mysqli_real_escape_string($this->cn, $object->get('imagen'));
                        $dispositivo = mysqli_real_escape_string($this->cn, ($object->get('dispositivo')));
                        $software = mysqli_real_escape_string($this->cn, ($object->get('software')));
                        $this->do_operation("INSERT INTO diseno (codigo, imagen, dispositivo, software) VALUES ('$codigo', '$imagen', '$dispositivo', '$software');");
                        break;
                }
                break;


            case "prediseno":
                switch ($options['lvl2']) {
                    case "insert":
                        $code = mysqli_real_escape_string($this->cn, $object->get('codigo'));
                        $idea = mysqli_real_escape_string($this->cn, $object->get(idea));
                        // $miembro = mysqli_real_escape_string($this->cn, $object->get('miembro'));

                        $miembro = $_SESSION['miembro'];

                        if (isset($miembro)) {
                            $this->do_operation("INSERT INTO `dbdcps`.`prediseno`(`codigo`,`idea`,`especialista` )VALUES('$code','$idea','$miembro');");
                            break;
                        }
                }
                break;


            case "idea":
                switch ($options['lvl2']) {
                    case "normal":
                        $nombre = mysqli_real_escape_string($this->cn, $object->get('nombre'));
                        $descripcion = mysqli_real_escape_string($this->cn, $object->get('descripcion'));
                        $etapa = "Por revisar";
                        $necesidad = mysqli_real_escape_string($this->cn, $object->get('necesidad'));
                        $miembro = mysqli_real_escape_string($this->cn, $object->get('miembro'));
                        $cliente = mysqli_real_escape_string($this->cn, $object->get('cliente'));
                        $this->do_operation("INSERT INTO idea (nombre, descripcion, etapa, necesidad, miembro, cliente) VALUES ('$nombre', '$descripcion', '$etapa', '$necesidad', $miembro, $cliente);");
                        break;
                }
                break;


            case "reunion":
                switch ($options['lvl2']) {
                    case "normal":
                        $this->escape_string($object);
                        $codigo = $object->get('codigo');
                        $fecha = $object->get('fecha');
                        $this->do_operation("INSERT INTO reunion VALUES('$codigo','$fecha');");
                        break;
                }
                break;

            case "viabilidad":
                switch ($options['lvl2']) {
                    case "normal":
                        $cod = mysqli_real_escape_string($this->cn, $object->get('codigo'));
                        $prediseno = mysqli_real_escape_string($this->cn, $object->get('prediseno'));
                        $resultado = mysqli_real_escape_string($this->cn, $object->get('resultado'));
                        $causa = mysqli_real_escape_string($this->cn, $object->get('causa'));
                        $analista = mysqli_real_escape_string($this->cn, $object->get('analista'));
                        $this->do_operation("INSERT INTO viabilidad (codigo, resultado, causa, analista, prediseno) VALUES ('$cod', '$resultado', '$causa', '$analista', '$prediseno');");
                        break;
                }
                break;

            default:
                break;
        }
    }

    //function for edit data from db
    public function update($options, $object) {
        switch ($options['lvl1']) {
            case "user":
                switch ($options['lvl2']) {
                    case "normal":
                        //
                        break;
                }
                break;
            case "idea":
                switch ($options['lvl2']) {
                    case "normal":
                        $nombre=$_SESSION['nombre'];
                        $this->escape_string($object);
                        $descripcion = $object->get('descripcion');
                        $miembro = $object->get('miembro');
                        $etapa = $object->get('etapa');
                        $necesidad = $object->get('necesidad');
                        $this->do_operation("UPDATE idea SET descripcion = '$descripcion', etapa = '$etapa',necesidad = '$necesidad', miembro='$miembro' WHERE nombre = '$nombre';");
                        break;
                    case "reunion":
                        $this->escape_string($object);
                        $nombre = $object->get('nombre');
                        $reunion = $object->get('reunion');
                        $this->do_operation("UPDATE idea SET reunion = '$reunion' WHERE nombre = '$nombre';");
                        break;

                    case "modificable":
                        $this->escape_string($object);
                        $nombre = $object->get('nombre');
                        $etapa = $object->get('etapa');

                        $this->do_operation("UPDATE idea SET etapa = '$etapa' WHERE nombre = '$nombre';");
                        break;
                }
                break;
            case "prediseno":
                switch ($options['lvl2']) {
                    case "normal":
                        $cod = mysqli_real_escape_string($this->cn, $object->get('codigo'));
                        $esp = mysqli_real_escape_string($this->cn, $object->get('especialista'));
                        $resultado = mysqli_real_escape_string($this->cn, $object->get('resultado'));
                        $gerente = mysqli_real_escape_string($this->cn, $object->get('gerente'));
                        $analista = mysqli_real_escape_string($this->cn, $object->get('analista'));
                        $this->do_operation("UPDATE prediseno SET codigo='$cod', resultado='$resultado', especialista='$esp', gerente='$gerente', analista='$analista' WHERE cod='$cod';");
                        break;

                    case "calificar":
                        $cod = mysqli_real_escape_string($this->cn, $object->get('codigo'));
                        $resultado = mysqli_real_escape_string($this->cn, $object->get('resultado'));
                        $gerente = mysqli_real_escape_string($this->cn, $object->get('gerente'));
                        $this->do_operation("UPDATE prediseno SET resultado='$resultado', gerente='$gerente' WHERE codigo='$cod';");
                        break;
                }
                break;
            case "diseno":
                switch ($options['lvl2']) {
                    case "revision":
                        $cod = mysqli_real_escape_string($this->cn, $object->get('codigo'));
                        $evaluacion = mysqli_real_escape_string($this->cn, $object->get('evaluacion'));
                        $this->do_operation("UPDATE diseno SET evaluacion='$evaluacion' WHERE codigo='$cod';");
                        break;
                }
                break;
            default: break;
        }
    }

    //function for delete data from db
    public function delete($options, $object) {
        switch ($options['lvl1']) {
            case "user":
                switch ($options['lvl2']) {
                    case "normal":
                        //
                        break;
                }
                break;

            default: break;
        }
    }

    //function that returns an array with data from a operation
    public function select($option, $data) {
        $info = array();
        switch ($option['lvl1']) {
            case "user":
                switch ($option['lvl2']) {
                    case "all":
                        //
                        break;
                }
                break;
            case "necesidad":
                switch ($option['lvl2']) {
                    case "all" :
                        $info = $this->get_data("SELECT * FROM necesidad;");
                        break;
                }
                break;


            case "reunion":
                switch ($option['lvl2']) {
                    case "all":
                        $info = $this->get_data("SELECT r.*, r.id as 'id de la reunion', i.nombre as 'Nombre_de_la_idea' ,r.fecha as Fecha,  i.nombre As 
'Nombre_de_la_idea' FROM idea i, reunion r WHERE i.nombre=r.idea;");
                        break;
                    case "alll":
                        $info = $this->get_data("select * from reunion;");
                        break;
                }
                break;

            case "idea":
                switch ($option['lvl2']) {
                    case "all":
                        $info = $this->get_data("select * from idea;");
                        break;
                    case "one":
                        $nombre = mysqli_real_escape_string($this->cn, $data['nombre']);
                        $info = $this->get_data("SELECT * FROM idea WHERE nombre = '$nombre';");
                        break;
                    case "Por revisar":
                        $info = $this->get_data("SELECT i.* FROM idea i WHERE i.etapa = 'Por revisar' OR i.etapa = 'Modificada';");
                        break;
                    case "reunion":
                        $info = $this->get_data("SELECT i.* FROM idea i, reunion r WHERE r.fecha=CURDATE() and i.reunion=r.codigo;");
                        break;
                    case "modificables":
                        $info = $this->get_data("SELECT i.* FROM idea i WHERE i.etapa = 'Modificable';");
                        break;
                }
                break;

            case "prediseno":
                switch ($option['lvl2']) {
                    case "todospredisenos":

                        $info = $this->get_data("SELECT * FROM prediseno;");
                        break;

                    case "all":
                        $code = mysqli_real_escape_string($this->cn, $data['codigo']);

                        $info = $this->get_data("SELECT * FROM `prediseno` where `Codigo`='$code';");
                        break;

                    case "sinviabilidad":
                        $info = $this->get_data("SELECT t.codigo, t.idea FROM prediseno AS t WHERE t.codigo not in(SELECT t1.codigo
                                            FROM prediseno AS t1 INNER JOIN viabilidad AS t2 ON t1.codigo = t2.prediseno);");
                        break;
                }
                break;

            case "empleado":
                switch ($option['lvl2']) {
                    case "all":
                        $info = $this->get_data("select * from login;");
                        break;
                    case "uno":
                        $i = mysqli_real_escape_string($this->cn, $data['cedula']);
                        $info = $this->get_data("select * from login where cedula='$i';");
                        break;
                    case "validar":
                        $ced = mysqli_real_escape_string($this->cn, $data['cedula']);

                        $info = $this->get_data("select * from empleado where cedula='$ced';");
                        break;
                }
                break;

            case "cliente":
                switch ($option['lvl2']) {

                    case "validar":
                        $nom = mysqli_real_escape_string($this->cn, $data['nombre']);
                        $contra = mysqli_real_escape_string($this->cn, $data['identificacion']);
                        $info = $this->get_data("SELECT * FROM cliente where nombre ='$nom' and identificacion='$contra';");
                        break;
                }
                break;

            case "dispositivo":
                switch ($option['lvl2']) {
                    case "all" :
                        $info = $this->get_data("SELECT * FROM dispositivo;");
                        break;
                    case "detalle" :
                        $info = $this->get_data("SELECT t1.* FROM dispositivo AS t1 INNER JOIN viabilidad AS t2 ON t1.prediseno = t2.prediseno ;");

                        break;
                }
                break;

            case "software":
                switch ($option['lvl2']) {
                    case "all" :
                        $info = $this->get_data("SELECT * FROM software;");
                        break;
                    case "detalle" :
                        $info = $this->get_data("SELECT t1.* FROM software AS t1 INNER JOIN viabilidad AS t2 ON t1.prediseno = t2.prediseno;");
                        break;
                }
                break;

            case "viabilidad":
                switch ($option['lvl2']) {
                    case "all":
                        $info = $this->get_data("select * from viabilidad;");
                        break;
                    case "uno":
                        $i = mysqli_real_escape_string($this->cn, $data['cedula']);
                        $info = $this->get_data("select * from viabilidad where cedula='$i';");
                        break;
                }
                break;
            case "diseno":
                switch ($option['lvl2']) {
                    case "all" :
                        $info = $this->get_data("SELECT * FROM diseno;");
                        break;
                }
                break;

            case "calificacion":
                switch ($option['lvl2']) {
                    case "all" :
                        $info = $this->get_data("SELECT * FROM calificacion;");
                        break;
                    case "prom":
                        $info = $this->get_data("SELECT id, idea, miembro, AVG(valor) AS valor FROM calificacion GROUP BY idea;");
                        break;
                }
                break;
            default: break;
        }
        return $info;
    }

    //close the db connection
    public function close() {
        if ($this->cn) {
            mysqli_close($this->cn);
        }
    }

}

?>