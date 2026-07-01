# Estructura de la Base de Datos
La aplicación utiliza **SQLite** para la persistencia de datos. La estructura se genera automáticamente mediante el archivo `db.php`.

## Esquema de la tabla 'usuarios'
- **id**: `INTEGER` (Primary Key, Autoincremental)
- **username**: `TEXT` (No permite valores nulos)
- **correo**: `TEXT` (No permite valores nulos)
- **password**: `TEXT` (No permite valores nulos, almacena la contraseña cifrada mediante `password_hash`)

## Esquema de la tabla 'tareas'
- **id**: `INTEGER` (Primary Key, Autoincremental)
- **nombre**: `TEXT` (No permite valores nulos, almacena el contenido de la tarea)
- **estado**: `TEXT` (Valor por defecto: 'pendiente', almacena el status de la tarea)
- **user_id**: `INTERGER` (Llave foránea que relaciona la tarea con un usuario específico, asegurando que cada tarea sea privada)