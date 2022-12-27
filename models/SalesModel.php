<?php

    class SalesModel extends Model{


        public function __construct()
        {
            $this->DBConnection();
        }

        public function getProducts(){

            $results = $this->mbd->query("
            SELECT 
                id, TRIM(nombre) as nombre, precio
            FROM productos;");

            if(!$results){

                printf("query failed: %s\n", $this->mbd->connect_error);
                exit();
            } else{
                return $results;
            }
        }

        public function sellProduct($product) {
            
            $row = $this->getStockByProduct($product['product']); 
            $total = (float)$product['price'] * (int)$product['quantity'];
         
            if($row['stock'] >= $product['quantity'])
            {
                $stmt = $this->mbd->prepare("
                INSERT INTO ventas 
                (id_producto, total, cantidad)
                VALUES
                (?,?,?)");

                $stmt->bind_param('idd', 
                    $product['product'], 
                    $total,
                    $product['quantity']
                );
            
                $stmt->execute();

                if($stmt->affected_rows==0) {

                    return '{ "message": "no rows were affected!", "sold": false }';
                } else {
                    
                    if($this->updateStock($product['product'], $product['quantity'])){

                        return '{ "message": "sale concluded!", "sold": true}';
                    } else{

                        return '{ "message": "sale error!", "sold": false}';
                    }   
                    
                }
            } else{

                return '{ "message": "insufficient stock!", "sold": false}';
            }
        }

        function updateStock($id, $quantity){
            $stmt = $this->mbd->prepare("
            UPDATE 
            productos 
            SET stock = (
                SELECT stock-? as stock FROM productos WHERE id = ? 
            ) WHERE id = ?;");

            $stmt->bind_param('iii', 
                $quantity,
                $id,
                $id
            );
           
            $stmt->execute();

            if($stmt->affected_rows== 0) {

                return false;
            } else {
                
                return true;
            }

        }

        function getStockByProduct($id){

            $stmt = $this->mbd->prepare("
            SELECT 
                stock 
            FROM productos WHERE id = ?;");

            $stmt->bind_param('i', $id);
            $stmt->execute();

            $result = $stmt->get_result();
            
            if($result) {

                return $result->fetch_array(MYSQLI_ASSOC);
            } else {
                
                return 0;
            }

        }
    }