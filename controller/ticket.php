<?php

//se importan los modulos requeridos, la conexion a la bd y el modelo de categoria.
require_once("../config/conexion.php");
require_once("../models/Ticket.php");

$ticket = new Ticket();

require_once("../models/Usuario.php");

$usuario = new Usuario();



switch ($_GET["op"]) {

    //Ejecutar funcion de insertar nuevo ticket
    case "insert":
        $datos = $ticket->insert_ticket($_POST["usu_id"], $_POST["cat_id"], $_POST["tick_titulo"], $_POST["tick_descrip"]);
    break;
    //Ejecutar funcion de actializar nuevo ticket
    case "update":
        $datos = $ticket->uptate_ticket($_POST["tick_id"]);
        $datos = $ticket->insert_ticketdetalle_cerrar($_POST["tick_id"], $_POST["usu_id"]);
    break;
    //Ejecitar funcion de asignar ticket a un soporte
    case "asignar":
        $datos = $ticket->uptate_asignar($_POST["tick_id"], $_POST["usu_asig"]);
    break;
    //Ejecutar funcion de consultar tickets por usuario  
    case "listar_x_usu":
        $datos = $ticket->listar_ticket_x_usu($_POST["usu_id"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["tick_id"];
            $sub_array[] = $row["cat_nombre"];
            $sub_array[] = $row["tick_titulo"];

            if ($row["tick_est"] == "Abierto") {
                $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
            } else {
                $sub_array[] = '<span class="label label-pill label-danger">Cerrado</span>';
            }

            $sub_array[] = date("d/m/Y H:i:s", strtotime($row["tick_fechcrea"]));

            //Validar fecha de asignacion de ticket
            if ( $row["fech_asig"]==null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            }else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_asig"]));
            }

            //Validar Usuario asignado al ticket.
            if ( $row["usu_asig"]==null) {
                $sub_array[] = '<span class="label label-pill label-warning">Sin Asignar</span>';
            }else {
                $datos1=$usuario->get_usuario_x_id($row["usu_asig"]);
                foreach($datos1 as $row1){
                    $sub_array[] = '<span class="label label-pill label-success"> '. $row1["usu_nombre"] .' </span>';
                }
            }


            $sub_array[] = '<button type="button" onClick="handleClick(' . $row["tick_id"] . ');"  id="' . $row["tick_id"] . '" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
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
     //Ejecutar funcion de monstrar tickets 
    case "listar":
        $datos = $ticket->listar_ticket();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["tick_id"];
            $sub_array[] = $row["cat_nombre"];
            $sub_array[] = $row["tick_titulo"];

            if ($row["tick_est"] == "Abierto") {
                $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
            } else {
                $sub_array[] = '<span class="label label-pill label-danger">Cerrado</span>';
            }

            $sub_array[] = date("d/m/Y H:i:s", strtotime($row["tick_fechcrea"]));

             //Validar fecha de asignacion de ticket
            if ( $row["fech_asig"]==null) {
                $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
            }else {
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_asig"]));
            }

            //Validar Usuario asignado al ticket.
            if ( $row["usu_asig"]==null) {
                $sub_array[] = '<a onClick="asignar('.$row["tick_id"].');"><span class="label label-pill label-warning">Sin Asignar</span></a>';
            }else {
                $datos1=$usuario->get_usuario_x_id($row["usu_asig"]);
                foreach($datos1 as $row1){
                    $sub_array[] = '<span class="label label-pill label-success"> '. $row1["usu_nombre"] .' </span>';
                }
            }

            $sub_array[] = '<button type="button" onClick="handleClick(' . $row["tick_id"] . ');"  id="' . $row["tick_id"] . '" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
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
     //Ejecutar funcion de consultar los detalles del tickets 
    case "listardetalle":
        $datos = $ticket->listar_ticketdetalle_x_ticket($_POST["tick_id"]);
        ?>
            <?php
            foreach ($datos as $row) {
            ?>
                <article class="activity-line-item box-typical">
                    <div class="activity-line-date">
                        <?php echo date("d/m/Y", strtotime($row["fech_crea"])); ?>
                    </div>
                    <header class="activity-line-item-header">
                        <div class="activity-line-item-user">
                            <div class="activity-line-item-user-photo">
                                <a href="#">
                                <img src="../../public/img/<?php echo $row["usu_rol"]?>.png" alt="">
                                </a>
                            </div>
                            <div class="activity-line-item-user-name"> <?php echo $row['usu_nombre'] . ' ' . $row['usu_apellido']; ?></div>
                            <div class="activity-line-item-user-status">
                                <?php
                                if ($row['usu_rol'] == 1) {
                                    echo 'Usuario';
                                } else {
                                    echo 'Soporte';
                                }
                                ?>
                            </div>
                        </div>
                    </header>
                    <div class="activity-line-action-list">
                        <section class="activity-line-action">
                            <div class="time"> <?php echo date("H:i:s", strtotime($row["fech_crea"])); ?></div>
                            <div class="cont">
                                <div class="cont-in">
                                    <p> <?php echo $row['tickd_descrip']; ?></p>
                                </div>
                            </div>
                        </section>
                    </div>
                </article>
            <?php
            }
            ?>

            <?php
    break;
    //Ejecutar funcion de mostrar los tickes por ID
    case "mostrar":
         $datos=$ticket->listar_ticket_x_id($_POST["tick_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["tick_id"] = $row["tick_id"];
                    $output["usu_id"] = $row["usu_id"];
                    $output["cat_id"] = $row["cat_id"];

                    $output["tick_titulo"] = $row["tick_titulo"];
                    $output["tick_descrip"] = $row["tick_descrip"];

                    if ($row["tick_est"]=="Abierto"){
                        $output["tick_est"] = '<span class="label label-pill label-success">Abierto</span>';
                    }else{
                        $output["tick_est"] = '<span class="label label-pill label-danger">Cerrado</span>';
                    }

                    $output["tick_est_texto"] = $row["tick_est"];

                    $output["tick_estado_texto"] = $row["tick_est"];

                    $output["tick_fechcrea"] = date("d/m/Y H:i:s", strtotime($row["tick_fechcrea"]));
                    $output["usu_nombre"] = $row["usu_nombre"];
                    $output["usu_apellido"] = $row["usu_apellido"];
                    $output["cat_nombre"] = $row["cat_nombre"];
                }
                echo json_encode($output);
            }   
    break;
     //Ejecutar funcion de insertar detalle de los tickets
    case "insertdetalle":
            $datos = $ticket->insert_ticketdetalle($_POST["tick_id"], $_POST["usu_id"], $_POST["tickd_descrip"]);
    break;

     //Ejecutar la funcion de consultar el total de tickets 
     case "total":
        $datos=$ticket->get_ticket_total();
        
        if(is_array($datos)==true and count($datos)>0){
            foreach($datos as $row)
            {
                $output["TOTAL"] = $row["TOTAL"]; 
            }
            echo json_encode($output);
        }   
    break;
    //Ejecutar la funcion de consultar el total de tickets abiertos de todos los usuario
    case "totalabierto":
        $datos=$ticket->get_ticket_totalabierto();
        
        if(is_array($datos)==true and count($datos)>0){
            foreach($datos as $row)
            {
                $output["TOTAL"] = $row["TOTAL"]; 
            }
            echo json_encode($output);
        }   
    break;
    //Ejecutar la funcion de consultar el total de tickets cerrados de todos los usuario
    case "totalcerrado":
        $datos=$ticket->get_ticket_totalcerrado();
        
        if(is_array($datos)==true and count($datos)>0){
            foreach($datos as $row)
            {
                $output["TOTAL"] = $row["TOTAL"]; 
            }
            echo json_encode($output);
        }   
    break;
    //Ejecutar la funcion de visualizacion de grafico total
    case "grafico";
            $datos=$ticket->get_ticket_grafico();  
            echo json_encode($datos);
        break;


}
