<?php

class IncomingParams {

  public function __construct(){
    foreach ($_POST as $key => $value) {
			$this->$key = $value;
		}
  }
}
