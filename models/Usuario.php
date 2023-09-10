<?php
//Modelo para el CRUD de los usuarios.
    class Usuario extends Conectar{
        //VALIDACION DE INICIO DE SESION DEL USUARIO EN EL SISTEMA.
        public function login(){
            $conectar=parent::conexion();
            parent::set_names();
            if(isset($_POST["enviar"])){
                $correo = $_POST["usu_correo"];
                $password = $_POST["usu_password"];
                $rol = $_POST["usu_rol"];
                if(empty($correo) and empty($password)){
                    header("Location:".conectar::ruta()."index.php?m=2");
					exit();
                }else{
                    $sql = "SELECT * FROM tm_usuario WHERE usu_correo=? and usu_password=? and usu_rol=? and usu_estado=1";
                    $stmt=$conectar->prepare($sql);
                    $stmt->bindValue(1, $correo);
                    $stmt->bindValue(2, $password);
                    $stmt->bindValue(3, $rol);
                    $stmt->execute();
                    $resultado = $stmt->fetch();
                    if (is_array($resultado) and count($resultado)>0){
                        $_SESSION["usu_id"]=$resultado["usu_id"];
                        $_SESSION["usu_nombre"]=$resultado["usu_nombre"];
                        $_SESSION["usu_apellido"]=$resultado["usu_apellido"];
                        $_SESSION["usu_rol"]=$resultado["usu_rol"];
                        header("Location:".Conectar::ruta()."view/Home/");
                        exit(); 
                    }else{
                        header("Location:".Conectar::ruta()."index.php?m=1");
                        exit();
                    }
                }
            }
        }

        //Crear usuario
        public function insert_usuario($usu_nombre,$usu_apellido,$usu_correo,$usu_password,$usu_rol){

            $conectar=parent::conexion();
            parent::set_names();
            $sql = "INSERT INTO tm_usuario (usu_id, usu_nombre, usu_apellido, usu_correo, usu_password, usu_rol, usu_fechacreacion,usu_fechmodi, usu_estado, usu_fechelim) VALUES (NULL, ?, ?, ?, ?, ?, now(),NULL,'1',NULL);";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_nombre);
            $sql->bindValue(2, $usu_apellido);
            $sql->bindValue(3, $usu_correo);
            $sql->bindValue(4, $usu_password);
            $sql->bindValue(5, $usu_rol);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        
        }

        //Actualizar usuario
        public function update_usuario($usu_id, $usu_nombre,$usu_apellido,$usu_correo,$usu_password,$usu_rol){

            $conectar=parent::conexion();
            parent::set_names();
            $sql = "UPDATE tm_usuario SET 
            usu_nombre= ?,
            usu_apellido = ?,
            usu_correo = ?,
            usu_password = ?,
            usu_rol = ?
            WHERE 
            usu_id = ?";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_nombre);
            $sql->bindValue(2, $usu_apellido);
            $sql->bindValue(3, $usu_correo);
            $sql->bindValue(4, $usu_password);
            $sql->bindValue(5, $usu_rol);
            $sql->bindValue(6, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        
        }

        //Eliminar usuario
        public function delete_usuario($usu_id){
            $conectar=parent::conexion();
            parent::set_names();
            $sql = "UPDATE tm_usuario SET usu_estado = '0', usu_fechelim = now() WHERE usu_id =? ";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        //Consultar todos los usuarios
        public function get_usuario(){
            $conectar=parent::conexion();
            parent::set_names();
            $sql = "SELECT * FROM tm_usuario WHERE usu_estado = '1'";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        //Consultar un usuario en especifico por id.
        public function get_usuario_x_id($usu_id){
            $conectar=parent::conexion();
            parent::set_names();
            $sql = "SELECT * FROM tm_usuario WHERE usu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        //Calcular total de tickets por usuario
        public function get_usuario_total_x_id($usu_id){
            $conectar=parent::conexion();
            parent::set_names();
            $sql = "SELECT COUNT(*) as TOTAL FROM tm_ticket WHERE usu_id = ?;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        //Calcular total de tickets abiertos por usuario
        public function get_usuario_totalabierto_x_id($usu_id){
            $conectar=parent::conexion();
            parent::set_names();
            $sql = "SELECT COUNT(*) as TOTAL FROM tm_ticket WHERE usu_id = ? AND tick_est='Abierto';";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        //Calcular total de tickets cerrados por usuario
        public function get_usuario_totalcerrado_x_id($usu_id){
            $conectar=parent::conexion();
            parent::set_names();
            $sql = "SELECT COUNT(*) as TOTAL FROM tm_ticket WHERE usu_id = ? AND tick_est='Cerrado';";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }


        public function get_usuario_grafico($usu_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
            $sql = "SELECT tm_categoria.cat_nombre as nom, COUNT(*) AS total
            FROM   tm_ticket  JOIN  
                tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id  
            WHERE    
            tm_ticket.tick_estado = 1
            AND tm_ticket.usu_id = ?
            GROUP BY 
            tm_categoria.cat_nombre 
            ORDER BY total DESC";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_id);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    }
?>