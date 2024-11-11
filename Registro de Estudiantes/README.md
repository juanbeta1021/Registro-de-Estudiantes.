# Registro de Estudiantes

Este es un script en PHP para gestionar contactos. Permite agregar, actualizar, eliminar y mostrar contactos almacenados en un archivo JSON. Los contactos se gestionan a través de un formulario web sencillo.

## Funcionalidades

- **Añadir Contacto**: Permite agregar un nuevo contacto proporcionando el nombre, teléfono y correo electrónico.
- **Actualizar Contacto**: Permite actualizar el teléfono o correo electrónico de un contacto existente, buscando por su nombre.
- **Eliminar Contacto**: Permite eliminar un contacto existente, también buscando por su nombre.
- **Mostrar Contactos**: Muestra todos los contactos almacenados en el archivo `contacts.json`.

## Requisitos

- PHP 7 o superior.
- Un servidor web con soporte para PHP (por ejemplo, XAMPP, WAMP, o un servidor Apache o Nginx configurado).

## Instalación

1. Clona o descarga este repositorio.
2. Asegúrate de tener PHP instalado en tu entorno local.
3. Coloca el archivo `index.php` y el archivo `contacts.json` en el directorio de tu servidor web.
4. Abre el archivo `index.php` en tu navegador para interactuar con la aplicación.

## Uso

1. **Añadir un estudiante**:
    - Completa el formulario de "Añadir un nuevo estudiante" con el nombre, teléfono y correo del contacto.
    - Haz clic en "Añadir estudiante" para guardar el contacto.

2. **Actualizar un estudiante**:
    - Completa el formulario de "Actualizar un estudiante" con el nombre del contacto y los nuevos datos (teléfono y/o correo).
    - Haz clic en "Actualizar estudiante" para guardar los cambios.

3. **Eliminar un estudiante**:
    - Completa el formulario de "Eliminar un estudiante" con el nombre del contacto que deseas eliminar.
    - Haz clic en "Eliminar estudiante" para borrar el contacto.

4. **Ver todos los estudiantes**:
    - Los contactos almacenados se mostrarán en la sección "Mostrar todos los estudiantes".

## Archivos

- `index.php`: El script PHP que gestiona los contactos.
- `contacts.json`: Archivo JSON donde se almacenan los contactos en formato estructurado.

## Notas

- Si el archivo `contacts.json` no existe, el sistema lo crea automáticamente.
- Los contactos son guardados en el archivo `contacts.json` de manera persistente.

