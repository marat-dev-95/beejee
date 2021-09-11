<?php
namespace App\Model;

class ModelRepository
{
    private $PDO;
    private $model;
    private $columns;
    private $orderByColumn = 'id';
    private $orderBy = 'ASC';

    public function __construct(array $config) {
        $PDO = new \PDO('sqlite:'.$config['sqlite']['path']);
        $this->PDO = $PDO;
    }

    public function setModel(string $model) {
        $this->model = $model;
        return $this;
    }

    public function columns(array $columns = []) {
        $this->columns = $columns;
        return $this;
    }

    public function orderBy(string $orderByColumn, $by = 'ASC') {
        $this->orderBy = ($by === 'DESC')?'DESC':'ASC';
        $this->orderByColumn = $orderByColumn;
        return $this;
    }

    public function paginate($currentPage, $perPage) {
        $offset = ($currentPage - 1) * $perPage;

        $columns = $this->columns?join(",", $this->columns):"*";

        $sql = "SELECT $columns FROM ".$this->model::getTableName()." ORDER BY ".$this->orderByColumn." ".$this->orderBy." LIMIT $offset, $perPage";

        $statement = $this->PDO->prepare($sql);
        $statement->execute();
        $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $result = [];
        if(count($rows)) {
            foreach($rows as $row) {
                $model = new $this->model;
                foreach($row as $columnName => $columnValue) {
                    $model->{$columnName} = $columnValue;
                }
                $result[] = $model;
            }
        }

        return $result;
    }

    public function count() {
        $sql = "SELECT COUNT(*) FROM ".$this->model::getTableName();

        $statement = $this->PDO->prepare($sql);
        $statement->execute();

        return $statement->fetchColumn();
    }

    public function create(array $columns = []) {
        $columnNames = join(",",array_keys($columns));

        $paramNames = join(",",array_map(function($column) {
            return ":".$column;
        }, array_keys($columns)));

        $sql  = "INSERT INTO ".$this->model::getTableName()."($columnNames) VALUES($paramNames)";
        $statement = $this->PDO->prepare($sql);

        foreach($columns as $columnName => $value) {
            $statement->bindValue(":".$columnName, $value);
        }
        $statement->execute();
    }

    public function find($id) {
        $columns = $this->columns?join( ",", $this->columns):"*";

        $sql = "SELECT $columns FROM ".$this->model::getTableName()." WHERE id=$id";

        $statement = $this->PDO->prepare($sql);
        $statement->execute();
        $row = $statement->fetch(\PDO::FETCH_ASSOC);

        $model = new $this->model;
        foreach($row as $columnName => $columnValue) {
            $model->{$columnName} = $columnValue;
        }

        return $model;
    }

    public function update(int $id, array $columns) {
        $paramNames = join(",",array_map(function($column) {
            return $column."=:".$column;
        }, array_keys($columns)));

        $sql  = "UPDATE ".$this->model::getTableName()." SET $paramNames WHERE id=$id";
        $statement = $this->PDO->prepare($sql);

        foreach($columns as $columnName => $value) {
            $statement->bindValue(":".$columnName, $value);
        }
        $statement->execute();
    }
}