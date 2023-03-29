<?php

class api{

    function getToken(){
        $api_endpoint = 'http://187.188.165.208:7091/users/hf/login';

        $parameters= [
            "user"=> "IzbetVillatoro",
            "password"=> "IzbetVillatoro",
        ];

        $api_args= [
            'headers' => array(
                'Content-Type' => 'application/json'
            ),
            'body' => wp_json_encode($parameters),
            'method'  => 'POST'
        ];
        //$api_endpoint = add_query_arg( $queries, $api_endpoint );
        $response= wp_remote_post( $api_endpoint, $api_args );
        

        if (is_wp_error($response)) 
        {
            
            echo 'Error: ' . $response->get_error_message(); exit();
        }else{

            $response_body = json_decode($response['body'], true);
            //$response_body= json_decode(wp_remote_retrieve_body($response), true);
            return $response_body['token'];
        }
    }
   
    function getProducts($token){
        $api_endpoint = 'http://187.188.165.208:7091/couchdb/products';
        $api_args= [
            'headers' => array(
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ),
            'method'  => 'GET'
        ];
        $response= wp_remote_get( $api_endpoint, $api_args );
        if (is_wp_error($response)) 
        {
            echo 'Error: ' . $response->get_error_message(); exit();
        }else{
            $response_body = json_decode($response['body'], true);
            //echo wp_remote_retrieve_response_code($response);
            return $response_body;
        }
    }

}

?>