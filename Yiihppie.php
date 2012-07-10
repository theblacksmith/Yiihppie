<?php

Yii::import('ext.yiihppie.vendors.HamlPHP.src.HamlPHP.HamlPHP');
Yii::import('ext.yiihppie.vendors.HamlPHP.src.HamlPHP.Lang.Helpers', true);
		
class Yiihppie extends CViewRenderer {
	
	/**
	 * @var string the extension name of the source file. Defaults to '.haml'.
	 */
	public $fileExtension = '.haml';
	/**
	 * @var string the extension name of the view file. Defaults to '.php'.
	 */
	public $viewFileExtension = '.php';
	
	/**
	 * @var HamlPHP
	 */
	private $_parser;

	/**
	 * @var FileStorage
	 */
	private $_fileStorage;

	private $isInitialized;
	
	private function _init() {
		$this->_parser = new HamlPHP();

		$this->isInitialized = true;
	}

	/**
	 * Parses the source view file and saves the results as another file.
	 * @param string $sourceFile the source view file path
	 * @param string $viewFile the resulting view file path
	 */
	protected function generateViewFile($sourceFile, $viewFile) {
		
		if (substr($sourceFile, strlen($this->fileExtension) * -1) === $this->fileExtension) {
			if ($this->_parser == null)
				$this->_init();

			$data = $this->_parser->parseFile($sourceFile);
		} else {
			$data = file_get_contents($sourceFile);
		}
		file_put_contents($viewFile, $data);
	}

	/**
	 * Renders a view file.
	 * This method is required by {@link IViewRenderer}.
	 * @param CBaseController $context the controller or widget who is rendering the view file.
	 * @param string $sourceFile the view file path
	 * @param mixed $data the data to be passed to the view
	 * @param boolean $return whether the rendering result should be returned
	 * @return mixed the rendering result, or null if the rendering result is not needed.
	 */
	public function renderFile($context, $sourceFile, $data, $return)
	{
		$hamlSourceFile = substr($sourceFile, 0, strrpos($sourceFile, '.')).$this->fileExtension;
		
		if(!is_file($hamlSourceFile) || ($file=realpath($hamlSourceFile))===false) {
			return parent::renderFile($context, $sourceFile, $data, $return);
		}
		
		$viewFile = $this->getViewFile($sourceFile);
		
		$viewFile = str_replace($this->fileExtension.($this->useRuntimePath?'':'c'), $this->viewFileExtension, $viewFile);
		
		if (@filemtime($sourceFile) > @filemtime($viewFile))
		{
			$this->generateViewFile($sourceFile, $viewFile);
			@chmod($viewFile, $this->filePermission);
		}
		
		return $context->renderInternal($viewFile, $data, $return);
	}

}