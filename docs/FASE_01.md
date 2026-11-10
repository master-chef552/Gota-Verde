# GotaVerde — Fase 01: Primer incremento funcional

Esta carpeta contiene **solo los archivos nuevos o modificados**, no una instalación completa de Laravel. Está diseñada para incorporarse a `$HOME\Herd\gotaVerde`, donde Laravel 13 y MySQL ya funcionan.

## 1. Qué se implementa

- Registro de usuarios, inicio de sesión y cierre de sesión (RF-01 y RF-02).
- Creación de viviendas y membresía inicial con rol `propietario` (RF-14 y RF-15).
- Selección de una vivienda que pertenezca al usuario (parte de RF-16 y RNF-31).
- Catálogo inicial de actividades y registro de hábitos por vivienda (RF-07 y RF-21, parcial).
- Estimación de litros utilizados y ahorro frente a una referencia provisional (RF-12, parcial).
- Dashboard individual con un resumen semanal e historial reciente (RF-19, parcial).

**Aún no se implementan:** recuperación de contraseña (RF-03), administración global de roles, invitaciones, recibos, metas, rachas, logros, recompensas, dashboard global y gráficas. Tampoco incluye despliegue en producción.

## 2. Antes de copiar

1. Abre `$HOME\Herd\gotaVerde`.
2. Haz un respaldo de `routes\web.php` porque la fase 01 reemplazará ese archivo.
3. Si ya realizaste modificaciones propias, revísalas antes de sobrescribir archivos.
4. **No modifiques `.env`, `vendor` ni `node_modules`.** Esos elementos no vienen en este paquete.

## 3. Copiar los archivos

1. Descomprime `GotaVerde_Fase_01.zip`.
2. Entra a la carpeta `gotaverde_fase_01` descomprimida.
3. Copia su contenido (`app`, `database`, `docs`, `resources`, `routes` y `tests`) al directorio del proyecto `$HOME\Herd\gotaVerde`.
4. Cuando Windows pregunte, permite **combinar las carpetas** y reemplazar **únicamente** `routes\web.php`, si sigue siendo la ruta original de Laravel.

> No copies `gotaverde_fase_01` como subcarpeta dentro del proyecto. Debes copiar **su contenido** para que `routes/web.php` quede en la ruta correcta.

## 4. Ejecutar las migraciones y el catálogo

Abre PowerShell o la terminal de VS Code dentro de `gotaVerde`:

```powershell
cd $HOME\Herd\gotaVerde
php artisan config:clear
php artisan migrate
php artisan db:seed --class=ActividadInicialSeeder
```

**Qué hacen:**
- `migrate`: crea `viviendas`, `vivienda_usuario`, `actividades` y `registros_habito`. Conserva las tablas `users`, `cache`, `jobs` y `migrations` existentes.
- `db:seed`: incorpora una actividad de demostración: **Ducha**, con tasa de **10 litros/minuto** y referencia de **5 minutos**. Esta referencia de 5 minutos es una decisión provisional para probar el cálculo, no una norma pública.

**No ejecutes `php artisan migrate:fresh`** en tu base habitual: elimina todas las tablas existentes y sus datos.

## 5. Iniciar

```powershell
npm run build
composer run dev
```

Abre `http://localhost:8000`. `composer run dev` suele iniciar el servidor y Vite; si tienes otro servidor en marcha, detén el anterior con `Ctrl+C` antes de iniciarlo otra vez.

## 6. Prueba manual en el navegador

1. Abre `/registro` y crea una cuenta de demostración.
2. Completa el formulario **Registrar vivienda** (alias, tipo, habitantes, alcaldía, CP y tarifa opcional).
3. Abre **Registrar hábito**.
4. Selecciona **Ducha**, introduce `10` en cantidad y conserva la fecha actual.
5. La vista previa debe mostrar **100 litros estimados**.
6. Presiona **Guardar hábito**.
7. En `/dashboard`, revisa la tarjeta **Litros esta semana** y la tabla de registros.
8. Crea una segunda vivienda y comprueba que los registros de una vivienda no aparezcan en la otra.

La fórmula inicial es `litros_consumidos = cantidad * litros_por_unidad`. Para el ahorro **respecto a la referencia provisional**, `litros_ahorrados = max(0, referencia_eficiente - cantidad) * litros_por_unidad`.

## 7. Pruebas automáticas (base de datos aislada)

**Importante: no ejecutes pruebas destructivas sobre tu base habitual de MySQL.** Las pruebas usan `RefreshDatabase` y pueden resetear tablas si se ejecutan contra la base equivocada. Para esta fase, utiliza SQLite **en memoria** específicamente para los tests; esto no cambia la base del proyecto.

En una terminal **PowerShell** dentro del proyecto:

```powershell
$env:DB_CONNECTION = 'sqlite'
$env:DB_DATABASE = ':memory:'
php artisan test --filter=GotaVerde
Remove-Item Env:DB_CONNECTION
Remove-Item Env:DB_DATABASE
```

Requiere la extensión SQLite de PHP habilitada, disponible normalmente en Herd. Si aparece un error de configuración, no cambies a tu base real de MySQL para hacer la prueba: envía el error para solucionarlo.

## 8. Guía rápida de archivos

| Archivo | Propósito |
| --- | --- |
| `routes/web.php` | URL de inicio, registro, sesión, viviendas, hábitos y dashboard |
| `app/Http/Controllers/Auth/*` | Registro, acceso y cierre de sesión |
| `app/Http/Controllers/ViviendaController.php` | Alta de viviendas y selección autorizada |
| `app/Http/Controllers/RegistroHabitoController.php` | Validación y guardado de un hábito |
| `app/Http/Controllers/DashboardController.php` | Resumen por vivienda activa |
| `app/Services/EstimadorConsumo.php` | Regla de cálculo sin dependencia de la interfaz |
| `app/Services/ViviendasDelUsuario.php` | Consulta de membresías y vivienda activa |
| `app/Models/*.php` | Relaciones Eloquent |
| `database/migrations/2026_11_10_*` | Nuevas tablas SQL con claves foráneas |
| `database/seeders/ActividadInicialSeeder.php` | Catálogo de ducha para demostración |
| `resources/views/*` | Plantillas Blade con Tailwind CSS 4 |
| `tests/Feature/GotaVerdeFlujoTest.php` | Pruebas de autenticación, permisos y estimaciones |

## 9. Seguridad, alcance y limitaciones

- Las contraseñas se guardan con hash, las sesiones se regeneran tras autenticación y todos los formularios POST llevan token CSRF.
- La vivienda activa siempre se comprueba contra las membresías reales del usuario, no solo contra el ID almacenado en su sesión.
- Las cantidades, los parámetros del catálogo y la tarifa económica producen **estimaciones**; no constituyen mediciones de un medidor de agua ni ahorros acreditados.
- `5 minutos` es un **parámetro de demostración** para la referencia eficiente de la ducha. Antes de usarlo para afirmaciones o reportes, debe justificarse y revisarse.
- Esta fase no contiene una página de recuperación de contraseñas, verificación obligatoria de correo, confirmación de duplicados ni un sistema completo de autorización por roles. No debe considerarse preparada para producción.
- Se usa Tailwind con Vite siguiendo la plantilla estándar de Laravel. No se introducen dependencias nuevas, pero esta versión asume que el esqueleto actual contiene `resources/css/app.css` y `resources/js/app.js` con Tailwind 4 configurado.
- No se incluye `.env` para proteger credenciales locales.

## 10. Guardar la etapa en GitHub

Revisa los cambios con `git status` y asegúrate de excluir `.env` y dependencias. Si ya hay repositorio remoto configurado:

```powershell
git add app database resources routes tests docs
git commit -m "Implementar fase 01 de GotaVerde"
git push
```

## 11. Próxima fase

Recuperación de contraseña, administración de vivienda y miembros, registro de lecturas reales, metas por vivienda, gráficas y gamificación. La prioridad siguiente debe acordarse con el equipo según los requerimientos y los sprints del documento.

## 12. Actualizar el README principal

Cuando verifiques que la fase funciona, edita el `README.md` del repositorio:

- Marca como completados el registro/acceso básico, la creación de viviendas, la captura inicial de hábitos y el dashboard parcial.
- Mantén como **pendiente** la recuperación de contraseña y todos los módulos mencionados arriba.
- Añade un enlace a `docs/FASE_01.md` para indicar cómo se instaló la primera funcionalidad.

No marques ninguna función como completada hasta probarla en tu equipo.
