<?php


use Twig\Environment;
use Twig\Loader\FilesystemLoader;


    class ProductsController extends Controller{


        public static function CreateView($viewName){

            require_once("./models/$viewName"."Model.php");

            $loader = new FilesystemLoader('views');
            $twig = new Environment($loader,array('auto_reload' => true));

            $products = new ProductsModel();
            $productList = $products->getProducts();
            $productRows = $productList->fetch_all(MYSQLI_ASSOC);

            $categoryList = $products->getCategories();
            $categoryRows = $categoryList->fetch_all(MYSQLI_ASSOC);
            
            echo $twig->render('products.html', array(
                "products" => $productRows, "categories"=> $categoryRows
            ));

            $products->CloseConnection();
        }

        public static function EditProduct(){

            $products = new ProductsModel();
            $result = $products->updateProducts($_POST);
            $products->CloseConnection();

            echo $result;       
        }

        public static function CreateProduct(){

            $products =  new ProductsModel();
            $result = $products->createProduct($_POST);

            echo $result;

        }

        public static function DeleteProduct(){

            $data = json_decode($_POST['delete'], true);
            $products = new ProductsModel();

            $result = $products->deleteProduct($data['id']);
            $products->CloseConnection();

            echo $result;
        }

    }

?>