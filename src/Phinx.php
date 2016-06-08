<?php
namespace Rb\Robo\Task;

use Robo\Task\BaseTask;
use Robo\Common\ExecOneCommand;
use Robo\Contract\CommandInterface;
use Robo\Contract\PrintedInterface;

trait Phinx
{
    /**
     * @param string|null $pathToPhinx
     *
     * @return PhinxTask
     */
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
    use Commands;
    use Options;
    use ExecOneCommand;

    protected $command;
    protected $action;

    /**
     * @param string|null $pathToPhinx
     *
     * @throws TaskException
     */
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

    /**
     * Returns the command ready to be executed.
     *
     * @return string
     */
    public function getCommand()
    {
        return "{$this->command} {$this->action} {$this->arguments}";
    }

    /**
     * Executes the command.
     *
     * @return \Robo\Result
     */
    public function run()
    {
        $this->printTaskInfo('Running Phinx '. $this->arguments);
        return $this->executeCommand($this->getCommand());
    }
}
