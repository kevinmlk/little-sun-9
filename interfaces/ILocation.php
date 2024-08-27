<?php

interface ILocation {
  // Function to add hub locations
  public function addHubLocation();

  // Function to edit hub locations
  public function editHubLocation();

  // Function to remove hub locations
  public function deleteHub();

  // Function to get all the current hubs from the db
  public static function getAllHubs();
}