<?php
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT;

require_once 'vendor/autoload.php';

$config ['displayErrorDetails']=true;
$config ['addContentLengthHeader']= false;

$app=new \Slim\App(["settings"=> $config]);

$app->group("/auth",function(){
    //campos: user | password
    $this->post('/login',function (Request $request, Response $response){
        $date=date("now")+30000;
        var_dump(date());
        $body = $request->getParsedBody();
        $key = "example_key";
        $token = array(
            "iss" => "http://example.org",
            "aud" => "http://example.com",
            "iat" => 1356999524,
            "nbf" => 1357000000,
            // "exp"=> "300000", //---> averiguar como validar
            "user"=> $body["user"],
            "password"=> $body["password"],
            
        );
        try{            
            $jwt = JWT::encode($token, $key);           
            $newResponse = $response->withJson($jwt,200);
        }catch(Exception $error){
            echo "Error en el servidor: ", $error->getMessage(), "\n";
        }        
        return $newResponse;
    });
    
    //campos: token
    $this->get('[/]',function (Request $request, Response $response){
        $jwt = $request->getHeader("token")[0];
        $key = "example_key";
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        $newResponse = $response->withJson($decoded,200);
        return $newResponse;
    });
});

$app->run();

?>