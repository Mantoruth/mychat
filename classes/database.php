<?php  

class Database
{
    private $con;

    // Constructor
    function __construct()
    {
        $this->con = $this->connect();
    }

    // Connect to database
    private function connect()
    {
        $string = "mysql:host=localhost;dbname=mychat;charset=utf8"; // Added charset for better compatibility
        try {
            $connection = new PDO($string, DBUSER, DBPASS);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode
            return $connection;
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }
    }

    // Writing to database
    public function write($query, $data_array = [])
    {
        try {
            $statement = $this->con->prepare($query); // Use $this->con

            foreach ($data_array as $key => $value) {
                $statement->bindParam(':' . $key, $data_array[$key]); // Bind parameters
            }

            return $statement->execute(); // Return the result of execution
        } catch (PDOException $e) {
            // Log the error
            error_log("SQL Error: " . $e->getMessage());
            return false;
        }
    }

    // Generate a random user ID
    public function generate_id($max)
    {
        $rand = "";
        $rand_count = rand(4, $max);
        for ($i = 0; $i < $rand_count; $i++) {
            $r = rand(0, 9);
            $rand .= $r;
        }
        return $rand;
    }
}
