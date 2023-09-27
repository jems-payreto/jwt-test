<?php
    function shouldIncludeEnv() {
        global $shouldIncludeEnv;

        if(isset($shouldIncludeEnv)) {
            return $shouldIncludeEnv;
        } else {
            return true;
        }
    }

    function shouldIncludeConn() {
        global $shouldIncludeConn;

        if(isset($shouldIncludeConn)) {
            return $shouldIncludeConn;
        } else {
            return true;
        }
    }

    function shouldIncludeFunction() {
        global $shouldIncludeFunction;

        if(isset($shouldIncludeFunction)) {
            return $shouldIncludeFunction;
        } else {
            return true;
        }
    }

    function shouldIncludeToken() {
        global $shouldIncludeToken;

        if(isset($shouldIncludeToken)) {
            return $shouldIncludeToken;
        } else {
            return true;
        }
    }

    function shouldIncludeVendor() {
        global $shouldIncludeVendor;

        if(isset($shouldIncludeVendor)) {
            return $shouldIncludeVendor;
        } else {
            return true;
        }
    }

    if(shouldIncludeEnv()) {
        require_once __DIR__ . '../../api/functions/env.php';
    }

    if(shouldIncludeConn()) {
        require_once __DIR__ . '../../api/functions/conn.php';
    }

    if(shouldIncludeFunction()) {
        require_once __DIR__ . '../../api/functions/function.php';
    }

    if(shouldIncludeToken()) {
        require_once __DIR__ . '../../api/functions/token.php';
    }

    if(shouldIncludeVendor()) {
        require_once __DIR__ . '../../../vendor/autoload.php';
    }
?>