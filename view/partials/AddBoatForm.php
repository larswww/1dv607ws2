<?php

class AddBoatForm{

  private $memberId;

  public function __construct(){
    $this->memberId = $_GET['memberId'];
  }

  public function show(){
    return "
    <form action='?action=addBoat' method='POST'>

    <input type='hidden' name='memberId' value='{$this->memberId}'>

    <legend>Length
      <input type='text' name='length' size=3>
    </legend>

    <legend>Boat Type<br>
      <label><input type='radio' name='type' value='Sailboat'>Sailboat</label><br>
      <label><input type='radio' name='type' value='Motorsailer'>Motorsailer</label><br>
      <label><input type='radio' name='type' value='Kayak/Canoe'>Kayak/Canoe</label><br>
      <label><input type='radio' name='type' value='Other'>Other</label>
    </legend>

    <input type='submit' value='Add boat'>
    ";
  }
}
