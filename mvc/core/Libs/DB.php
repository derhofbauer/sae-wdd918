<?php

namespace Core\Libs;

/**
 * Die DB Klasse erweitert die von PHP mitgelieferte Klasse mysqli. Das Backslash in \mysqli wird benötigt um nicht vom
 * aktuellen Namespace auszugehen (in unserem Fall Core\Libs).
 */
class DB extends \mysqli
{

    public function __construct ()
    {
        $db_config = require_once __DIR__ . '/../../config/db.php';

        /**
         * \mysqli Konstruktor aufrufen
         */
        return parent::__construct($db_config['host'], $db_config['user'], $db_config['password'], $db_config['database']);
    }

    public function __destruct ()
    {
        /**
         * Verbindung automatisch schließen, wenn das Objekt gelöscht wird
         */
        $this->close();
    }

}
