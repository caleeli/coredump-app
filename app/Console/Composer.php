<?php

namespace App\Console;

use Composer\Script\Event;
use Composer\Installer\InstallerEvent;

class Composer
{

    public static function predependenciessolving(InstallerEvent $event)
    {
        //var_dump(get_class_methods($event));
    }

    public static function postdependenciessolving(InstallerEvent $event)
    {
        //var_dump($event->getOperation()->getPackage()->getName());
        foreach($event->getOperations() as $operation) {
            //var_dump(($operation->getPackage()->getName()));
        }
        //var_dump(gettype($event->getRequest()->getJobs()));
        //var_dump($event->getName());
    }

    public static function __callStatic($name, $arguments)
    {
        //var_dump($name);
    }

}

/*

string(11) "__construct"
[1]=>
string(11) "getComposer"
[2]=>
string(5) "getIO"
[3]=>
string(9) "isDevMode"
[4]=>
string(9) "getPolicy"
[5]=>
string(7) "getPool"
[6]=>
string(16) "getInstalledRepo"
[7]=>
string(10) "getRequest"
[8]=>
string(13) "getOperations"
[9]=>
string(7) "getName"
[10]=>
string(12) "getArguments"
[11]=>
string(8) "getFlags"
[12]=>
string(20) "isPropagationStopped"
[13]=>
string(15) "stopPropagation"

*/
