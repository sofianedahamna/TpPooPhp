<?php

namespace Digi\Keha\Kernel;
use Digi\Keha\Configuration\Config;

class Db extends \PDO {
    private static $instance = null;

    protected function __construct()
    {
        try {
            parent::__construct(Config::DSN, Config::USER, Config::PASS);
        } catch(\PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance()
    {
        if(self::$instance === null) {
            self::$instance = new static();
        }
        return self::$instance;
    }
}