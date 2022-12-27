<?php

    Route::set('sales', function(){
        

        if(isset($_POST['sell'])){
            SalesController::SellProduct();
        } else {
            SalesController::CreateView('Sales');
            
        }
    });
    
    Route::set('index.php', function(){

        header("Location: ./products");
    });

    Route::set('products', function(){


        if(isset($_POST['edit'])){

            ProductsController::EditProduct();            
        }

        else if(isset($_POST['delete'])){
            
            ProductsController::DeleteProduct();
        }
        else if (isset($_POST['create'])){

            ProductsController::CreateProduct();
        }
        else {

            ProductsController::CreateView('Products');
        }
        
    });

    Route::set('about-us2', function(){
        echo 'about-us';
    });
?>