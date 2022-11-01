<?php 
    require 'includes/app.php';
    $db = conectarDB();
    //Autenticar el usuario

    $errores = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";

        $email = mysqli_real_escape_string($db ,filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
        $password = mysqli_real_escape_string($db, $_POST['password']);

        if(!$email){
            $errores[] = "El email es obligatorio o no es valido";
        }

        if(!$password){
            $errores[] = "El password es obligatorio";
        }

        // echo "<pre>";
        // var_dump($errores);
        // echo "</pre>";

        if(empty($errores)){
            //revisar si el usuario existe.
            $query = "SELECT * FROM usuarios WHERE email = '${email}'";
            $resultado = mysqli_query($db, $query);
            //var_dump($resultado);

            if( $resultado->num_rows ){
                //revisar si el password es correcto
                $usuario = mysqli_fetch_assoc($resultado);
                $auth = password_verify($password, $usuario['password']);
                if($auth){
                    //El usuario es autenticado
                    session_start();
                    //Llenar el arreglo de la sesion
                    $_SESSION['usuario'] = $usuario['email'];
                    $_SESSION['login'] = true;
                    // echo "<pre>";
                    // var_dump($_SESSION);
                    // echo "</pre>";
                    header('Location: /bienesRaices/admin/index.php');
                }else{
                    $errores[] = "La contraseña es incorrecta";
                }
            }else{
                $errores[] = "El usuario no existe";
            }
        }
    };


    //Incluye el header
    incluirTemplate('header');

?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesión</h1>

        <?php foreach($errores as $error):?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach;?>

        <form method="POST" class="formulario">
            <fieldset>
                <legend>Email y Contraseña</legend>

                <label for="email">E-mail</label>
                <input type="email" name="email" placeholder="Tu Email" id="email">

                <label for="password">Contraseña</label>
                <input type="password" name="password" placeholder="Tu contraseña" id="password">

            </fieldset>

            <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
        </form>
    </main>

<?php 
    incluirTemplate('footer');
?>