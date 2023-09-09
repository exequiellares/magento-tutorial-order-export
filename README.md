# Magento Tutorial Modulo Order Export

**NOTA**: Este modulo es un ejemplo completo de customizacion sobre Magento (Adobe Commerce) con propositos educativos.

Se revisan varios conceptos claves a la  hora de customizar Magento:

* Creacion de un modulo
* Creacion de un comando CLI
* Creacion de un modelo
* Creacion de accion classes
* Creacion de interfaces
* Creacion de un plugin
* Creacion de archivos de configuracion
* Creacion de atributos EAV
* Creacion de extension attributes
* Creacion de bloques y modificacion de layout

Puedes ver el tutorial completo en [Youtube](https://www.youtube.com/playlist?list=PLfgVXk3rdwYc4a0RyITthauAXp0KkyDao)

## Requerimientos

El listado de requerimientos del modulo se encuentra [aqui](doc/Requerimientos.pdf)

## Configuraciones

En Stores > Configuration > Sales > Sales > Order Export:

* **Enabled**
* **API URL**: URL del sistema ERP
* **API Token**: Token de autenticacion del sistema ERP
* **Enable SSL Verification**: Habilita la verificacion de certificados SSL (Deshabilitar en desarrollo)

## Comando CLI

El comando cli permite exportar las ordenes a un sistema ERP

### Parametros y Opciones

* **order-id**: ID de la orden a exportar. Requerido
* **--notes**: Notas del vendedor. Opcional
* **--ship-date**: Fecha estimada de envio de la orden en formato YYYY-MM-DD. Opcional

### Uso:

```bash
bin/magento order-export:run <order-id> --notes="<nota>" --ship-date="<fecha en formato YYYY-MM-DD>"
```

### Ejemplo

```bash
bin/magento order-export:run 1 --notes="Esto es una nota de ejemplo" --ship-date="2022-04-20"
```
