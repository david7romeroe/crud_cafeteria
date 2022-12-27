<?php

    class ProductsModel extends Model
    {
        protected $id;
        protected $title;
        protected $description;
        protected $price;
        protected $sku;
        protected $image;

        public function __construct()
        {
            $this->DBConnection();
        }

        public function getProducts(){

            $results = $this->mbd->query("
            SELECT 
                productos.id, 
                productos.nombre as producto,
                productos.peso, 
                productos.precio,
                productos.referencia,
                productos.stock,
                productos.fecha_creacion, 
                categorias.nombre as categoria,
                categorias.id as categoria_id 
            FROM productos INNER JOIN categorias ON productos.categoria = categorias.id;");

            if(!$results){

                printf("query failed: %s\n", $this->mbd->connect_error);
                exit();
            } else{
                return $results;
            }
        }

        public function getCategories(){

            $results = $this->mbd->query("
            SELECT 
                id, TRIM(nombre) as nombre
            FROM categorias;");

            if(!$results){

                printf("query failed: %s\n", $this->mbd->connect_error);
                exit();
            } else{
                return $results;
            }
        }

        public function updateProducts($product){

            $stmt = $this->mbd->prepare("
            UPDATE productos 
            SET 
            nombre=?, 
            referencia=?,
            peso=?,
            precio=?,
            categoria=?,
            stock=?
            WHERE 
            id=?");

            $stmt->bind_param('ssddiii', 
                $product['product'], 
                $product['reference'],
                $product['weight'],
                $product['price'],
                $product['category'],
                $product['stock'],
                $product['idRow']
            );
           
            $stmt->execute();

            if($stmt->affected_rows== 0) {

                return '{ "message": "No rows were affected!", "updated": false }';
            } else {
                
                return '{ "message": "rows updated!", "updated": true}';
            }
        }

        function createProduct($product){

            $stmt = $this->mbd->prepare("
            INSERT INTO productos 
            (nombre, referencia, peso, precio, categoria, stock, fecha_creacion)
            VALUES
            (?,?,?,?,?,?, NOW())");

            $stmt->bind_param('ssddii', 
                $product['product'], 
                $product['reference'],
                $product['weight'],
                $product['price'],
                $product['category'],
                $product['stock']
            );
           
            $stmt->execute();

            if($stmt->affected_rows== 0) {

                return '{ "message": "No rows were affected!", "created": false }';
            } else {
                
                return '{ "message": "rows updated!", "created": true}';
            }

        }

        function deleteProduct($id){

            $stmt = $this->mbd->prepare("
            DELETE FROM productos 
            WHERE 
            id=?");

            $stmt->bind_param('i', 
                $id
            );
           
            $stmt->execute();

            if($stmt->affected_rows== 0) {

                return '{ "message": "No rows were affected!", "deleted": false }';
            } else {
                
                return '{ "message": "rows updated!", "deleted": true}';
            }
        }

        
    }
