<?php 
    require '../../includes/app.php';
    use App\Vendedor;
    estaAutenticado();


    //Validar que sea un ID valido

    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if (!$id){
        header('Location: /bienesRaices/admin/index.php');
    }

    //Obtener el arreglo del vendedor
    $vendedor = Vendedor::find($id);
    $errores = Vendedor::getErrores();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        //Asignar los atributos
        $args = $_POST['vendedor'];
        $vendedor->sincronizar($args);

        //validacion
        $errores = $vendedor->validar();

        if(empty($errores)) {
            $vendedor->guardar();
        }
    }

    incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Actualizar Vendedor</h1>
    <a href="/bienesRaices/admin/index.php" class="boton boton-verde">Volver</a>

    <?php foreach($errores as $error):  ?>
    <div class="alerta error">
        <?php echo $error; ?>
    </div>
    <?php endforeach; ?>

    <form class="formulario" method="POST" > 
        <?php include '../../includes/templates/formulario_vendedores.php' ?>

        <input type="submit" value="Actualizar Vendedor" class="boton boton-verde">
    </form>
</main>

<?php 
incluirTemplate('footer');
?>