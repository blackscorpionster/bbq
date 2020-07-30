<?php
declare(strict_types=1);
namespace src\bbq;

require_once('vendor/smarty/smarty/libs/Smarty.class.php');

class TemplateHandler {
    private Object $engine;
    private string $template;

    public function __construct() {
        $this->engine = new \Smarty();

        $this->engine->setTemplateDir('src/assets/views/templates/');
		$this->engine->setCompileDir('src/assets/views/templates_c/');
		$this->engine->setConfigDir('src/assets/views/templates_conf/');
        $this->engine->setCacheDir('src/assets/views/templates_cache/');

        // Enable to confirm that the directories above are correctly set up
        //$this->engine->testInstall();
    }

    public function setTemplate(string $template): TemplateHandler {
        $this->template = $template;
        return $this;
    }

    public function getHandler(): Object
    {
        return $this->engine;
    }

    public function render() {
        $this->engine->display($this->template);
    }
}
