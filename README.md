# **TPE Web 2 TUDAI - Parte 3**

Para la presente entrega, se creo una API que permite trabajar con una organización de productos y categorias de materiales deportivos, a modo de ABM.

### Integrantes

Michelli, Bernardo Agustín - DNI 35.033.429 - Mail: bernabam@gmail.com

---

## **Documentacion:**

### Autenticación por Token

Para realizar modificaciones de tipo POST/PUT/DELETE es necesario realizar una autenticación por token.

**Endpoint:** `/user/token`

- Se debe realizar una Authorization de tipo **Basic Auth** en Postman con los siguientes datos `Usuario: webadmin` - `Contraseña: admin` , a fin de recibir un token.
- El mismo se ingresa en la sección de Authorization de Postman bajo el tipo **Bearer Token**, para poder tener acceso a las modificaciones.

---

### Productos

**Endpoint:** GET `/productos`
- Obtiene un listado de todos los productos disponibles en la base de datos.
- Se puede hacer sort bajo los siguientes campos: `'id_producto', 'nombre', 'id_categoria', 'precio', 'stock', 'imagen'`.
- Se puede ordernar en direccion ascendente y descedente bajo cualquiera de los campos.

**Endpoint:** GET `/producto/:ID`
- Obtiene un producto especifico por `:ID`

**Endpoint:** PUT `/producto/:ID`
- Modifica un producto especifico por `:ID`
- Se deben pasar los datos por el body de Postman con tipo raw y con el siguiente formato:

```
    {
        "nombre": "Nombre del producto",
        "id_categoria": 100,
        "precio": 1000,
        "stock": 10,
        "imagen": "URL imagen"
    }
```

**Endpoint:** DELETE `/producto/:ID`
- Elimina un producto especifico por `:ID`

**Endpoint:** POST `/producto`
- Agrega un producto a la base de datos de productos, en la última posicion con un ID autoincremental.
- Se deben pasar los datos por el body de Postman con tipo raw y con el siguiente formato:

```
    {
        "nombre": "Nombre del producto",
        "id_categoria": 100,
        "precio": 1000,
        "stock": 10,
        "imagen": "URL imagen"
    }
```

---

### Productos

**Endpoint:** GET `/categorias`
- Obtiene un listado de todas los categorias disponibles en la base de datos.
- Se puede hacer sort bajo los siguientes campos: `'id_categoria', 'nombre', 'descripcion', 'imagen'`.
- Se puede ordernar en direccion ascendente y descedente bajo cualquiera de los campos.

**Endpoint:** GET `/categoria/:ID`
- Obtiene una categoria especifico por `:ID`

**Endpoint:** PUT `/categoria/:ID`
- Modifica una categoria especifico por `:ID`
- Se deben pasar los datos por el body de Postman con tipo raw y con el siguiente formato:

```
    {
        "nombre": "Nombre de la categoría",
        "descripcion": "Descripción de la categoría",
        "imagen": "URL imagen"
    }
```

**Endpoint:** DELETE `/categoria/:ID`
- Elimina una categoria especifico por `:ID`

**Endpoint:** POST `/categoria`
- Agrega un categoria a la base de datos de categorias, en la última posicion con un ID autoincremental.
- Se deben pasar los datos por el body de Postman con tipo raw y con el siguiente formato:

```
    {
        "nombre": "Nombre de la categoría",
        "descripcion": "Descripción de la categoría",
        "imagen": "URL imagen"
    }
```

---
