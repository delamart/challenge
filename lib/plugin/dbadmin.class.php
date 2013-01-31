<?php

class DbadminPluginLib {
 	
 	const TABLE_REVISION = '_revision';
 	const SQL_CREATE_REVISION_TABLE = 'CREATE TABLE `_revision` (
 	  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 	  `nb` int(10) unsigned NOT NULL,
 	  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP,
 	  PRIMARY KEY (`id`),
 	  KEY `nb` (`nb`)
 	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8';
 
 
	public function __construct() {
		$this->db = DbLib::getInstance();
	}
	
	public function source_path() { return dirname(__FILE__) . DIRECTORY_SEPARATOR . 'dbadmin'; }
	public function scripts_path() { return $this->source_path() . DIRECTORY_SEPARATOR . 'scripts'; }
	public function sql_path() { return $this->source_path() . DIRECTORY_SEPARATOR . 'sql'; }
 
 	public function __call($method, $arguments) {
 		throw new Exception("Method: $method is not supported.");
 	}
 
	public function info() {	
		$out = '';
	
		$rev = $this->get_revision();
		$out .= "Revision: " . ($rev===false?'none':$rev) . "\n\n";
	
		$out .= "Tables:\n";		
		foreach($this->get_tables() as $table) 
		{
			$out .= "\t$table";
			$stmt2 = $this->db->query(sprintf('SELECT COUNT(1) FROM `%s`', $table));
			$out .= " (" . $stmt2->fetchColumn(0) . " rows)\n";			
		}
		return $out;
	} 
	
	public function backup() {
		return "Backup not supported yet\n";
	}
	
	public function upgrade() {
		$out = '';
		
		$from = $this->get_revision();
		if($from===false) 
		{ 
			$this->create_revision_table(); 
			$out .= "created revision table \n";
		}
		
		$out .= "Current revision: $from\n";
		
		$to = $this->get_latest_revision();
		$out .= "Latest revision: $to\n";
		
		if($from != $to)		
		{
			$out .= "Upgrading to: $to... ";
			$this->up($to);
			$out .= " ...done";
		}
		else 
		{
			$out .= "Nothing to do.\n";	
		}
		
		return $out;
	}	

	public function downgrade() {
		return "Downgrade not supported yet\n";
	}
 
 	private static $cache_tables = null; 	
 	private function get_tables($cache = true) {
 		if($cache && is_array(self::$cache_tables)) {return self::$cache_tables;};
		$tables = array();		
		$stmt = $this->db->query('SHOW TABLES');		
		while(($table = $stmt->fetchColumn()) !== false) { $tables[$table] = $table; }
		self::$cache_tables = $tables;
		return $tables;
 	}
 	 
 	private function create_revision_table() {
 		if($this->table_exists(self::TABLE_REVISION)) { return null; }
 		return $this->create_table(self::SQL_CREATE_REVISION_TABLE);
 	}
 
 	private function table_exists($table) {
 		$tables = $this->get_tables();
 		return isset($tables[$table]);
 	}
 
 	private function set_revision($nb) {
 		$n = $this->get_revision();
 		if($n == $nb) { return false; }
 		$this->db->query(sprintf('INSERT INTO `%s` (nb) VALUES (%d) ',self::TABLE_REVISION,$nb));
 		return $nb;
 	}
 
 	private function get_revision() {
 		if(!$this->table_exists('_revision')) { return false; }
		$stmt = $this->db->query('SELECT `nb` FROM `'.self::TABLE_REVISION.'` ORDER BY `updated_at` DESC LIMIT 1');
		$rev = $stmt->fetchColumn(1);
		return $rev === false ? 0 : (int) $rev;
 	}
    
    private function get_latest_revision() {
    	$revisions = glob( $this->scripts_path() . DIRECTORY_SEPARATOR . 'revision.*.php');
    	$max = 0;
    	foreach($revisions as $rev)
    	{
    		$r = substr(basename($rev,'.php'),strlen('revision.'));
    		if($r > $max) { $max = $r; }
    	}
    	return $max;
    }
    
    private function up($to) {
    	$rev = $this->get_revision();
    	if($rev >= $to) { return null; }
    
    	$rev++;
    	$rev_script = $this->scripts_path() . DIRECTORY_SEPARATOR . sprintf('revision.%d.php',$rev);
    	if(!file_exists($rev_script)) { throw new Exception("Could not find revision script for revision $rev.");}
		include_once($rev_script);

		$func = sprintf('dbadmin_up_script_%d_pre',$rev);
		call_user_func($func, $this->db);

		$rev_sql = $this->sql_path() . DIRECTORY_SEPARATOR . sprintf('revision.%d.sql',$rev);
		if(file_exists($rev_sql)) 
		{
			$this->db->query(file_get_contents($rev_sql)); 
	 		$this->get_tables(false); //refresh cache	
		}
		
		$func = sprintf('dbadmin_up_script_%d_post',$rev);
		call_user_func($func, $this->db);
    
    	$this->set_revision($to);
    
    	if($rev < $to) { $this->up($to); }
    	
    	return true;
    }    
    
	private function down($to) {
		throw new Exception('downgrade is not currently supported');
	}    
    
}