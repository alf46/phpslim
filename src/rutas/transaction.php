<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// GET: Todas las transacciones.
$app->get('/api/transactions', function(Request $request, Response $response){
    try{
        $db  = new db();
        $db = $db->conectDB();
        
        $sql = "select id, description, amount, type, user_id, date_format(date, '%Y-%m-%dT%TZ') as date from transaction";

        $resultado = $db->query($sql);

        if($resultado ->rowCount() > 0)
        {
            $resultado = $resultado->fetchAll(PDO::FETCH_OBJ);
        }else $resultado = array('message' => 'No existen transacciones para este usuario');

        return jsonResponse($response, $resultado);
      
    }catch(PDOException $e){
        echo '{"error" : {"msg": '. $e->getMessage(). '}}';
    }
});

// GET: Unico cliente.
$app->get('/api/customers/{id}', function(Request $request, Response $response){
    try{
        $db  = new db();
        $db = $db->conectDB();

        $userId = $request->getAttribute('id');
        $resultado = $db->query("SELECT * FROM customer WHERE id = $userId");
        if($resultado ->rowCount() > 0)
        {
            $resultado = $resultado->fetchAll(PDO::FETCH_OBJ)[0];
        }else $resultado = array('message'=>'No existen clientes en la base de datos');

        return jsonResponse($response, $resultado);
    }catch(PDOException $e){
        echo '{"error" : {"text": '. $e->getMessage(). '}}';
    }
});

?>