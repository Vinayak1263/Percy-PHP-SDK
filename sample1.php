<?php
   require_once('vendor/autoload.php');
   require('percysdkv1.php');
   use Facebook\WebDriver\Remote\RemoteWebDriver;
   use Facebook\WebDriver\WebDriverBy;
   use Facebook\WebDriver\WebDriverExpectedCondition;
    function executeTestCase($caps) {
        $web_driver = RemoteWebDriver::create(
            "https://username:access_key@hub-cloud.browserstack.com/wd/hub",
            $caps
        );
        try{
            $web_driver->get("https://browserstack.com/");
            percy_snapshot($web_driver ,'browserstack home page');

            $web_driver->get("https://bstackdemo.com/");
            percy_snapshot($web_driver ,'bstack demo home page');
           
        }
        catch(Exception $e){
            echo 'Message: ' .$e->getMessage();
        }
        $web_driver->quit();

       
        //is_percy_enabled();
        //fetch_percy_dom();
    }
    $caps = array(
       
        array(
            'bstack:options' => array(
                "osVersion" => "10.0",
                "deviceName" => "Samsung Galaxy S20",
                "realMobile" => "true",
                "buildName" => "BStack PHP ",
                "sessionName" => "Thread 1",
                "local" => "false",
                "seleniumVersion" => "4.0.0",
            ),
            "browserName" => "Chrome",
            "browserVersion" => "latest",
        ),
    );
    foreach ( $caps as $cap ) {
        executeTestCase($cap);
    }
?>
