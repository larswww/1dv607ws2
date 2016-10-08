<?php

class UpdateBoatForm{

  private $boatId;
  private $length;
  private $type;

  public function __construct($boatId, $length, $type){
    $this->boatId = $boatId;
    $this->length = $length;
    $this->type = $type;
  }

  public function show(){
    return "
    <form action='?action=editBoat' method='POST'>

    <input type='hidden' name='boatId' value='{$this->boatId}'>

    <legend>Length
      <input type='text' name='length' size=3>
    </legend>

    <legend>Type
      <label><input type='radio' name='type' value='Sailboat'>Sailboat</label>
      <label><input type='radio' name='type' value='Motorsailer'>Motorsailer</label>
      <label><input type='radio' name='type' value='Kayak/Canoe'>Kayak/Canoe</label>
      <label><input type='radio' name='type' value='Other'>Other</label>
    </legend>

    <input type='submit' value='Update boat'>
    ";
  }
}
