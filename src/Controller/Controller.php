<?php


namespace App\Controller;


use App\Model\ModelRepository;

abstract class Controller
{
    /**
     * @var ModelRepository
     */
    protected $modelRepository;

    public function __construct($modelRepository) {
        $this->modelRepository = $modelRepository;
    }
}