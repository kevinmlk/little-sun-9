<?php

interface IHub {
    public function create();
    public function delete();
    public function find($id);
}

class HubLocation implements IHub {
    public function create() {
        // Implementatie van de create-methode specifiek voor HubLocation.
    }

    public function delete() {
        // Implementatie van de delete-methode specifiek voor HubLocation.
    }

    public function find($id) {
        // Implementatie van de find-methode specifiek voor HubLocation.
    }
}

class HubManager implements IHub {
    public function create() {
        // Implementatie van de create-methode specifiek voor HubManager.
    }

    public function delete() {
        // Implementatie van de delete-methode specifiek voor HubManager.
    }

    public function find($id) {
        // Implementatie van de find-methode specifiek voor HubManager.
    }
}
