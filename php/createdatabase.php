<?php
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

$sql = "
create table Students(ID int auto_increment , name varchar (20), grade double, constraint pk_ID primary key (ID));
create table Likes(like_ID int, liked_ID int);
create table News(ID int auto_increment , name varchar (20), time datetime , constraint pk_ID primary key (ID));
insert into Students (ID,name,grade) values
( null ,'Alex',9.99),
( null ,'Bob',8.99),
( null ,'Steve',7.99),
( null ,'Mike',6.99),
( null ,'John',5.99),
( null ,'Andy',4.99),
( null ,'Frank',3.99),
( null ,'Isabella',2.99),
( null ,'Emma',1.99),
( null ,'Sophia',0.99);
insert into Likes(like_ID,liked_ID) values
(1,2),
(1,3),
(1,10),
(2,5),
(3,5),
(4,6),
(5,7);
insert into Likes(like_ID,liked_ID) values(3,2);
insert into Likes(like_ID,liked_ID) values(4,5);
insert into Likes(like_ID,liked_ID) values(4,3);
insert into Likes(like_ID,liked_ID) values(1,9);
";


//Connection
try{
    $pdo = new PDO($db,$user,$pass,$options);

}
catch (PDOException $e) {
    print "Connection Error!: " . $e->getMessage() . "<br/>";
    die();
}


try{
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}
catch (Exception $e){
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
