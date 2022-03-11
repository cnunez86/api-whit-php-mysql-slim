Docker Compose con Apache, MySQL, PHPMyAdmin y Slim Framework.

# Instalación

- Descargar el repositorio

- En la consola, ejecutar las siguientes instrucciones 

```
docker-compose build
```

```
docker-compose up -d
```

- Una vez finalizada la creación de los contenedores ingresar a [http://localhost:81](http://localhost:81) para corrobar que esté funcionando el servicio.

- Las direcciones para acceder a:
    - Localhost -> [http://localhost:81](http://localhost:81)
    - PHPMyAdmin -> [http://localhost:82](http://localhost:82)
        - Usuario: -> root
        - Pass: -> test

- Documentación de la API.
    - [https://documenter.getpostman.com/view/12564516/UVsFzU9K](https://documenter.getpostman.com/view/12564516/UVsFzU9K)


# Comandos básicos de Docker Compose
- Iniciar servicios 
```
docker-compose start
```
- Detener servicios
```
docker-compose stop
```
- Reiniciar servicios
```
docker-compose restart
```
- Detener y remover los servicios
```
docker-compose down
```
