<?php

class Error {

  private $message;

  public function __construct($message = ""){
    $this->message = $message;
  }

  public function show(){
    return "
      Something went wrong:
      <span class='errormessage'>{$message}</span>
    ";
  }
}
