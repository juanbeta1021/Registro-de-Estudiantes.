<?php
// Función para cargar los contactos desde el archivo JSON
function cargarContactos() {
    $archivo = 'contacts.json';
    if (file_exists($archivo)) {
        $contenido = file_get_contents($archivo);
        return json_decode($contenido, true); // Decodifica el JSON en un array asociativo
    }
    return []; // Si el archivo no existe, devuelve un array vacío
}

// Función para guardar los contactos en el archivo JSON
function guardarContactos($contactos) {
    $archivo = 'contacts.json';
    $contenido = json_encode($contactos, JSON_PRETTY_PRINT); // Convierte el array a JSON
    file_put_contents($archivo, $contenido); // Guarda el JSON en el archivo
}

// Manejo de acciones según la opción seleccionada
$contactos = cargarContactos(); // Cargamos los contactos al iniciar
$mensaje = ''; // Para mostrar mensajes al usuario

// Añadir estudiante
if (isset($_POST['accion']) && $_POST['accion'] == 'añadir') {
    $nombre = $_POST['nombre'] ?? '';
    $edad = $_POST['edad'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $curso = $_POST['curso'] ?? '';
    $genero = $_POST['genero'] ?? '';
    $areas_interes = $_POST['areas_interes'] ?? [];

    // Validaciones
    if (empty($nombre) || empty($edad) || empty($correo) || empty($curso) || empty($genero) || empty($areas_interes)) {
        $mensaje = "Por favor, complete todos los campos requeridos.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "Por favor, ingrese un correo electrónico válido.";
    } elseif ($edad < 18 || $edad > 100) {
        $mensaje = "La edad debe estar entre 18 y 100 años.";
    } else {
        $nuevoEstudiante = [
            'nombre' => $nombre,
            'edad' => $edad,
            'correo' => $correo,
            'curso' => $curso,
            'genero' => $genero,
            'areas_interes' => $areas_interes
        ];
        $contactos[] = $nuevoEstudiante;
        guardarContactos($contactos);
        $mensaje = "Estudiante añadido correctamente.";
    }
}

// Actualizar estudiante
if (isset($_POST['accion']) && $_POST['accion'] == 'actualizar') {
    $nombre = $_POST['nombre'] ?? '';
    $edad = $_POST['edad'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $curso = $_POST['curso'] ?? '';
    $genero = $_POST['genero'] ?? '';
    $areas_interes = $_POST['areas_interes'] ?? [];

    // Validación
    if (empty($nombre) || empty($edad) || empty($correo) || empty($curso) || empty($genero) || empty($areas_interes)) {
        $mensaje = "Por favor, complete todos los campos requeridos.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "Por favor, ingrese un correo electrónico válido.";
    } elseif ($edad < 18 || $edad > 100) {
        $mensaje = "La edad debe estar entre 18 y 100 años.";
    } else {
        $actualizado = false;
        foreach ($contactos as &$contacto) {
            if ($contacto['nombre'] == $nombre) {
                $contacto['edad'] = $edad;
                $contacto['correo'] = $correo;
                $contacto['curso'] = $curso;
                $contacto['genero'] = $genero;
                $contacto['areas_interes'] = $areas_interes;
                $actualizado = true;
                break;
            }
        }
        if ($actualizado) {
            guardarContactos($contactos);
            $mensaje = "Estudiante actualizado correctamente.";
        } else {
            $mensaje = "No se encontró un estudiante con ese nombre.";
        }
    }
}

// Eliminar estudiante
if (isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
    $nombre = $_POST['nombre'] ?? '';
    $eliminado = false;
    foreach ($contactos as $index => $contacto) {
        if ($contacto['nombre'] == $nombre) {
            unset($contactos[$index]);
            $contactos = array_values($contactos); // Reindexa el array
            $eliminado = true;
            break;
        }
    }
    if ($eliminado) {
        guardarContactos($contactos);
        $mensaje = "Estudiante eliminado correctamente.";
    } else {
        $mensaje = "No se encontró un estudiante con ese nombre.";
    }
}

// Mostrar contactos (estudiantes)
function mostrarContactos($contactos) {
    if (empty($contactos)) {
        echo "No hay estudiantes registrados.\n";
    } else {
        echo "Lista de estudiantes:\n";
        foreach ($contactos as $contacto) {
            echo "Nombre: " . $contacto['nombre'] . ", Edad: " . $contacto['edad'] . ", Correo: " . $contacto['correo'] . ", Curso: " . $contacto['curso'] . ", Género: " . $contacto['genero'] . ", Áreas de interés: " . implode(', ', $contacto['areas_interes']) . "<br>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Gestión de Estudiantes</title>
</head>
<body>
<h1>Registro de Estudiantes 🎓</h1>

<!-- Mensaje de confirmación o error -->
<?php if ($mensaje): ?>
    <p><strong><?php echo $mensaje; ?></strong></p>
<?php endif; ?>

<!-- Formulario para añadir un nuevo estudiante -->
<h2>Añadir un nuevo Estudiante</h2>
<form method="post">
    <input type="hidden" name="accion" value="añadir">
    <label>Nombre Completo: </label><input type="text" name="nombre" required><br>
    <label>Edad: </label><input type="number" name="edad" min="18" max="100" required><br>
    <label>Correo Electrónico: </label><input type="email" name="correo" required><br>
    <label>Curso de Interés: </label><input type="text" name="curso" required><br>
    <label>Género: </label>
    <select name="genero" required>
        <option value="masculino">Masculino</option>
        <option value="femenino">Femenino</option>
        <option value="otro">Otro</option>
    </select><br>
    <label>Áreas de Interés (Seleccione al menos una): </label><br>
    <input type="checkbox" name="areas_interes[]" value="Ciencias Sociales"> Ciencias Sociales<br>
    <input type="checkbox" name="areas_interes[]" value="Ciencias Naturales"> Ciencias Naturales<br>
    <input type="checkbox" name="areas_interes[]" value="Tecnología"> Tecnología<br>
    <input type="checkbox" name="areas_interes[]" value="Arte"> Arte<br>
    <button type="submit">Añadir Estudiante</button>
</form>

<!-- Formulario para actualizar un estudiante -->
<h2>Actualizar un Estudiante</h2>
<form method="post">
    <input type="hidden" name="accion" value="actualizar">
    <label>Nombre del Estudiante: </label><input type="text" name="nombre" required><br>
    <label>Edad: </label><input type="number" name="edad" min="18" max="100" required><br>
    <label>Correo Electrónico: </label><input type="email" name="correo" required><br>
    <label>Curso de Interés: </label><input type="text" name="curso" required><br>
    <label>Género: </label>
    <select name="genero" required>
        <option value="masculino">Masculino</option>
        <option value="femenino">Femenino</option>
        <option value="otro">Otro</option>
    </select><br>
    <label>Áreas de Interés (Seleccione al menos una): </label><br>
    <input type="checkbox" name="areas_interes[]" value="Ciencias Sociales"> Ciencias Sociales<br>
    <input type="checkbox" name="areas_interes[]" value="Ciencias Naturales"> Ciencias Naturales<br>
    <input type="checkbox" name="areas_interes[]" value="Tecnología"> Tecnología<br>
    <input type="checkbox" name="areas_interes[]" value="Arte"> Arte<br>
    <button type="submit">Actualizar Estudiante</button>
</form>

<!-- Formulario para eliminar un estudiante -->
<h2>Eliminar un Estudiante</h2>
<form method="post">
    <input type="hidden" name="accion" value="eliminar">
    <label>Nombre del Estudiante: </label><input type="text" name="nombre" required><br>
    <button type="submit">Eliminar Estudiante</button>
</form>

<!-- Mostrar todos los estudiantes registrados -->
<h2>Mostrar todos los Estudiantes</h2>
<div>
    <?php mostrarContactos($contactos); ?>
</div>

</body>
</html>
