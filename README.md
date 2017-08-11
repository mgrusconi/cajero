## Sinopsis

Ejercicio que simula el comportamiento de un cajero automatico con el manejo de cuenta unica.

## Ejemplo

Se puede ver unos pequeños ejemplos de utilizacion y comportamiento en el index.php

## Instalacion

El repositorio contiene un Dockerfile y un docker-compose. Si se tiene estas herramientas instaladas solo es necesario correr el comando docker-compose up -d. Una vez este levantado el ambiete se puede ingresar por navegador tanto con localhost:81 como por cajero.dev

## Tests

Se implemento phpunit para testear la clase. entrando al contenedor solo es necesario correr el comando phpunit --bootstrap class/Cajero.php test/CajeroTest.php para que los test corran
