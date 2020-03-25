<?php
declare(strict_types=1);
namespace src\bbq;

use src\config\App;
//If using Adodb, use this constant to define the case used in the results keys
if(!defined('ADODB_ASSOC_CASE')){
	define('ADODB_ASSOC_CASE',1); // 1 UpperCase, 0 LowerCase, 2 As written on the SQL sentence
}

//Db abstraction layer, does not support namespaces and autoload but works perfectly
require_once('vendor/adodb/adodb-php/adodb.inc.php');

class DbHandler
{
	protected $host = App::APP_DB_HOST;
	protected $user = App::APP_DB_USER;
	protected $password = App::APP_DB_PASSWORD;
	protected $databaseName = App::APP_DB_NAME;
	protected $driver = App::APP_DB_DRIVER;
	public $db;
	
	public function __construct() 
	{
		$dbconexion = ADONewConnection($this->driver);
		$dbconexion->setFetchMode(ADODB_FETCH_ASSOC);
		$dbconexion->Connect($this->host, $this->user, $this->password, $this->databaseName);
		$dbconexion->EXECUTE("set names 'utf8'");
		$this->db = $dbconexion;
	}

	/**
    * Safely runs sql statements
    *
    * how to run native queries: e.g.
    * 
    * Using pure SQL:
    * $this->runNativeSql("SELECT * FROM app_user WHERE cod_user =4")
    *
    * Using unpacked arrays:
    * $this->runNativeSql("SELECT * FROM app_user WHERE cod_user in (:?, :?) and cod_state = :?", ...[3, 4, 1]);
    *
    * Using variable arguments:
    * $this->runNativeSql("SELECT * FROM app_user WHERE cod_user in (:?, :?) and cod_state = :?", 3, 4, 1);
    *
    * Using variable arguments of diferent datatype: (works as an unpacked array too)
    * runNativeSql("SELECT * FROM app_user WHERE cod_user in (:?, :?) and cod_state = :? and cod_country = :?", 3, 4, 1, 'CO');
    *
	* @param string $statement
	* @return array
	*/
	public function runNativeSql(string $statement, ...$params): array
	{
		$res = [];
        $db = $this->db;

        $sql = $db->addQ(empty($params) ? $statement : $this->prepareSql($statement));

        $stmt = $db->Prepare($sql);
    
		$rs = $db->Execute($stmt, $params);
		if (!$rs) {
            echo("failed");
            $db->Close();
			throw new \Exception('Problems trying to execute query :: ' . $db->ErrorMsg());
		} else {
            echo("succeeded");
			$res = $rs->GetRows();
			$db->Close();
			return $res;
		}
	}
    
    /**
     * Replaces all special character placeholders (:?) with param placeholders compatible with the driver in use
     * @param string
     * @return string
     */
    private function prepareSql(string $preSql): string {
        $queryParts = explode('?', $preSql);
        $mappedQuery = array_map(fn(int $idx, string $sqlPart) =>
                str_replace(':', $this->db->param("param" . (string)$idx), $sqlPart) ,
                array_keys($queryParts), $queryParts
        );

        return implode(' ', $mappedQuery);
    }
	
}
