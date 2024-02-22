# Bolsa Trabajo Batoi

## Descripción
Este proyecto está desarrollado para facilitar a los estudiantes del centro a buscar trabajo después de terminar sus estudios. Esta parte está dirigida para los responsables y administradores, ya que se encargarán de todo el mantenimiento de la bolsa. 

## Tecnoloǵias utilizadas:
- PHP
- Laravel
- Dep Deploy
- Apache
- HTML
- CSS
- Bootstrap
- Docker
- Artisan

## Configuración de Desarrollo
1. Clona el repositorio del proyecto:
    
    git clone https://github.com/BolsaTrabajo-Grupo2/backed-laravel.git
    
2. Accede al directorio del proyecto:
    
    cd backed-laravel
    
3. Instala las dependencias:
    ```
    docker run --rm -v $(pwd):/opt -w /opt laravelsail/php82-composer:latest composer install
    ```
4. Copia el fichero .env:
    ```
    cp .env.example .env
    ```
5. Ejecuta los servidores con Sail:
    ```
    vendor/bin/sail up -d
    ```
6. Abre tu navegador y accede a http://localhost:8080 y crea la base de datos bolsa-trabajo.
7. Inicia el terminal del contenedor:
    ```
    vendor/bin/sail bash
    ```
9. Genera la clave APP.KEY:
    ```
    php artisan key:generate
    ```
11. Construlle los seeders:
    ```
    php artisan migrate:fresh --seed
    ```
13. Genera los node_modules
    ```
    npm install
    npm run build
    ```
    
## Despliegue en Producción
Para desplegar la aplicación en una máquina virtual utilizando Apache como servidor web, sigue estos pasos:

1. Asegúrate de tener una máquina virtual configurada con Apache instalado y correctamente configurado.
2. Construye la aplicación para producción:
    
    npm run build
    
3. Copia los archivos generados en la carpeta dist al directorio raíz de tu servidor Apache.
4. Reinicia el servidor Apache para aplicar los cambios.
5. Accede a la dirección IP de tu máquina virtual en un navegador para ver la aplicación desplegada.

## Contribución
Si quieres contribuir a este proyecto, por favor sigue estos pasos:
1. Haz un fork del repositorio
2. Crea una nueva rama (git checkout -b feature/nueva-caracteristica)
3. Haz tus cambios y realiza commits (git commit -am 'Añade una nueva característica')
4. Sube tus cambios al fork (git push origin feature/nueva-caracteristica)
5. Crea un nuevo Pull Request

## Licencia
Este proyecto está bajo la [Licencia MIT](https://opensource.org/licenses/MIT). Para más detalles, consulta el archivo de licencia adjunto.

## Autores
- [Lucas Juan](https://github.com/LucasJR13)
- [Arantxa Gandía](https://github.com/Arantxaa31)
- [Jaume Miró](https://github.com/JaumeMiroCorcoles)
- [María Ruiz](https://github.com/mariaruizpaton)
