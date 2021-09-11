<?php
namespace App\Model;

class Task extends Model
{
    protected static $table = 'tasks';

    public function isDone() {
        return boolval($this->status);
    }
    public function isEdited() {
        return boolval($this->is_edited);
    }
}