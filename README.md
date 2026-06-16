# Estructura de la Base de Datos
La aplicación utiliza **SQLite** para la persistencia de datos. La estructura se genera automáticamente mediante el archivo `db.php`.

## Esquema de la tabla 'tareas'
- **id**: `INTEGER` (Primary Key, Autoincremental)
- **nombre**: `TEXT` (No permite valores nulos, almacena el contenido de la tarea)
- **estado**: `TEXT` (Valor por defecto: 'pendiente', almacena el status de la tarea)