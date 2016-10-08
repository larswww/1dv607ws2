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

    Boat Type<br>
      <legend><input type='radio' name='type' value='Sailboat'>Sailboat</legend><br>
      <legend><input type='radio' name='type' value='Motorsailer'>Motorsailer</legend><br>
      <legend><input type='radio' name='type' value='Kayak/Canoe'>Kayak/Canoe</legend><br>
      <legend><input type='radio' name='type' value='Other'>Other</legend>
    
    <input type='submit' value='Add boat'>
    ";
  }
}
