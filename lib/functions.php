<?php
/**
 * Checks if the given parameters are set. If one of the specified parameters is not set,
 * die() is called.
 *
 * @param $parameters The parameters to check.
 */

function checkGETParametersOrDie($parameters) {
    foreach ($parameters as $parameter) {
        isset($_GET[$parameter]) || die("'$parameter' parameter must be set by GET method.");
    }
}

/*
checkGETParametersOrDie(['username', 'password']);

$username = $_GET['username'];
$password = $_GET['password'];
*/


?>
