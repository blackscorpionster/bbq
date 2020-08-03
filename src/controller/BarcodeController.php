<?php
declare(strict_types=1);

namespace src\controller;

use src\bbq\ActionHandler;
use src\bbq\DbHandler;

class BarcodeController
{
    private ActionHandler $actionHandler;

    private DbHandler $dbHandler;

    public function __construct(ActionHandler $actionHandler, DbHandler $dbHandler)
    {
        $this->actionHandler = $actionHandler;
        $this->dbHandler = $dbHandler;
    }

    public function save() {
        $data = $this->actionHandler->getJsonData();

        //$this->dbHandler->runRawSql("SELECT * FROM sysuser;");die("Boom");
        //$user = $this->dbHandler->runNativeSql("SELECT * FROM sysuser where email = :?;", 'ebuneli@gmail.com');
        //print_r($user);die("SELECT");
        $this->dbHandler->runNativeSql("INSERT INTO barcodex(code) VALUES (:?);", 'hihiasdi');
        return json_encode(['code' => 200, 'message' => 'saved']);
    }
}
