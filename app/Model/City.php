<?php 

namespace App\Model;

use App\Utils\Sanitize;

class City {

    private $conn;
    private $table_name = 'city';

    public $city_id;
    public $city_country;
    public $city_name;
    public $city_code;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create($cities) {

        try {
            $query = "INSERT INTO $this->table_name 
                (city_country, 
                city_name, 
                city_code) 
                VALUES ";
                
            foreach ($cities as $key => $city) {
                $city_country = Sanitize::clearString($city['sgPais']);
                $city_name = Sanitize::clearString($city['noCidade']);
                $city_code = Sanitize::clearString($city['coCidade']);

                $query .= "('$city_country', 
                    '$city_name',
                    '$city_code'),";
            }

            $query = substr($query, 0, -1);
            $stmt = $this->conn->prepare($query);

            if ($stmt->execute()) {
                return number_format($stmt->rowCount(), 0, ',', '.') . ' cidades inseridas!';
            }

        } catch (\PDOException $e) {
            return "Erro: " . $e->getMessage();
        }
    }

    public function readCities($sgPais) {
        try {
            $query = "
                SELECT 
                    DISTINCT
                    city_name
                FROM $this->table_name
                WHERE
                    city_country = '$sgPais'
                ";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);

        } catch (\PDOException $e) {
            return "Erro: " . $e->getMessage();
        }
    }

    public function getCitiesSumary() {
        try {
            $query = "
                SELECT city_country, count(city_id) as total 
                FROM $this->table_name 
                GROUP BY city_country 
                ORDER BY 2 desc
                ";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);

        } catch (\PDOException $e) {
            return "Erro: " . $e->getMessage();
        }
    }

}
