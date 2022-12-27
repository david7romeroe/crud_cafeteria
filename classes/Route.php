<?php
    class Route{

        public static $validRoutes = [

        ];

        public static function set($route, $function){

            self::$validRoutes[] = $route;

            if($route == $_GET['url']){

                $function->__invoke();
            }

        }
    }

?>