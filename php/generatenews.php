<?php
/**
 *
 * Generate test data for news widget
 * @param $pdo
 *
 */
/** The name of the database */
define('DB_NAME', $_ENV['OPENSHIFT_APP_NAME']);

/** MySQL database username */
define('DB_USER', $_ENV['OPENSHIFT_MYSQL_DB_USERNAME']);

/** MySQL database password */
define('DB_PASSWORD', $_ENV['OPENSHIFT_MYSQL_DB_PASSWORD']);

/** MySQL hostname */
define('DB_HOST', $_ENV['OPENSHIFT_MYSQL_DB_HOST'] . ':' . $_ENV['OPENSHIFT_MYSQL_DB_PORT']);

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');




$db ='mysql:host='.DB_HOST.';dbname='.DB_NAME;
$user = DB_USER;
$pass = DB_PASSWORD;

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