<?php

function setCorsHeaders() {
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding");
  header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT");
}
