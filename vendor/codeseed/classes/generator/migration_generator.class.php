<?php
class MigrationGenerator extends Generator {
	protected $template = '<?php
class <class> extends Migration {
	public function up() {

	}

	public function down() {

	}
}

';
	private $from;
	private $table_template = '<?php
class Create<class> extends Migration {
	public function up() {
		$this->create_table(\'<table>\');
		// $this->add_column(array(\'table\' => \'<table>\', \'name\' => \'name\', \'type\' => \'string\', \'is_null\' => true, \'size\' => \'255\'));
	}

	public function down() {
		$this->drop_table(\'<table>\');
	}
}

';

	public function __construct($name, $from = '') {
		parent::__construct($name);
		$this->path = Config::get('migr_dir');
		$this->from = $from;
		if ($this->from == 'model') {
			$this->template = $this->table_template;
		}
	}

	public function get_filename() {
		$this_time = date('YmdHis');
		if ($this->from == 'model') {
			return $this_time . '_create_' . camel_to_under($this->name) . '.class.php';
		}
		return $this_time . '_' . camel_to_under($this->name) . '.class.php';
	}

	public function get_contents() {
		$table = camel_to_under($this->name);
		$class = under_to_camel($this->name);
		$result = str_replace('<table>', $table, $this->template);
		$result = str_replace('<class>', $class, $result);
		return $result;
	}
}

