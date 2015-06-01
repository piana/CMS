<?php /*windu.org database*/

class DB
{
	/**
	 * @var PDO
	 */
	private static $instance = array();

	public static function getInstance($instanceName = FILE_DB_FILE,$customMySQL=array())
	{
		if (DB_TYPE=='mysql' or $customMySQL!==array()) {
			if ($customMySQL!=array()) {
				self::$instance[$instanceName] = new PDO('mysql:host='.$customMySQL['DB_HOST'].';port='.$customMySQL['DB_PORT'].';dbname='.$customMySQL['DB_NAME'],$customMySQL['DB_USER'],$customMySQL['DB_PASSWORD']);
			}elseif ( !isset(self::$instance[$instanceName]) ){
				try
				{
					self::$instance[$instanceName] = new PDO('mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME,DB_USER,DB_PASSWORD);
				}
				catch( PDOException $e )
				{
					die('Pdo error: ' . $e->getMessage() );
				}
				catch( Exception $e )
				{
					die('Normal exception: ' . $e->getMessage() );
				}
				//self::$instance[$instanceName]->query('set names "utf8"');
			}
			self::$instance[$instanceName]->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			self::$instance[$instanceName]->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_NATURAL);
		}else{
			if ( !isset(self::$instance[$instanceName]) )
			{
				try
				{
					self::$instance[$instanceName] = new PDO('sqlite:'.FILE_DB_PATH.$instanceName);
				}
				catch( PDOException $e )
				{
					die('Pdo error: ' . $e->getMessage() );
				}
				catch( Exception $e )
				{
					die('Normal exception: ' . $e->getMessage() );
				}
					
				self::$instance[$instanceName]->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				self::$instance[$instanceName]->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_NATURAL);
			}
		}

		return self::$instance[$instanceName];
	}
	public static function vacuum() {
		if (DB_TYPE=='sqlite') {
			$db = self::getInstance();
			$db->query('VACUUM');
				
			$db = self::getInstance(FILE_DB_LOG_FILE);
			$db->query('VACUUM');
				
			return 'Database vacuum succes';
		}
	}
	private function __clone(){}

}

?>
