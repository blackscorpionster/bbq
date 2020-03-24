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
    * native sql
    *
	* @param string $statement
	* @return array
	*/
	public function runNativeSql(string $statement): array
	{
		$res = [];
        $db = $this->db;
        
		if (in_array($this->driver ,['oci8', 'oci8po'])) {
			$stmt = $db->PrepareSP($statement);
		} else {
			$stmt = $db->Prepare($statement);
        }

		$rs = $db->Execute($stmt);
		if (!$rs) {
            $db->Close();
			throw new \Exception('Problems trying to execute function :: ' . $db->ErrorMsg());
		} else {
			$res = $rs->GetRows();
			$db->Close();
			return $res;
		}
	}
	
    /**
     * This functions builds a SQL Stored sentence, depending on the db driver selected
     * @param string $fName
     * @param string $params
     * @return string $params
     */
	function buildStoredProcedure(string $fName, string $params): string
	{
		if($this->db == "oci8" || $this->db == "oci8po")
		{
			$sql = "BEGIN ".$fName."(".$params."); END;";
		}
		else
		{
			
			if($this->db == "mysql")
				$sql = "call ".$fName."(".$params.")";
			else
				$sql = "SELECT ".$fName."(".$params.")";
		}
	}
	
}
