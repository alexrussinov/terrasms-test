<?php
/**
 *
 * Generate test data for news widget
 * @param $pdo
 *
 */
$db ='mysql://$OPENSHIFT_MYSQL_DB_HOST:$OPENSHIFT_MYSQL_DB_PORT/;dbname=terrasmstest';
$user = 'admins7fblhA';
$pass = 'ExQp6RNYZae1';

// Connection options
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
);

//Connection
try{
    $pdo = new PDO($db,$user,$pass,$options);

}
catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}


function generateNews($pdo){
    $dt = new DateTime();
    try{
        $sql = 'INSERT INTO News
    (ID,name,time)
    VALUES (?, ?, ?)';
        $stmt = $pdo->prepare($sql);
        for($i=0; $i<1000; $i++){
            $stmt->execute(array(
                null,
                'MyNews '.($i+1),
                $dt->format('Y-m-d H:i:s')
            ));
        }
        $stmt->execute();
    }
    catch(Exception $e){
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

generateNews($pdo);

echo "OK!";