<?php
//Modelo para la gestion de los tickets
class Ticket extends Conectar
{
    //Funcion para crear e insertar un nuevo ticket en la Base de datos.
    public function insert_ticket($usu_id, $cat_id, $tick_titulo, $tick_descrip)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO tm_ticket (tick_id ,  usu_id ,  cat_id , tick_titulo, tick_descrip, tick_est, tick_fechcrea, usu_asig, fech_asig, tick_estado) VALUES ( NULL, ? , ?, ?, ?, 'Abierto' ,now(),NULL,NULL,'1');";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->bindValue(2, $cat_id);
        $sql->bindValue(3, $tick_titulo);
        $sql->bindValue(4, $tick_descrip);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    //Funcion para constultar todos los tickets generados por un usuario.
    public function listar_ticket_x_usu($usu_id){
        $conectar= parent::conexion();
        parent::set_names();
        $sql="SELECT 
            tm_ticket.tick_id,
            tm_ticket.usu_id,
            tm_ticket.cat_id,
            tm_ticket.tick_titulo,
            tm_ticket.tick_descrip,
            tm_ticket.tick_est,
            tm_ticket.tick_fechcrea,
            tm_ticket.usu_asig,
            tm_ticket.fech_asig,
            tm_usuario.usu_nombre,
            tm_usuario.usu_apellido,
            tm_categoria.cat_nombre
            FROM 
            tm_ticket
            INNER join tm_categoria on tm_ticket.cat_id = tm_categoria.cat_id
            INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
            WHERE
            tm_ticket.tick_estado = 1
            AND tm_usuario.usu_id=?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $resultado=$sql->fetchAll();
    }

    //Consultar los tickets
    public function listar_ticket()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                tm_ticket.tick_id,
                tm_ticket.usu_id,
                tm_ticket.cat_id,
                tm_ticket.tick_titulo,
                tm_ticket.tick_descrip,
                tm_ticket.tick_est,
                tm_ticket.tick_fechcrea,
                tm_ticket.usu_asig,
                tm_ticket.fech_asig,
                tm_usuario.usu_nombre,
                tm_usuario.usu_apellido,
                tm_categoria.cat_nombre
                FROM 
                tm_ticket
                INNER join tm_categoria on tm_ticket.cat_id = tm_categoria.cat_id
                INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                WHERE
                tm_ticket.tick_estado = 1";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    //Consultar el detalle de los tickets.
    public function listar_ticketdetalle_x_ticket($tick_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
                td_ticketdetalle.tickd_id,
                td_ticketdetalle.tickd_descrip,
                td_ticketdetalle.fech_crea,
                tm_usuario.usu_nombre,
                tm_usuario.usu_apellido,
                tm_usuario.usu_rol
                FROM
                td_ticketdetalle 
                INNER join tm_usuario on td_ticketdetalle.usu_id = tm_usuario.usu_id
                WHERE 
                tick_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    //Consultar tickets especificos por ID.
    public function listar_ticket_x_id($tick_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 
            tm_ticket.tick_id,
            tm_ticket.usu_id,
            tm_ticket.cat_id,
            tm_ticket.tick_titulo,
            tm_ticket.tick_descrip,
            tm_ticket.tick_est,
            tm_ticket.tick_fechcrea,
            tm_usuario.usu_nombre,
            tm_usuario.usu_apellido,
            tm_usuario.usu_correo,
            tm_categoria.cat_nombre
            FROM 
            tm_ticket
            INNER join tm_categoria on tm_ticket.cat_id = tm_categoria.cat_id
            INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
            WHERE
            tm_ticket.tick_estado = 1
            AND tm_ticket.tick_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    //Crear detalle de ticket.
    public function insert_ticketdetalle($tick_id, $usu_id, $tickd_descrip)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO td_ticketdetalle (tickd_id, tick_id, usu_id, tickd_descrip, fech_crea, est) VALUES (NULL, ?, ?, ?, now(), '1');";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->bindValue(2, $usu_id);
        $sql->bindValue(3, $tickd_descrip);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    //Actualizar ticket.
    public function uptate_ticket($tick_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE 
            tm_ticket 
            SET 
            tick_est = 'Cerrado'
            WHERE
            tick_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function uptate_asignar($tick_id, $usu_asig)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE 
            tm_ticket 
            SET 
            usu_asig = ?,
            fech_asig = now()
            WHERE
            tick_id = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_asig);
        $sql->bindValue(2, $tick_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    //Insertar aviso de actualizacion de cierre de ticket en la table detalle.
    public function insert_ticketdetalle_cerrar($tick_id, $usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO td_ticketdetalle (tickd_id, tick_id, usu_id, tickd_descrip, fech_crea, est) VALUES (NULL, ?, ?, 'Ticket cerrado', now(), '1');";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $tick_id);
        $sql->bindValue(2, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    //Calcular total de tickets para soporte
    public function get_ticket_total()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) as TOTAL FROM tm_ticket;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    //Calcular total de tickets abiertos para soporte
    public function get_ticket_totalabierto()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) as TOTAL FROM tm_ticket WHERE tick_est='Abierto';";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    //Calcular total de tickets cerrados para soporte
    public function get_ticket_totalcerrado()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT COUNT(*) as TOTAL FROM tm_ticket WHERE  tick_est='Cerrado';";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function get_ticket_grafico()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT tm_categoria.cat_nombre as nom, COUNT(*) AS total
        FROM   tm_ticket  JOIN  
            tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id  
        WHERE    
        tm_ticket.tick_estado = 1
        GROUP BY 
        tm_categoria.cat_nombre 
        ORDER BY total DESC";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
}
