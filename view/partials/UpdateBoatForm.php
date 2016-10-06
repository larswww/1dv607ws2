<?php

class UpdateBoat{

  private $memberId;
  private $length;
  private $type;

  public function __construct($memberId, $length, $type){
    $this->memberId = $memberId;
    $this->length = $length;
    $this->type = $type;
  }

  public function show(){
    return "
    <form action='?action=editBoat' method='POST'>

    <input type='hidden' name='memberId' value='{$this->memberId}'>

    <legend>Length
      <input type='text' name='length' size=3>
    </legend>

    <legend>Type
      <input type='radio' name='type' value='Sailboat'>
      <input type='radio' name='type' value='Motorsailer'>
      <input type='radio' name='type' value='Kayak/Canoe'>
      <input type='radio' name='type' value='Other'>
    </legend>

    <legend>length:
      <input type='text' name='length'>
    </legend>

    <input type='submit' value='Update boat'>
    ";
  }
}
