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
        // $user = $this->dbHandler->runNativeSql("SELECT * FROM sysuser where email = :?;", 'ebuneli@gmail.com');
        // print_r($user);die("SELECT");
        //$this->dbHandler->runNativeSql("INSERT INTO barcodex(value) VALUES (:?)", $data['code']);
        $this->dbHandler->runNativeSql("INSERT INTO barcode(value, userId) VALUES (:?, :?)", $data['code'], 1);
        
        // $this->dbHandler->runNativeSql("insert into barcodex (value) values (sadasdssssssasd)", []);
        //$this->dbHandler->runRawSql("insert into barcodex (value) values ('sadasdsssasd')");
        return json_encode(['code' => 200, 'message' => 'saved']);
    }
}
