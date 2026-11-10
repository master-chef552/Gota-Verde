# GotaVerde

**Aplicación web para registrar hábitos relacionados con el consumo de agua y ayudar a los hogares a dar seguimiento a su uso.**

> **Estado:** proyecto en desarrollo. El entorno local de Laravel y la conexión con MySQL ya funcionan; las funcionalidades propias de GotaVerde todavía están pendientes de implementación.

## 1. Descripción

GotaVerde es un proyecto de aplicación web orientado al seguimiento del consumo de agua en viviendas. Su objetivo es permitir que las personas registren actividades cotidianas, consulten estimaciones de consumo y visualicen su progreso mediante metas e indicadores.

La **primera versión será exclusivamente para navegador web**. No se contempla por ahora una aplicación móvil nativa ni una API separada.

### Funcionalidades previstas

- Registro e inicio de sesión de usuarios.
- Registro y administración de viviendas.
- Asociación de usuarios a una vivienda.
- Registro de hábitos y actividades que consumen agua.
- Estimación del consumo según parámetros de cada actividad.
- Captura de lecturas de consumo real.
- Definición y seguimiento de metas de ahorro.
- Panel de control con estadísticas y gráficas.
- Rachas, logros y recompensas como elementos de gamificación.

**Importante:** esta lista describe el alcance previsto; **no significa que esas funciones ya estén implementadas**.

## 2. Tecnologías

| Herramienta | Uso | Estado |
| --- | --- | --- |
| PHP 8.3 o superior | Lenguaje de programación del servidor | Entorno configurado |
| Laravel 13 | Framework principal; arquitectura MVC | Instalado |
| MySQL 8.4 | Base de datos relacional | Instalado y conectado |
| MySQL Workbench | Administración visual de MySQL | Utilizado |
| Blade | Plantillas de las páginas web | Seleccionado al crear el proyecto |
| Vite y npm | Compilación de recursos del frontend | Configurados |
| Pest | Pruebas automatizadas | Instalado |
| Laravel Herd | Entorno local de desarrollo en Windows | Utilizado |
| Git y GitHub | Control de versiones y repositorio remoto | Para gestionar el código |
| Tailwind CSS 4 | Estilos de interfaz | Previsto en la propuesta técnica; verificar/integrar según avance |
| Alpine.js | Interactividad ligera en el navegador | Previsto; pendiente de integración |
| Chart.js | Gráficas de consumo | Previsto; pendiente de integración |

> Laravel 13 requiere PHP 8.3 o superior. El proyecto se creó con `laravel new gotaVerde`, sin *starter kit*, usando Blade y Pest. Se utilizó inicialmente SQLite durante la creación; después se configuró MySQL y se ejecutaron las migraciones iniciales allí.

## 3. Requisitos previos

Para desarrollar el proyecto en **Windows 10/11** se recomienda instalar:

1. [Visual Studio Code](https://code.visualstudio.com/), o un editor equivalente.
2. [Laravel Herd para Windows](https://herd.laravel.com/windows), para disponer de PHP, Composer, Laravel Installer y herramientas de desarrollo.
3. [MySQL Server 8.4](https://dev.mysql.com/downloads/mysql/), para almacenar los datos.
4. [MySQL Workbench](https://dev.mysql.com/downloads/workbench/), opcional pero recomendado para administrar la base de datos.
5. [Git para Windows](https://git-scm.com/downloads/win), para trabajar con GitHub.
6. Node.js y npm (pueden estar disponibles mediante Herd; comprueba que funcionen en la terminal).

Verifica en **PowerShell** que los comandos estén disponibles:

```powershell
php -v
composer --version
laravel --version
node -v
npm -v
git --version
```

Si algún comando no se reconoce, revisa su instalación y reinicia la terminal.

## 4. Instalación desde GitHub (otra computadora o nuevo colaborador)

### 4.1. Clonar el repositorio

Sustituye `USUARIO` por el nombre real de la cuenta u organización de GitHub y utiliza la URL de tu repositorio:

```powershell
git clone https://github.com/USUARIO/gotaVerde.git
cd gotaVerde
```

### 4.2. Instalar dependencias

```powershell
composer install
npm install
```

### 4.3. Crear el archivo de configuración local

```powershell
Copy-Item .env.example .env
php artisan key:generate
```

El archivo `.env` contiene configuraciones **locales y privadas**. Cada colaborador debe crear el suyo; nunca debe subirse a GitHub.

### 4.4. Crear la base de datos MySQL

Inicia MySQL Server y abre una conexión local en MySQL Workbench (habitualmente host `127.0.0.1`, puerto `3306`). Ejecuta:

```sql
CREATE DATABASE IF NOT EXISTS gotaverde
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

Como configuración inicial, se puede utilizar la cuenta local de MySQL disponible. Para trabajo en equipo es preferible crear un usuario de base de datos específico, con permisos limitados a `gotaverde`.

### 4.5. Configurar `.env`

Busca las variables de conexión y ajústalas a tu instalación de MySQL:

```dotenv
APP_NAME=GotaVerde
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gotaverde
DB_USERNAME=root
DB_PASSWORD=TU_CONTRASENA_LOCAL
```

**No copies una contraseña real al README.** Cambia `TU_CONTRASENA_LOCAL` únicamente dentro de tu `.env`. Si la contraseña contiene caracteres especiales que lo requieren, utiliza comillas dobles.

> `APP_DEBUG=true` se utiliza solamente en desarrollo local. En producción debe ser `false`.

### 4.6. Crear las tablas

```powershell
php artisan config:clear
php artisan migrate
```

Esto crea las tablas definidas por las migraciones del repositorio. En la instalación inicial ya se comprobaron las tablas `users`, `cache`, `jobs` y `migrations` dentro de MySQL.

### 4.7. Compilar el frontend e iniciar la aplicación

```powershell
npm run build
composer run dev
```

Abre en el navegador:

**http://localhost:8000**

Deja abierta la terminal mientras trabajas. Para detener los procesos, utiliza `Ctrl + C`.

> Los comandos se ejecutan **dentro de la carpeta del proyecto**, donde están `artisan`, `composer.json` y `package.json`.

## 5. Cómo se creó el proyecto originalmente

Esta sección documenta la preparación inicial de GotaVerde y **no debe repetirse cuando ya se ha clonado el repositorio**.

1. Se instalaron Laravel Herd, MySQL Server, MySQL Workbench y las herramientas de desarrollo.
2. Se comprobó la disponibilidad de PHP, Composer, Laravel Installer, Node.js y npm.
3. En PowerShell se creó el proyecto:

   ```powershell
   cd $HOME\Herd
   laravel new gotaVerde
   ```

4. Durante el asistente se eligió **sin starter kit**, **Blade** y **Pest**.
5. El instalador descargó las dependencias, generó la clave de aplicación y preparó la base de datos inicial SQLite.
6. Se creó una conexión local en MySQL Workbench y una base de datos llamada `gotaverde`.
7. En el archivo `.env` se sustituyó `DB_CONNECTION=sqlite` por la configuración de MySQL.
8. Se ejecutaron los comandos:

   ```powershell
   php artisan config:clear
   php artisan migrate
   ```

9. Las migraciones se completaron correctamente en MySQL y se verificó la presencia de las tablas mediante Workbench.
10. Se ejecutó el proyecto con `composer run dev` y se comprobó que la página inicial de Laravel se abría en el navegador.

**Resultado de esta etapa:** instalación, servidor web local y base de datos preparados para iniciar el desarrollo funcional.

## 6. Estructura básica del proyecto

```text
gotaVerde/
├── app/                   # Lógica de aplicación: modelos, controladores, etc.
├── bootstrap/             # Inicialización del framework
├── config/                # Configuración de Laravel
├── database/
│   ├── migrations/        # Cambios versionados del esquema de MySQL
│   ├── factories/         # Fábricas para pruebas
│   └── seeders/           # Datos de ejemplo o iniciales
├── public/                # Punto de entrada público y recursos compilados
├── resources/
│   ├── views/             # Plantillas Blade
│   ├── css/               # Estilos fuente
│   └── js/                # JavaScript fuente
├── routes/
│   └── web.php            # Rutas de la aplicación web
├── tests/                 # Pruebas automatizadas
├── .env.example           # Ejemplo público de configuración
├── artisan                # Herramienta de línea de comandos de Laravel
├── composer.json          # Dependencias PHP
└── package.json           # Dependencias del frontend
```

> Dependiendo de la configuración y las herramientas instaladas, puede haber directorios adicionales.

## 7. Comandos útiles

| Comando | Función |
| --- | --- |
| `composer run dev` | Iniciar el entorno local de desarrollo |
| `php artisan route:list` | Consultar las rutas registradas |
| `php artisan migrate` | Aplicar migraciones pendientes |
| `php artisan migrate:status` | Revisar qué migraciones se ejecutaron |
| `php artisan config:clear` | Limpiar la caché de configuración |
| `php artisan make:model Vivienda -m` | Crear un modelo y su migración |
| `php artisan make:controller ViviendaController` | Crear un controlador |
| `npm run build` | Compilar recursos para distribución |
| `php artisan test` | Ejecutar las pruebas del proyecto |

## 8. Estado actual y próximos pasos

### Completado

- [x] Instalar el entorno de desarrollo en Windows.
- [x] Crear el proyecto Laravel 13 con Blade.
- [x] Instalar las dependencias iniciales y Pest.
- [x] Abrir correctamente la página inicial en el navegador.
- [x] Configurar la conexión entre Laravel y MySQL.
- [x] Ejecutar las migraciones iniciales y verificar las tablas en Workbench.

### Pendiente

- [ ] Reemplazar la pantalla de bienvenida por una interfaz inicial de GotaVerde.
- [ ] Definir y crear las migraciones del modelo de datos del proyecto.
- [ ] Implementar registro, autenticación y cierre de sesión.
- [ ] Registrar viviendas y asociarles usuarios.
- [ ] Crear un catálogo de actividades y registrar hábitos de consumo.
- [ ] Implementar el cálculo estimado de litros utilizados por actividad.
- [ ] Incorporar lecturas de consumo real, metas y reportes.
- [ ] Añadir un panel de control con gráficas.
- [ ] Implementar logros, rachas y recompensas.
- [ ] Incorporar validaciones, autorización y pruebas de las funciones desarrolladas.

**Primer objetivo funcional:** un usuario podrá ingresar, registrar una vivienda y una actividad (por ejemplo, una ducha), obtener un cálculo estimado de agua utilizada y consultar el registro desde su panel.

## 9. Seguridad y buenas prácticas

- **Nunca subas `.env` a GitHub**, ni contraseñas, tokens o claves privadas.
- Conserva `.env.example` con valores de ejemplo, sin secretos.
- Verifica que `.env`, `vendor/`, `node_modules/` y los archivos locales de base de datos estén excluidos mediante `.gitignore`.
- Conserva en Git los archivos `composer.lock` y `package-lock.json` para poder reproducir las dependencias del proyecto.
- No uses `root` como usuario de MySQL en un entorno de producción.
- No utilices `APP_DEBUG=true` en producción.
- Ejecuta las migraciones para modificar la estructura de la base de datos, en lugar de depender de cambios manuales en Workbench.
- Las cifras obtenidas a partir de actividades serán **estimaciones**, a menos que provengan de lecturas reales del consumo.

## 10. Publicar el proyecto en GitHub

Si el proyecto todavía no tiene un repositorio remoto, abre PowerShell dentro de `gotaVerde` y comprueba primero su estado:

```powershell
git status
```

Si Git indica que **no es un repositorio**, inicialízalo con `git init`. Después revisa que los archivos privados estén ignorados y realiza el primer commit:

```powershell
git add .
git status
git commit -m "Configuración inicial de GotaVerde"
```

Crea un repositorio **vacío** en GitHub y vincula el proyecto. Sustituye `USUARIO` y comprueba la URL real antes de ejecutar:

```powershell
git branch -M main
git remote add origin https://github.com/USUARIO/gotaVerde.git
git push -u origin main
```

> Si ya existe un remoto llamado `origin`, no vuelvas a agregarlo; revisa primero `git remote -v`. GitHub puede pedir autenticación mediante el navegador o un gestor de credenciales. **Antes de `git add .`, revisa `.gitignore` y asegúrate de no incluir secretos.**

Para publicar cambios posteriores:

```powershell
git add .
git commit -m "Describe el cambio realizado"
git push
```

## 11. Documentación de referencia

- [Laravel 13: instalación](https://laravel.com/docs/13.x/installation)
- [Laravel 13: configuración](https://laravel.com/docs/13.x/configuration)
- [Laravel 13: base de datos](https://laravel.com/docs/13.x/database)
- [Laravel Herd para Windows](https://herd.laravel.com/windows)
- [Documentación de MySQL](https://dev.mysql.com/doc/)
- [Documentación de Git](https://git-scm.com/doc)

---

**GotaVerde** · Proyecto académico en desarrollo · Versión web inicial.

**Licencia:** pendiente de definir. No se incluye todavía un archivo `LICENSE`.
