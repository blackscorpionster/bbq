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
        //print_r($data);die();
        $this->dbHandler->runNativeSql("INSERT INTO barcode(code) VALUES (:?)", $data['code']);
        return json_encode(['code' => 200, 'message' => 'saved']);
    }
}
