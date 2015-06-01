<?php /*windu.org update*/
/** 
 * @author Adam Czajkowski
 */
class updatePHP
{   
	public static function run() {
		if (config::get('licenseKey')!=null) {
			
			config::set(md5('licenceKey'.strtolower(ltrim(HOME,'www.'))),config::get('licenseKey'));
			config::set('licenseKey','');
			
			config::set(md5('licence'.HOME),config::get('license'));
			config::set('license','');			
		}
		
		if (config::get(md5('licenseKey'.HOME))!=null) {
			config::set(md5('licenseKey'.license::getDomainLink()), config::get('licenseKey'.HOME));
			config::set(md5('license'.license::getDomainLink()), config::get('license'.HOME));
		}elseif (config::get(md5('licenseKey'.str_replace('http://www.', 'http://', HOME)))!=null){
			config::set(md5('licenseKey'.license::getDomainLink()), config::get(md5('licenseKey'.str_replace('http://www.', 'http://', HOME))));
			config::set(md5('license'.license::getDomainLink()), config::get(md5('license'.str_replace('http://www.', 'http://', HOME))));
		}
		
		//set usersEkey
		$usersDB = new usersDB();
		foreach($usersDB->fetchAll() as $user){
			if ($usersDB->get($user->id, 'ekey')=='') {
				$usersDB->set($user->id, 'ekey', generate::ekey('usersDB'));
			}
		}
		
		//update contactDB
		$contactDB = new contactDB();
		$contactDB->insert();
		$contactRow = $contactDB->fetchRow(null,"id DESC");
		if(array_key_exists('telephone', $contactRow)!=1){
				
			$contactUpdateSQL = "
				ALTER TABLE contact ADD COLUMN 'telephone' varchar(60);
				ALTER TABLE contact ADD COLUMN 'mobile' varchar(60);
				ALTER TABLE contact ADD COLUMN 'adress' varchar(60);
				ALTER TABLE contact ADD COLUMN 'city' varchar(60);
				ALTER TABLE contact ADD COLUMN 'code' varchar(60);
				ALTER TABLE contact ADD COLUMN 'country' varchar(60);
				ALTER TABLE contact ADD COLUMN 'taxid' varchar(60);
				ALTER TABLE contact ADD COLUMN 'other' varchar(60);";
				
			baseDB::executeSql($contactUpdateSQL);
		}
		$contactDB->delete($contactRow->id);		

		cache::flushAllCache();
		return true;
	}
}
?>