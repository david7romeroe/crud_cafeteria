
<?php


    require_once('./vendor/autoload.php');

    use Twig\Environment;
    use Twig\Loader\FilesystemLoader;

   
    class Controller{
        public static function CreateView($viewName){

            $loader = new FilesystemLoader('views');

            $twig = new Environment($loader);

            echo $twig->render('index.html.twig', array(
                "Producto" => 'Jabon'
            ));
        }

    }
?>