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
        /**
         * \mysqli Konstruktor aufrufen
         */
        return parent::__construct(config('db.host'), config('db.user'), config('db.password'), config('db.database'));
    }

    public function __destruct ()
    {
        /**
         * Verbindung automatisch schließen, wenn das Objekt gelöscht wird
         */
        $this->close();
    }

}
