<?php

namespace Core\Libs;

class DB extends \mysqli
{

    public function __construct ()
    {
        return parent::__construct(config('db.host'), config('db.user'), config('db.password'), config('db.database'));
    }

    public function __destruct ()
    {
        $this->close();
    }

}
