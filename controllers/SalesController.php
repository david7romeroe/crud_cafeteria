<?php


use Twig\Environment;
use Twig\Loader\FilesystemLoader;

    class SalesController extends Controller{


        public static function CreateView($viewName){

            require_once("./models/$viewName"."Model.php");

            $loader = new FilesystemLoader('views');
            $twig = new Environment($loader,array('auto_reload' => true));

            $sales = new SalesModel();

            $products = $sales->getProducts();
            $productRows = $products->fetch_all(MYSQLI_ASSOC);

            $sales->CloseConnection();
            
            echo $twig->render('sales.html', array('products'=>$productRows));

            
        }

        public static function SellProduct(){

            $sales = new SalesModel();
            $result = $sales->sellProduct($_POST);
            $sales->CloseConnection();

            echo $result;
        }

    }