# ComandaFlow Lite - DevContainer Setup

Este proyecto incluye configuración de DevContainer para un desarrollo fluido con VS Code.

## 🚀 Inicio Rápido con DevContainer

### 1. Prerrequisitos
- VS Code instalado
- Extensión "Dev Containers" de Microsoft
- Docker Desktop ejecutándose

### 2. Abrir en DevContainer

1. Abrir VS Code en el directorio del proyecto
2. VS Code debería detectar automáticamente la configuración de DevContainer
3. Hacer clic en "Reopen in Container" cuando aparezca la notificación
   
   O alternativamente:
   - `Ctrl+Shift+P` (o `Cmd+Shift+P` en Mac)
   - Buscar "Dev Containers: Reopen in Container"
   - Seleccionar la opción

### 3. ¿Qué sucede automáticamente?

- **Entorno completo**: PHP 8.2, Composer, Node.js, npm
- **Laravel listo**: Laravel 12 ya instalado y configurado
- **Base de datos**: PostgreSQL 16 conectado y funcional
- **Extensiones**: Todas las extensiones de Laravel y PHP instaladas
- **Terminal**: Acceso directo al contenedor desde VS Code
- **Puertos**: Laravel (8000) y PostgreSQL (5432) mapeados automáticamente

### 4. Comandos Disponibles

Desde el terminal integrado de VS Code (ya dentro del contenedor):

```bash
# Comandos de Laravel
php artisan --version
php artisan migrate
php artisan make:controller ExampleController

# Comandos de Composer
composer install
composer require package-name

# Comandos de npm
npm install
npm run dev
npm run build

# Ver logs de la aplicación
tail -f storage/logs/laravel.log
```

### 5. Acceso a la Aplicación

- **Laravel App**: http://localhost:8000 (desde el navegador del host)
- **Base de datos**: localhost:5432 (para herramientas externas como pgAdmin)

### 6. Estructura de Archivos

```
/app/                   # Laravel application (working directory)
├── app/
├── config/
├── database/
├── public/
├── resources/
├── routes/
└── ...
```

### 7. Extensiones Incluidas

- **PHP Intelephense**: IntelliSense para PHP
- **Laravel Blade**: Sintaxis highlighting para Blade
- **Laravel Extension Pack**: Conjunto completo de herramientas Laravel
- **Laravel Artisan**: Comandos Artisan integrados
- **Tailwind CSS**: Autocompletado para Tailwind
- **Docker**: Gestión de contenedores desde VS Code

### 8. Tips de Desarrollo

1. **Hot Reload**: Los cambios en archivos se reflejan inmediatamente
2. **Debugging**: Configurar Xdebug si es necesario para debugging
3. **Terminal múltiple**: Puedes abrir múltiples terminales dentro del contenedor
4. **Git**: Funciona normalmente desde dentro del contenedor

### 9. Troubleshooting

**Problema**: El contenedor no inicia
- Verificar que Docker Desktop esté ejecutándose
- Ejecutar `docker compose up -d` desde la terminal

**Problema**: No se puede acceder a localhost:8000
- Verificar que el puerto esté mapeado correctamente
- Revisar logs con `docker logs cf-app`

**Problema**: Cambios no se reflejan
- Los archivos están montados como volumen, los cambios deberían ser inmediatos
- Verificar permisos de archivos

## 🔄 Comandos de Mantenimiento

```bash
# Reconstruir el contenedor
docker compose down
docker compose up -d --build

# Ver logs
docker logs cf-app
docker logs cf-db

# Acceder manualmente al contenedor
docker exec -it cf-app bash

# Limpiar y reiniciar
docker compose down -v
docker compose up -d --build
```

¡Disfruta desarrollando con ComandaFlow Lite! 🚀