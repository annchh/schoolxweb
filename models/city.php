<?php

class City
{
    private $conn;
    private $table_name = "city";

    public $id;
    public $name;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function get($kol, $art)
    {

        $query = "SELECT * FROM " . $this->table_name . " LIMIT $kol OFFSET $art";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    function create()
    {

        $stmt = $this->conn->prepare("INSERT INTO " . $this->table_name . " SET name=:name");
        $this->name = htmlspecialchars(strip_tags($this->name));
        $stmt->bindParam(":name", $this->name);


        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function update(){

        $query = "UPDATE
                        " . $this->table_name . "
            SET
                name = :name,
                
            WHERE
                id = :id";

        $stmt = $this->conn->prepare($query);

        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->id=htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function delete(){

        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}