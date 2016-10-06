<?php

class AddBoatForm{

  private $memberId;

  public function __construct($memberId){
    $this->memberId = $memberId;
  }

  public function show(){
    return "
    <form action='?action=addBoat' method='POST'>

    <input type='hidden' name='memberId' value='{$this->memberId}'>

    <legend>Length
      <input type='text' name='length' size=3>
    </legend>

    <legend>Type
      <input type='radio' name='type' value='Sailboat'>
      <input type='radio' name='type' value='Motorsailer'>
      <input type='radio' name='type' value='kayak/Canoe'>
      <input type='radio' name='type' value='Other'>
    </legend>

    <legend>Personal identity number
      <input type='text' name='personalNumber'>
    </legend>

    <input type='submit' name='RegisterMember'>
    ";
  }
}
