<?php
// ローカル Docker 用 (docker/entrypoint.sh が app/Config/database.php として配置)
class DATABASE_CONFIG {

	public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'db',
		'login' => 'duel',
		'password' => 'duel',
		'database' => 'duel_h',
		'prefix' => '',
		'encoding' => 'utf8',
	);

	public $test = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'db',
		'login' => 'duel',
		'password' => 'duel',
		'database' => 'duel_h_test',
		'prefix' => '',
		'encoding' => 'utf8',
	);

	public function __construct() {
		foreach (array('default', 'test') as $name) {
			$this->{$name}['host'] = getenv('DB_HOST') ?: $this->{$name}['host'];
			$this->{$name}['login'] = getenv('DB_USER') ?: $this->{$name}['login'];
			$this->{$name}['password'] = getenv('DB_PASSWORD') ?: $this->{$name}['password'];
		}
		$this->default['database'] = getenv('DB_NAME') ?: $this->default['database'];
	}
}
