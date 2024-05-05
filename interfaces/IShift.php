<?php

interface ILocation {
  // Function to add hub locations to the db
  public function addHubLocation();

  // Function to edit hub locations from the db
  public function editHubLocation();

  // Function to remove hub locations from the db
  public function removeHubLocation();

  // Function to get all the current hubs from the db
  public static function getAllHubs();
}