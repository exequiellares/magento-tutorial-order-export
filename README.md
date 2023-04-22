# Magento Tutorial Modulo Order Export

NOTA: Este modulo es un ejemplo completo de customizacion de Magento con propositos educativos. Es un modulo de ejemplo y para seguir como guia de este tutorial.

Exporta ordenes a un sistema ERP externo

## Configuraciones

En Stores > Configuration > Sales > Sales > Order Export:

* **Enabled**

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
