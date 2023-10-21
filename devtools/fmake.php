<?php

use Fujin\DevTools\CompilationException;
use Fujin\DevTools\LibFmake;

include 'lib/autoload.php';

$_ = new LibFmake();

if (!isset($argv[1])) {
    print_help($_);
    exit;
}

$action = "help";

if (isset($argv[1]))
{
    $action = $argv[1];
}

switch (strtolower($action)) {
    case 'compile':

        if (in_array("-v", $argv) || in_array("--verbose", $argv))
            $_->set_verbosity(true);

        if(isset($argv[2]))
        {
            try {
                $_->set_project_root($argv[2]);
            } catch (CompilationException $e) {
                echo "Could not continue compiling: {$e->getMessage()}";
                exit;
            }
        }
        else
        {
            echo "You must specify the project root, where fmake.fjmanifest is located!";
            exit;
        }  


        try {
            if ($_->compile()) { 
                $time = $_->get_compilation_time();
                echo "\nCompilation was successful [$time ms]";
            } else {
                $error = $_->get_compilation_error();
                echo "\nCompilation was not successful: $error";
            }
        } catch (CompilationException $e) {
            echo "Compilation has resulted in a catastrophal error!\n\n";
            echo $e->getMessage();
        }

    break;
    case 'new':
    break;
    case 'help':
    default:
    print_help($_);
    break;
}

function print_help(LibFmake $_) : void {
    echo "Fujin Make CLI Version {$_->get_version()} \n\n";
    echo "  fmake compile <path_to_your_project> (-v/--verbose) Compiles your project into OpenFujin-compatible executables.\n";
    echo "  fmake new (fdo/appf/kernelobject/model/kernelobject/kernelmodel) Creates a new .fsource file and updates fmake manifest.\n\n";
    echo "If you need more help, please refer to the GitHub documentation on OpenFujin\n";
}
//$_->set_mode(CompilationMode::DEVELOPMENT);
//$_->set_project_root('.');
//if($_->compile())
//    echo "Compilation was successful";
//else
//    echo "Compilation was not successful";
//
//for ($i = 0; $i < 3; $i++) {
//    $line = readline("Command: ");
//    readline_add_history($line);
//}