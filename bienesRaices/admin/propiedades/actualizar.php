<?php
    require '../../includes/app.php';
    use App\Propiedad;
    use App\Vendedor;
    use Intervention\Image\ImageManagerStatic as Image;

    
    estaAutenticado();
    //Validar la URL que sea un ID valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if (!$id){
        header('Location: /bienesRaices/admin/index.php');
    }
    
    //Obtener los datos de la propiedad
    $propiedad = Propiedad::find($id);

    //Consulta para obtener todos los vendedores
    $vendedores = Vendedor::all();

    //Array con mensaje de errores
    $errores = Propiedad::getErrores();

    //Ejecutar el metodo despues de que el usuario envie el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST') {


        //Asignar los atributos
        $args = $_POST['propiedad'];
        $propiedad->sincronizar($args);

        //validacion
        $errores = $propiedad->validar();
        
        //subida de archivos
        //Generar un nombre unico a la imagen
        $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";
        //Revisar que el array de errores este vacio

        if($_FILES['propiedad']['tmp_name']['imagen']) {
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
            $propiedad->setImagen($nombreImagen);
        }

        if(empty($errores)) {
            // Almacenar la imagen
            if($_FILES['propiedad']['tmp_name']['imagen']) {
                $image->save(CARPETA_IMAGENES . $nombreImagen);
            }

            $propiedad->guardar();
        }
    }
    incluirTemplate('header');

?>

    <main class="contenedor seccion">
        <h1>Actualizar</h1>
        <a href="/bienesRaices/admin/index.php" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error):  ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" enctype="multipart/form-data">  <!-- enctype="multipart/form-data" SIRVE PARA QUE NOS DEJE SUBIR ARCHIVOS EN UN FORM -->
            <?php include '../../includes/templates/formulario_propiedades.php' ?>
            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
        </form>
    </main>

<?php 
    incluirTemplate('footer');
?>