<?php

namespace Core\Libs;

class DB extends \mysqli
{

    public function __construct ()
    {
        $db_config = require_once __DIR__ . '/../../config/db.php';

        return parent::__construct($db_config['host'], $db_config['user'], $db_config['password'], $db_config['database']);
    }

    public function __destruct ()
    {
        $this->close();
    }

}
