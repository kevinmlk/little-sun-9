<?php 

class HubLocation {
    public $id;
    public $data;

    
    public function __construct($id, $data) {
        $this->id = $id;
        $this->data = $data;
    }
}