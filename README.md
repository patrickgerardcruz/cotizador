Cotizador PixelCode

Aplicación web para publicar un catálogo de servicios, recibir solicitudes de cotización y darles seguimiento desde un panel de administración. Los importes se muestran en soles peruanos (S/).

**Demo:** [Ver el catálogo](https://cotizador-theta-eight.vercel.app/servicios-publico) · [Iniciar sesión](https://cotizador-theta-eight.vercel.app/login)

## Funciones

| Usuario | Funciones |
| --- | --- |
| Visitante | Explorar servicios, consultar precios y acceder a la información de contacto. |
| Cliente | Crear una cuenta, completar su perfil, solicitar cotizaciones y consultar su historial. |
| Administrador | Gestionar clientes, servicios e imágenes. Crear y editar cotizaciones y actualizar su estado: pendiente, en proceso o entregado. |

## Tecnologías

- **Servidor:** PHP 8.2 o superior y Laravel 12.
- **Interfaz:** Blade, Bootstrap y Vite.
- **Base de datos:** MySQL o MariaDB en local y PostgreSQL de Neon en producción.
- **Alojamiento:** Vercel, con un contenedor PHP definido en `Dockerfile.vercel` en la copia de despliegue.

## Ejecutar en local con XAMPP

Necesitas PHP 8.2 o superior con la extensión `pdo_mysql`, Composer y MySQL o MariaDB. Los comandos están escritos para PowerShell.

1. Inicia MySQL desde XAMPP y crea una base de datos llamada `cotizador`. Abre la carpeta del proyecto:

   ```powershell
   cd C:\xampp\htdocs\cotizador
   ```

   Si `php -v` muestra PHP 8.0 y tienes PHP 8.2 instalado en `C:\xampp\php82`, ajusta la ruta para esta sesión de PowerShell:

   ```powershell
   $env:Path = "C:\xampp\php82;$env:Path"
   php -v
   ```

2. Instala las dependencias y crea el archivo de configuración si aún no existe:

   ```powershell
   composer install
   if (-not (Test-Path .env)) { Copy-Item .env.example .env }
   ```

3. Edita `.env` para conectar con la base local. Usa el usuario y la contraseña de tu instalación de MySQL:

   ```dotenv
   APP_NAME="Cotizador PixelCode"
   APP_URL=http://127.0.0.1:8001
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=cotizador
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. Si `APP_KEY` está vacío, ejecuta `php artisan key:generate`. Luego aplica las migraciones e inicia Laravel:

   ```powershell
   php artisan config:clear
   php artisan migrate
   php artisan serve --host=127.0.0.1 --port=8001
   ```

   Abre [el catálogo local](http://127.0.0.1:8001/servicios-publico). La base recién creada estará vacía. La demo publicada ya contiene seis servicios de ejemplo.

La instalación local preparada incluye los recursos compilados en `public/build`. Si partes de una copia nueva y necesitas regenerarlos, utiliza la copia de despliegue con la configuración de Vite revisada y ejecuta `npm ci` y `npm run build` allí. Los scripts originales de la carpeta XAMPP contienen código ofuscado pendiente de revisión.

## Despliegue

Vercel ejecuta Laravel en un contenedor PHP y se conecta a Neon mediante `DATABASE_URL` o `DATABASE_URL_UNPOOLED`. Configura `DB_CONNECTION=pgsql`, `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL` con el dominio de producción y una `APP_KEY` propia del entorno. Aplica `php artisan migrate --force` con acceso a la base de producción antes de publicar una versión que requiera cambios en el esquema.

Las variables del entorno se configuran en Vercel. Mantén `.env`, las claves de aplicación y las contraseñas fuera del repositorio.

## Estructura

| Ruta | Contenido |
| --- | --- |
| `app/Http/Controllers/` | Flujos del catálogo, clientes, servicios y cotizaciones. |
| `app/Models/` | Modelos y relaciones de la base de datos. |
| `database/migrations/` | Esquema de la base de datos. |
| `resources/views/` | Pantallas públicas, de cliente y de administración. |
| `routes/web.php` | Rutas web y controles de acceso por rol.
