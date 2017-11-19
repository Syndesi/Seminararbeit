<?php
// path of current file: /api/lib/propel.php
namespace lib;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Propel\Runtime\Propel;
use Propel\Generator\Application;

class PropelCommandWrapper {

  /**
   * Constructs the needed app and sets some options.
   * Code is adapted from {@link https://github.com/propelorm/Propel2/blob/master/bin/propel.php|Propel 2}
   */
  public function __construct(){
    $finder = new Finder();
    $finder->files()->name('*.php')->in(__DIR__.'/../../vendor/propel/propel/src/Propel/Generator/Command')->depth(0); // path adjusted to the location of this file
    $this->app = new Application('Propel', Propel::VERSION);
    $ns = '\\Propel\\Generator\\Command\\';
    foreach ($finder as $file){
      $r = new \ReflectionClass($ns.$file->getBasename('.php'));
      if($r->isSubclassOf('Symfony\\Component\\Console\\Command\\Command') && !$r->isAbstract()){
        $this->app->add($r->newInstance());
      }
    }
    $this->app->setAutoExit(false);
  }

  /**
   * Runs an command from propel, additional documentation is found {@link https://symfony.com/doc/current/console/command_in_controller.html|here}.
   * @param  array $input ['command' => 'sql:build', '--overwrite' => null]
   * @return string       the resulting string from the original command (often nothing)
   */
  public function run($input){
    $input = new ArrayInput($input);
    // change the current directory to the project's main folder
    chdir(realpath(__DIR__.'/../../'));
    $output = new BufferedOutput();
    $this->app->run($input, $output);
    return $output->fetch();
  }
}

?>