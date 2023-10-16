<?php 
    require_once "./database/config.php";

    class Model {
        protected $db;

        public function __construct() {
            $this->db = new PDO("mysql:host=".MYSQL_HOST .";dbname=".MYSQL_DB.";charset=utf8", MYSQL_USER, MYSQL_PASS);
            $this->_deploy();
        }

        function _deploy() {
            $query = $this->db->query('SHOW TABLES');
            $tables = $query->fetchAll();
            if(count($tables) == 0) {
                $sql =<<<END

                CREATE TABLE `categorias` (
                  `id_categoria` int(11) NOT NULL,
                  `nombre` varchar(45) NOT NULL,
                  `descripcion` varchar(110) NOT NULL,
                  `imagen` varchar(110) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
                
                --
                -- Volcado de datos para la tabla `categorias`
                --
                
                INSERT INTO `categorias` (`id_categoria`, `nombre`, `descripcion`, `imagen`) VALUES
                (100, 'Fútbol', 'Productos de fútbol', 'www.ejemplo.com/img-futbol.png'),
                (101, 'Básquet', 'Productos de Básquet', 'www.ejemplo.com/img-basquet.png'),
                (102, 'Voley', 'Productos de Voley', 'www.imagen.com/img-voley.png'),
                (103, 'Boxeo', 'Productos de Box', 'www.ejemplo.com/img-box.png'),
                (104, 'Categoría Vacía Ejemplo', 'Esta categoría esta vacía por lo cual se puede eliminar', 'URL ejemplo');
                
                -- --------------------------------------------------------
                
                --
                -- Estructura de tabla para la tabla `producto`
                --
                
                CREATE TABLE `producto` (
                  `id_producto` int(11) NOT NULL,
                  `nombre` varchar(45) NOT NULL,
                  `id_categoria` int(11) NOT NULL,
                  `precio` double NOT NULL,
                  `stock` int(11) NOT NULL,
                  `imagen` varchar(45) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
                
                --
                -- Volcado de datos para la tabla `producto`
                --
                
                INSERT INTO `producto` (`id_producto`, `nombre`, `id_categoria`, `precio`, `stock`, `imagen`) VALUES
                (1, 'Pelota de Fútbol', 100, 5999, 10, 'URL proveedor'),
                (2, 'Pelota de Básquet', 101, 8999, 5, 'URL proveedor'),
                (3, 'Pelota de Voley', 102, 6999, 8, 'URL proveedor'),
                (4, 'Guantes de Arquero', 100, 4999, 5, 'URL ejemplo'),
                (5, 'Botines de Fútbol', 100, 10999, 5, 'URL ejemplo'),
                (6, 'Zapatillas de Básquet', 101, 15499, 5, 'URL ejemplo'),
                (7, 'Guantes de Box', 103, 5699, 8, 'URL ejemplo');
                
                -- --------------------------------------------------------
                
                --
                -- Estructura de tabla para la tabla `usuarios`
                --
                
                CREATE TABLE `usuarios` (
                  `id` int(11) NOT NULL,
                  `username` varchar(255) NOT NULL,
                  `password` varchar(255) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
                
                --
                -- Volcado de datos para la tabla `usuarios`
                --
                
                INSERT INTO `usuarios` (`id`, `username`, `password`) VALUES
                (1, 'webadmin', '$2a$12$/rALEUFP7kFArSCQMw2P0ePrJmRHlXu.MGyhPPNXVgg2sQ9kIDEJq');

                --
                -- Índices para tablas volcadas
                --
                
                --
                -- Indices de la tabla `categorias`
                --
                ALTER TABLE `categorias`
                  ADD PRIMARY KEY (`id_categoria`);
                
                --
                -- Indices de la tabla `producto`
                --
                ALTER TABLE `producto`
                  ADD PRIMARY KEY (`id_producto`),
                  ADD KEY `FK_id_categoria` (`id_categoria`);
                
                --
                -- Indices de la tabla `usuarios`
                --
                ALTER TABLE `usuarios`
                  ADD PRIMARY KEY (`id`);
                
                --
                -- AUTO_INCREMENT de las tablas volcadas
                --
                
                --
                -- AUTO_INCREMENT de la tabla `categorias`
                --
                ALTER TABLE `categorias`
                  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;
                
                --
                -- AUTO_INCREMENT de la tabla `producto`
                --
                ALTER TABLE `producto`
                  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
                
                --
                -- AUTO_INCREMENT de la tabla `usuarios`
                --
                ALTER TABLE `usuarios`
                  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
                
                --
                -- Restricciones para tablas volcadas
                --
                
                --
                -- Filtros para la tabla `producto`
                --
                ALTER TABLE `producto`
                  ADD CONSTRAINT `FK_id_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);
                COMMIT; 
            END;
            $this->db->query($sql);
            }
        }
    
    }