SELECT * FROM productos WHERE stock IN ( SELECT MAX(stock) FROM productos );
SELECT productos.id, productos.nombre FROM productos WHERE id IN (SELECT table1.id_producto FROM (SELECT id_producto, SUM(cantidad) FROM ventas GROUP BY id_producto ORDER BY SUM(cantidad) DESC) as table1) LIMIT 1;