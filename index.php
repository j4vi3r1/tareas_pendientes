<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Proyecto CRUD - Gestión de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h1 class="text-primary">Proyecto: Lista de tareas pendientes</h1>

    <section class="mt-4">
        <h2>Integrantes:</h2>
        <ul>
            <li>Ricardo González</li>
            <li>Monserrat Palma</li>
            <li>Javier Quezada</li>
        </ul>
    </section>

    <section class="mt-4">
        <h2>Descripción de la Aplicación</h2>
        <p>Aplicación web dinámica para la gestión de pendientes, permitiendo al usuario crear, listar, modificar y eliminar tareas de forma eficiente mediante una base de datos persistente.</p>
    </section>

    <section class="mt-4">
        <h2>Operaciones CRUD</h2>
        <ul>
            <li><strong>Create:</strong> Formulario para añadir nuevas tareas.</li>
            <li><strong>Read:</strong> Visualización de la lista completa desde la base de datos.</li>
            <li><strong>Update:</strong> Cambio de estado (pendiente/completado) o edición de nombre.</li>
            <li><strong>Delete:</strong> Eliminación definitiva de registros.</li>
        </ul>
    </section>

    <section class="mt-4">
        <h2>Estructura de la Base de Datos</h2>
        <p>La aplicación utiliza <strong>SQLite</strong> para la persistencia de datos. La estructura se genera automáticamente mediante el archivo <code>db.php</code>.</p>
        
        <h3>Esquema de la tabla 'tareas'</h3>
        <ul>
            <li><strong>id</strong>: <code>INTEGER</code> (Primary Key, Autoincremental)</li>
            <li><strong>nombre</strong>: <code>TEXT</code> (No permite valores nulos, almacena el contenido de la tarea)</li>
            <li><strong>estado</strong>: <code>TEXT</code> (Valor por defecto: 'pendiente', almacena el status de la tarea)</li>
        </ul>
    </section>
    
    <section class="mt-4">
        <h2>Mockup de la Interfaz</h2>
        <img src="mockup.jpg" alt="Diseño de interfaz" class="img-fluid border shadow" style="width: 3000px; height: auto;">
    </section>

</body>
</html>