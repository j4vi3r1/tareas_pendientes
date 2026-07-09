# 🚀 MiGestor - Sistema de Gestión de Tareas con Auditoría

Este es un sistema web modular para la gestión de tareas académicas y profesionales, desarrollado en PHP y utilizando **SQLite** como motor de base de datos relacional. El proyecto incluye un módulo robusto de seguridad, control de sesiones y un sistema detallado de bitácora/auditoría (Logs) para el registro de acciones de los usuarios.

---

## 📊 Estructura de la Base de Datos (`tareas.db`)

El sistema utiliza tres tablas principales interconectadas mediante llaves foráneas para garantizar la integridad referencial. A continuación, se detalla el esquema técnico de cada una:

### 1. Tabla: `usuarios`
Almacena las credenciales y el estado de las cuentas de los usuarios del sistema.
* **`id`** (`INTEGER`, PK, AUTOINCREMENT): Identificador único del usuario.
* **`username`** (`TEXT`, UNIQUE, NOT NULL): Nombre de usuario utilizado para el inicio de sesión.
* **`email`** (`TEXT`, UNIQUE, NOT NULL): Correo electrónico del usuario.
* **`password`** (`TEXT`, NOT NULL): Contraseña encriptada.
* **`verificado`** (`INTEGER`, DEFAULT 0): Estado de verificación de la cuenta (0 = Falso, 1 = Verdadero).
* **`token`** (`TEXT`): Token único para procesos de recuperación o validación.

### 2. Tabla: `tareas`
Contiene los registros de las tareas creadas en la aplicación asociadas a su respectivo propietario.
* **`id`** (`INTEGER`, PK, AUTOINCREMENT): Identificador único de la tarea.
* **`nombre`** (`TEXT`, NOT NULL): Descripción o título de la tarea.
* **`estado`** (`TEXT`, DEFAULT 'pendiente'): Estado actual de la tarea (`pendiente`, `completada`, etc.).
* **`user_id`** (`INTEGER`, FK): Identificador del usuario que creó la tarea.

> 🔗 **Relación:** `user_id` hace referencia a `id` en la tabla `usuarios` (`FOREIGN KEY (user_id) REFERENCES usuarios(id)`).

### 3. Tabla: `logs` (Bitácora de Auditoría)
Registra de forma cronológica e inmutable todas las transacciones y accesos importantes realizados en el sistema.
* **`id`** (`INTEGER`, PK, AUTOINCREMENT): Identificador único del registro de auditoría.
* **`fecha_hora`** (`DATETIME`, DEFAULT CURRENT_TIMESTAMP): Estampa de tiempo exacta del evento (guardada en formato UTC).
* **`usuario_id`** (`INTEGER`, FK, NULLABLE): ID del usuario que realizó la acción. Si es `NULL`, el evento fue generado de forma automática por el `Sistema`.
* **`evento`** (`TEXT`, NOT NULL): Tipo de acción realizada (ej: `iniciar sesion`, `crear registro`, `consultar registro`, `cierre de sesión`).
* **`detalle`** (`TEXT`): Explicación técnica descriptiva del evento, incluyendo tablas e IDs afectados.
* **`ip_host_client`** (`TEXT`): IP real del cliente que originó la petición, optimizado para proxies inversos en la nube.

---

## 🛠️ Requisitos e Instalación en GitHub Codespaces

El entorno está configurado para ejecutarse de forma nativa en un contenedor virtual.

1.  **Levantar el Servidor Local de PHP:**
    Ejecuta el siguiente comando en la terminal para iniciar el servidor integrado en el puerto `8000`:
    ```bash
    php -S 0.0.0.0:8000
    ```

2.  **Inicialización de la Base de Datos:**
    No es necesario ejecutar scripts SQL externos. El sistema cuenta con un mecanismo de autoconstrucción. Al acceder por primera vez a la aplicación, el archivo `db.php` creará automáticamente el archivo `tareas.db` y todas sus tablas con los esquemas correspondientes si no existen.

3.  **Configuración de Permisos en Codespaces:**
    Si experimentas problemas con la escritura de datos o logs en la bitácora debido a las restricciones del contenedor, otorga permisos totales ejecutando:
    ```bash
    chmod 777 tareas.db
    chmod 777 .
    ```