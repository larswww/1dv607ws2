<?php

class IncomingParams {

  public $noIncomingParams;

  public function __construct(){
    $this->noIncomingParams = (empty($_POST)) ? true : false;

    foreach ($_POST as $key => $value) {
			$this->$key = $value;
		}
  }
}
