# Docker App Structure

Esta carpeta contiene todos los archivos de configuración para el contenedor de la aplicación ComandaFlow Lite, organizados por ambiente y funcionalidad.

## Estructura de Carpetas

```
docker/app/
├── Dockerfile                 # Dockerfile multistage principal
├── shared/                    # Archivos compartidos entre ambientes
│   ├── entrypoint.sh         # Script de inicialización principal
│   └── init.sh               # Script de configuración de Laravel
├── dev/                       # Configuraciones para desarrollo
│   ├── nginx.dev.conf        # Configuración Nginx desarrollo
│   ├── start-services.sh     # Script simple para iniciar servicios
│   └── supervisord.dev.conf  # Configuración Supervisor desarrollo
└── prod/                      # Configuraciones para producción
    ├── nginx.prod.conf        # Configuración Nginx producción
    ├── php-fpm.prod.conf     # Configuración PHP-FPM optimizada
    └── supervisord.prod.conf  # Configuración Supervisor producción
```

## Descripción de Archivos

### Shared (Compartidos)
- **entrypoint.sh**: Script principal que se ejecuta al iniciar el contenedor. Maneja la inicialización de Laravel y el arranque de servicios.
- **init.sh**: Script de configuración de Laravel que instala dependencias, configura la base de datos y prepara el entorno.

### Development (Desarrollo)
- **nginx.dev.conf**: Configuración de Nginx optimizada para desarrollo con logging detallado y timeouts largos.
- **start-services.sh**: Script simple que inicia PHP-FPM y Nginx sin Supervisor para facilitar el debugging.
- **supervisord.dev.conf**: Configuración de Supervisor para desarrollo con logging a stdout.

### Production (Producción)
- **nginx.prod.conf**: Configuración de Nginx optimizada para producción con compresión, cache y headers de seguridad.
- **php-fpm.prod.conf**: Configuración de PHP-FPM optimizada para producción con pools dinámicos y OPcache.
- **supervisord.prod.conf**: Configuración de Supervisor para producción con logging a archivos y rotación.

## Multistage Build

El Dockerfile utiliza multistage build con tres stages:

1. **base**: Configuración común (PHP, extensiones, Nginx, Supervisor)
2. **development**: Configuraciones para desarrollo con debugging habilitado
3. **production**: Configuraciones optimizadas para producción

## Uso

### Desarrollo
```bash
docker-compose up -d --build
```

**Nota**: En desarrollo, los archivos de configuración se montan como volúmenes para permitir cambios en tiempo real sin necesidad de rebuild:
- `shared/entrypoint.sh` → `/app/entrypoint.sh`
- `shared/init.sh` → `/app/init.sh` 
- `dev/nginx.dev.conf` → `/etc/nginx/http.d/default.conf`
- `dev/supervisord.dev.conf` → `/etc/supervisor/conf.d/supervisord.conf`
- `dev/start-services.sh` → `/app/start-services.sh`

Esto significa que puedes editar estos archivos y reiniciar el contenedor para ver los cambios inmediatamente:
```bash
docker-compose restart app
```

### Producción
```bash
docker-compose -f docker-compose.prod.yml up -d --build
```

## Puertos

- **8000**: Nginx (desarrollo)
- **9000**: PHP-FPM (ambos ambientes)
- **80**: Nginx (producción)