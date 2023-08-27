<?php

    //se importan los modulos requeridos, la conexion a la bd y el modelo de categoria.
    require_once("../config/conexion.php");
    require_once("../models/Categoria.php");

    $categoria = new Categoria();

    switch($_GET["op"]){
        case "combo":

            //en la variable datos se almacena lo que se solicita de get_categoria.
            $datos = $categoria->get_categoria();
            //Se valida que si haya informacion almacenada en la variable.
            if(is_array($datos)==true and count($datos)>0){
                //Se recorre y se imprime la informacion almacenada.
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['cat_id']."'>".$row['cat_nombre']."</option>";
                }
                echo $html;
            }
        break;
    }

?>