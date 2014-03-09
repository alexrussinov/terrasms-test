<?php
/**
 * Class Students
 */
class Students{
   public $ID;
   public  $name;
   public $grade;
}

/**
 * Class Likes
 */
class Likes{
    public $like_ID;
    public $liked_ID;
}

/**
 * Class News
 */

class News{
    public $ID;
    public $name;
    public $time;

}

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
    print "Connection Error!: " . $e->getMessage() . "<br/>";
    die();
}


/**
 * Social network task A
 * @param $pdo
 */
function a($pdo){
try{
$stmt = $pdo->prepare('select s.ID, s.name, s.grade from Students s where s.ID in (
  select l.liked_ID from Likes l group by liked_ID having count(*)>1
)');
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_CLASS, "Students");
echo json_encode($result);
 }
catch (Exception $e){
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
 }
}

/**
 * Social network task B
 * @param $pdo
 */
function b($pdo){
    try{
        $stmt = $pdo->prepare('select s.ID, s.name, s.grade from Students s where s.ID  in (
                                select like_ID from Likes where liked_ID not in (
                                 select like_ID from Likes))');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_CLASS, "Students");
        echo json_encode($result);
    }
    catch (Exception $e){
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

/**
 * Social network task C
 * @param $pdo
 */
function c($pdo){
    try{
        $stmt = $pdo->prepare('select s.ID, s.name, s.grade from Students s where s.ID not in (
                               select like_ID from Likes
                               ) and s.ID not in (select liked_ID from Likes)');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_CLASS, "Students");
        echo json_encode($result);
    }
    catch(Exception $e){
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

/**
 * Fetch all students from database and serve them as JSON
 * @param $pdo
 */
function getAllStudentsAsJson($pdo){
    try{
        $stmt = $pdo->prepare('select * from Students');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_CLASS, "Students");
        echo json_encode($result);
    }
    catch(Exception $e){
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

/**
 * Fetch all likes and serve them as JSON
 * @param $pdo
 */

function getLikesAsJson($pdo){
    try{
        $stmt = $pdo->prepare('select * from Likes');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_CLASS, "Likes");
        echo json_encode($result);
    }
    catch(Exception $e){
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

//helper function

function generateResult($mc){
    $last_news = $mc->get("last_nws");
    echo json_encode($last_news);
}

/**
 * Fetch last 3 news as JSON
 * Assume that Memcached is installed and configured properly
 * @param $pdo
 *
 */
function fetchLastNewsJson($pdo){
    /*create memcached object and connect to the server*/


    $mc = new Memcached();
    $mc->addServer("localhost", 11211);



    if(!empty($last_news)){
       generateResult($mc);
    }
    else{
        try{
            $stmt = $pdo->prepare('select * from News ORDER BY ID DESC LIMIT 1,3');
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_CLASS, "News");
            $mc->set('last_nws',$result);
            generateResult($mc);

        }
        catch(Exception $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

 /* we can uncomment and use this block to compare results with and without memcached */

//    try{
//        $stmt = $pdo->prepare('select * from News ORDER BY ID DESC LIMIT 1,3');
//        $stmt->execute();
//        $result = $stmt->fetchAll(PDO::FETCH_CLASS, "News");
//        echo json_encode($result);
//    }
//    catch(Exception $e){
//        print "Error!: " . $e->getMessage() . "<br/>";
//        die();
//    }


}


if ($_GET['data']==='students'){
    getAllStudentsAsJson($pdo);
}


if ($_GET['data']==='likes'){
    getLikesAsJson($pdo);
}

if ($_GET['data']==='case1'){
    a($pdo);
}

if ($_GET['data']==='case2'){
    b($pdo);
}

if ($_GET['data']==='case3'){
    c($pdo);
}

if ($_GET['data']==='news'){
    fetchLastNewsJson($pdo);
}




