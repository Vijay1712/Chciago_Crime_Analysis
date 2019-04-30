<?php
/**
 * Configuration for database connection
 *
 */
$host       = "db411.ca8pdcfdo4l2.us-east-1.rds.amazonaws.com";
$username   = "dev123";
$password   = "123456789";
$dbname     = "db411";
$dsn        = "mysql:host=$host;dbname=$dbname";
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );
