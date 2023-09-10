<?php
    //se importan los modulos requeridos, la conexion a la bd y el modelo de categoria.
    require_once("../config/conexion.php");
    require_once("../models/Usuario.php");

    $usuario = new Usuario();

    switch($_GET["op"]){
        //Ejecutar funcion de insertar y editar usuarios.
        case "guardaryeditar":
        
            if (empty($_POST["usu_id"])) {

                $usuario -> insert_usuario($_POST["usu_nombre"],$_POST["usu_apellido"],$_POST["usu_correo"],$_POST["usu_password"],$_POST["usu_rol"]);

            }else{
                $usuario->update_usuario($_POST["usu_id"],$_POST["usu_nombre"],$_POST["usu_apellido"],$_POST["usu_correo"],$_POST["usu_password"],$_POST["usu_rol"]);
            }
           
        break;
        //Ejecutar la funcion y listar los usuarios.
        case "listar":
            $datos = $usuario->get_usuario();
            $data = array();
            foreach ($datos as $row) {
                $sub_array = array();
                $sub_array[] = $row["usu_nombre"];
                $sub_array[] = $row["usu_apellido"];
                $sub_array[] = $row["usu_correo"];

                //Validacion de tipo de usuario que se esta loguiando.
                if ($row["usu_rol"] == "1") {
                    $sub_array[] = '<span class="label label-pill label-primary">Usuario</span>';
                } else {
                    $sub_array[] = '<span class="label label-pill label-success">Soporte</span>';
                }
    
               //imprimir botones de editar y elimnar para cada usuario.
                $sub_array[] = '<button type="button" onClick="editar(' . $row["usu_id"] . ');"  id="' . $row["usu_id"] . '" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["usu_id"].');"  id="'.$row["usu_id"].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
                $data[] = $sub_array;
            }
    
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData" => $data
            );
            echo json_encode($results);
    
        break;
        //Ejecutar funcion de eliminar usuario.
        case "eliminar":
            $usuario->delete_usuario($_POST["usu_id"]);
        break;
        //Ejecutar funcion de mostrar usuario por ID
        case "mostrar":
            $datos=$usuario->get_usuario_x_id($_POST["usu_id"]);  
               if(is_array($datos)==true and count($datos)>0){
                   foreach($datos as $row)
                   {
                       $output["usu_id"] = $row["usu_id"];
                       $output["usu_nombre"] = $row["usu_nombre"];
                       $output["usu_apellido"] = $row["usu_apellido"];
                       $output["usu_correo"] = $row["usu_correo"];
                       $output["usu_password"] = $row["usu_password"];
                       $output["usu_rol"] = $row["usu_rol"];

                   }
                   echo json_encode($output);
               }   
        break;
            //Ejecutar la funcion de consultar el total de tickets de un usuario
        case "total":
            $datos=$usuario->get_usuario_total_x_id($_POST["usu_id"]);
            
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"]; 
                }
                echo json_encode($output);
            }   
        break;
        
        case "totalabierto":
            $datos=$usuario->get_usuario_totalabierto_x_id($_POST["usu_id"]);
            
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"]; 
                }
                echo json_encode($output);
            }   
        break;

        case "totalcerrado":
            $datos=$usuario->get_usuario_totalcerrado_x_id($_POST["usu_id"]);
            
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"]; 
                }
                echo json_encode($output);
            }   
        break;

        case "grafico";
            $datos=$usuario->get_usuario_grafico($_POST["usu_id"]);  
            echo json_encode($datos);
        break;
    }

?>