<?php 
abstract class Model 
{
    public abstract function save();
    public abstract function update();
    public abstract function delete();
    protected abstract function getTableName(): string;

    public function find(int $id)
    {
        $database = new Database();
        $sql = "SELECT * FROM " . $this->getTableName() . " WHERE id={$id}";

       if($database->connect()->query($sql))
       {
            $numRows = $database->num_rows;

            if($numRows > 0)
            {
                //moet misschien een [0] aan t einde hebben om de eerste op te halen
                return $database->fetch_assoc();
            }
            else
            {
                return [];
            }
        }
    }

    public function get($extra)
    {
        $db = new Database();
        $sql = "SELECT * FROM " . $this->getTableName() . " " . $extra;
        $result = $db->connect()->query($sql);

        $numRows = $result->num_rows;
        
        if($numRows > 0)
        {
            while ($row = $result->fetch_assoc()) 
            {
               $data[] = $row;
            }

            return $data;
        }
        else
        {
            return "";
        }
    }
}
?>