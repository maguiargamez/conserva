<?php
   /**
    * Plugin Name: Calculadora Conserva
    * Description: Calculadora Conserva
    * Version: 0.1
    * Author: Conserva
    * License: GPL2
    */

    if(!defined('ABSPATH')) die();

    define("TEST_DIR", __FILE__);
    define("TEST_PLUGIN_DIR", plugin_dir_path(TEST_DIR));
    define("TEST_PLUGIN_URL", plugin_dir_url(TEST_DIR));
 
    require_once TEST_PLUGIN_DIR."includes/classes/main.php";
    require_once TEST_PLUGIN_DIR."includes/classes/api.php";
    $main= new main;
    
 
    register_activation_hook( TEST_DIR, [$main, 'activate'] );
    register_deactivation_hook( TEST_DIR, [$main, 'deactivate'] );


    add_action( 'wp_enqueue_scripts', 'bootstrap_css');
    add_action( 'wp_enqueue_scripts', 'bootstrap_js');
    add_action( 'wp_enqueue_scripts', 'calculator_js');
    add_shortcode('conserva-calculator', 'start');

    function bootstrap_css() 
    {
        wp_enqueue_style( 'bootstrap_css', 
                          'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css', 
                          array(), 
                          '5.3'
                          ); 
    }

    function bootstrap_js() 
    {
        wp_enqueue_script( 'bootstrap_js', 
                          'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js', 
                          array('jquery','popper_js'), 
                          '5.3', 
                          true);                       
    }

    function calculator_js() 
    {
        wp_enqueue_script( 'calculator_js', 
            TEST_PLUGIN_URL.'plugin/js/calculator.js',); 
    }

    function start($atts)
    {

        $api= new api;
        $token= $api->getToken();
        //printf($token.'<br>');

        $products= getData($api->getProducts($token));
        //$products= $api->getProducts($token);

        //echo $products;
        ?>
            <script>
                loadData(<?php echo json_encode($products); ?>);
            </script>
        <?php

        echo printCreditTypes($products);
        echo printDefaultData();
        echo printButtonCalculate();

        
    }

    function getData($data)
    {
        $array= [];
        foreach($data as $item)
        {
            $array[$item["_id"]]= [
                "_id" => $item["_id"],
                "product_name" => $item["product_name"],
                "default_frecuency" => $item["default_frecuency"],
                "min_amount" => $item["min_amount"],
                "max_amount" => $item["max_amount"],
                "default_amount" => $item["default_amount"],
                "step_amount" => $item["step_amount"],
                "min_term" => $item["min_term"],
                "max_term" => $item["max_term"],
                "default_term" => $item["default_term"],
                "min_rate" => $item["min_rate"],
                "max_rate" => $item["max_rate"],
                "rate" => $item["rate"],
                "tax" => $item["tax"],
                "allowed_term_type" => $item["allowed_term_type"],
                "allowed_frequency" => $item["allowed_frequency"],
            ];
        }
        return $array;
    }

    function printCreditTypes($products)
    {

        $string="
            <div class='mb-3'>
                <label for='exampleFormControlInput1' class='form-label'>¿Cual crédito te interesa?</label>
            </div>
        ";
        $string.=  "<div class='mb-3'>";
        foreach($products as $key => $product){            
            $string.= "            
                <input onchange='showData(\"".$key."\")' type='radio' class='btn-check' name='options' id='".$product["_id"]."' autocomplete='off'>
                <label class='btn btn-primary' for='".$product["_id"]."'>".$product["product_name"]."</label>
            ";
        }
        $string.='</div>';
        return $string;
    }

    function printDefaultData()
    {
        $string= '<div id="data" class="mb-3">aa</div>';
        return $string;
    }

    function printButtonCalculate()
    {
        $string= '<div class="mb-3">
            <button onClick="calculate()" type="button" class="btn btn-primary">Calcular</button>
        </div>';
        return $string;
    }

?>