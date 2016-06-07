<?php
namespace Rb\Robo\Task;

use Robo\Task\BaseTask;
use Robo\Common\ExecOneCommand;
use Robo\Contract\CommandInterface;
use Robo\Contract\PrintedInterface;

trait Phinx
{
    protected function taskPhinx($pathToPhinx = null)
    {
        return new PhinxTask($pathToPhinx);
    }
}

/**
 * Runs Phinx migration tool.
 *
 * ```php
 * <?php
 * $this->taskPhinx()
 *      ...
 *      ->run();
 * ?>
 * ```
 */
class PhinxTask extends BaseTask
    implements CommandInterface, PrintedInterface
{
    use ExecOneCommand;

    protected $command;
    protected $action;

    public function __construct($pathToPhinx = null)
    {
        if ($pathToPhinx) {
            $this->command = $pathToPhinx;
        } elseif (file_exists('vendor/bin/phinx')) {
            $this->command = 'vendor/bin/phinx';
            if (defined('PHP_WINDOWS_VERSION_BUILD')) {
                $this->command = 'call ' . $this->command;
            }
        } elseif (file_exists('phinx.phar')) {
            $this->command = 'php phinx.phar';
        } elseif (is_executable('~/.composer/vendor/bin/phinx')) {
            $this->command = '~/.composer/vendor/bin/phinx';
        } else {
            throw new TaskException(__CLASS__,"Neither local phinx nor global composer installation found");
        }
    }

    public function init($path = '.')
    {
        $this->action = "init $path";
        return $this;
    }

    public function create($migration)
    {
        $this->action = "create $migration";
        return $this;
    }

    public function migrate($target = null)
    {
        if ($target !== null) {
            $this->option('-t', $target);
        }

        $this->action = 'migrate';
        return $this;
    }

    public function rollback($target = null)
    {
        if ($target !== null) {
            $this->option('-t', $target);
        }

        $this->action = 'rollback';
        return $this;
    }

    public function status()
    {
        $this->action = 'status';
        return $this;
    }

    public function config($file = 'phinx.yml')
    {
        $this->option('-c', $file);
        return $this;
    }

    public function parser($format = 'yaml')
    {
        $this->option('-p', $format);
        return $this;
    }

    public function environment($environment = 'development')
    {
        $this->option('-e', $environment);
        return $this;
    }

    public function template($template)
    {
        $this->option('-t', $template);
        return $this;
    }

    public function getCommand()
    {
        return "{$this->command} {$this->action} {$this->arguments}";
    }

    public function run()
    {
        $this->printTaskInfo('Running Phinx '. $this->arguments);
        return $this->executeCommand($this->getCommand());
    }
}
