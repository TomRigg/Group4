<?php

    function connect($dbhost, $dbuser, $password, $dbname) {
        // the @ sign suppresses errors, which we handle in the next line
        @ $db = new mysqli($dbhost, $dbuser, $password, $dbname);
    
        // check if there was an error connecting to the database
        if ($db->connect_errno) {
            reportErrorAndDie("Oops! We could not connect to the database.<p>\n This was the error we found: " .
            $db->connect_error . "\n <p>Please <a href='input.php'>try again</a>");
        }
        
        return $db;
    }

    function reportErrorAndDie($errorMessage, $queryStr = '') {
        echo $errorMessage;
        if (strlen($queryStr) > 0) {
            echo "<p>";
            echo "Query string: " . $queryStr;
        }
        die();
    }
    
    function getSalt() {
        $salt = sprintf('$2a$%02d$', 12);
    
        $bytes = getRandomBytes(16);
    
        $salt .= encodeBytes($bytes);

        return $salt;
    }
    
    function getRandomBytes($count) {
        $bytes = '';
    
        if(function_exists('openssl_random_pseudo_bytes') &&
            (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN')) { 
          $bytes = openssl_random_pseudo_bytes($count);
        }
    
        if($bytes === '' && is_readable('/dev/urandom') &&
           ($hRand = @fopen('/dev/urandom', 'rb')) !== FALSE) {
          $bytes = fread($hRand, $count);
          fclose($hRand);
        }
    
        if(strlen($bytes) < $count) {
          $bytes = '';
    
          
            $randomState = microtime();
            if(function_exists('getmypid')) {
              $randomState .= getmypid();
            }
          
    
          for($i = 0; $i < $count; $i += 16) {
            $randomState = md5(microtime() . $randomState);
    
            if (PHP_VERSION >= '5') {
              $bytes .= md5($randomState, true);
            } else {
              $bytes .= pack('H*', md5($randomState));
            }
          }
    
          $bytes = substr($bytes, 0, $count);
        }
    
        return $bytes;
    }
    
    function encodeBytes($input) {
        // The following is code from the PHP Password Hashing Framework
        $itoa64 = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    
        $output = '';
        $i = 0;
        do {
          $c1 = ord($input[$i++]);
          $output .= $itoa64[$c1 >> 2];
          $c1 = ($c1 & 0x03) << 4;
          if ($i >= 16) {
            $output .= $itoa64[$c1];
            break;
          }
    
          $c2 = ord($input[$i++]);
          $c1 |= $c2 >> 4;
          $output .= $itoa64[$c1];
          $c1 = ($c2 & 0x0f) << 2;
    
          $c2 = ord($input[$i++]);
          $c1 |= $c2 >> 6;
          $output .= $itoa64[$c1];
          $output .= $itoa64[$c2 & 0x3f];
        } while (1);
    
        return $output;
    }

?>