<?php
  interface ITimeOffRequest {
    public function addTimeOffRequest();
    public function setTimeOffRequestStatus();
    public static function getAllTimeOffRequests();
  }