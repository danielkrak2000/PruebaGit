<?php
include_once 'config.php';
include_once 'modeloUsuDB.php';
	
	 function index(){
		echo "Controlador Usuarios, Acción index";
	}
	
	 function ctlUsulogin(){
		if  ($_SERVER['REQUEST_METHOD'] == 'GET'){
			include_once 'plantilla/formAcceso.php';
		} else {
            
            $nombre = isset($_POST['user']) ? $_POST['user'] : false;
            $contraseña = isset($_POST['clave']) ? $_POST['clave'] : false;

			$usuario = ModeloUsuDB::Usulogin($nombre, $contraseña);
			
			if($_POST['orden'] == "invitado"){
				$_SESSION['invitado']=true;
				header('Location: index.php');
			}
			
			if($usuario==true){
				$_SESSION['usuario']=$nombre;
				header('Location: index.php');
			}else{
				include_once 'plantilla/formAcceso.php';
			}
        
		}
	}
	
	/*function save(){
		if(isset($_POST)){
			
			$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
			$apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false;
			$email = isset($_POST['email']) ? $_POST['email'] : false;
			$password = isset($_POST['password']) ? $_POST['password'] : false;

			$provincia = isset($_POST['provincia']) ? $_POST['provincia'] : false;
			$localidad = isset($_POST['localidad']) ? $_POST['password'] : false;
			$direccion = isset($_POST['direccion']) ? $_POST['direccion'] : false;
			
			
			if($nombre && $apellidos && $email && $password){
				$usuario = new Usuario();
				$usuario->setNombre($nombre);
				$usuario->setApellidos($apellidos);
				$usuario->setEmail($email);
				$usuario->setPassword($password);
				$usuario->setProvincia($provincia);
				$usuario->setLocalidad($localidad);
				$usuario->setDireccion($direccion);

				//$save = $usuario->save();

				if(isset($_GET['id'])){
					$id = $_GET['id'];
					$usuario->setId($id);
					$contraseñaencriptada = $usuario->getPassword();
					$contraseña = $_POST['password'];
					$newcontraseña= $_POST['newpassword'];
					$confirmcontraseña = $_POST['confirmpassword'];
					if(password_verify($contraseña, $contraseñaencriptada)){
						if($newcontraseña==$confirmcontraseña){
							$newcontraseña=password_hash($newcontraseña, PASSWORD_BCRYPT, ['cost' => 4]);
							$usuario->setPassword($newcontraseña);
							$save = $usuario->updateusuario();
						}
					}
					
				}else{
					$save = $usuario->save();
				}

				if($save){
					$_SESSION['register'] = "complete";
				}else{
					$_SESSION['register'] = "failed";
				}
			}else{
				$_SESSION['register'] = "failed";
			}
		}else{
			$_SESSION['register'] = "failed";
		}
		header("Location:".base_url.'usuario/registro');
	}
	
	 function login(){
		if(isset($_POST)){
			// Identificar al usuario
			// Consulta a la base de datos
			$usuario = new Usuario();
			$usuario->setEmail($_POST['email']);
			$usuario->setPassword($_POST['password']);
			
			$identity = $usuario->login();
			
			if($identity && is_object($identity)){
				$_SESSION['identity'] = $identity;
				
				if($identity->rol == 'admin'){
					$_SESSION['admin'] = true;
				}
				
			}else{
				$_SESSION['error_login'] = 'Identificación fallida !!';
			}
		
		}
		header("Location:".base_url);
	}
	
	 function logout(){
		if(isset($_SESSION['identity'])){
			unset($_SESSION['identity']);
		}
		
		if(isset($_SESSION['admin'])){
			unset($_SESSION['admin']);
		}
		
		header("Location:".base_url);
	}
	
	 function verusuarios(){
			
		Utils::isAdmin();
		
		$usuario = new Usuario();
		$pedido = new Pedido();

		$usuarios = $usuario->getallusuarios();
		
		require_once 'views/usuario/listausuarios.php';
	}

	 function verusuario(){
		
		if(isset($_GET['id'])){
			$usuario = new Usuario();
			$pedido = new Pedido();
			$id = $_GET['id'];
			$usuario->setId($id);
			$edit=true;
			$usu = $usuario->getOne();
			require_once 'views/usuario/modificarusuario.php';
		}else{
			header('Location:'.base_url.'usuario/listausuarios');
		}
		
	}

	 function eliminarusuario(){
		Utils::isAdmin();
		
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			$usuario = new Usuario();
			$usuario->setId($id);
			
			$delete = $usuario->deleteusuario();
			if($delete){
				$_SESSION['delete'] = 'complete';
			}else{
				$_SESSION['delete'] = 'failed';
			}
		}else{
			$_SESSION['delete'] = 'failed';
		}
		
		header('Location:'.base_url.'usuario/verusuarios');
		
		//require_once 'views/usuario/listausuarios.php';
	}

	 function editar(){
		Utils::isAdmin();

		if(isset($_GET['id'])){
			$id = $_GET['id'];
			$usuario = new Usuario();
			$edit=true;//Preguntar para que sive este boolean
			$usuario->setId($id);
			$usu = $usuario->getOne();
			//$update=$usuario->updateusuario();
			//var_dump($usu);
			require_once 'views/usuario/modificarusuario.php';
		}else{
			header('Location:'.base_url.'usuario/listausuarios');
		}
		
	}*/
    