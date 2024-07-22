# DOCUMENTACIÓN

## Middleware

Require una función handle por defecto cargada en ```static```
Cargar los middleware en Config/middleware.php

## CLI

Llama las funciones con ```php merp [arguments] ```

## Consultas a la base de datos
Todas las solicitudes se pasan directamente por un array al instance la clase **Database** . Por ejemplo:
``` Database::readOne("SELECT * FROM table WHERE condition = :param", ['param' => $data]) ```

- ```create($query)``` crea registros.
- ```update($query)``` actualiza los registro.

/// SELECCIONA (CUANTOS) FROM [donde] WHERE [condicion] ID = ID LIMIT 1