<?php
namespace Rb\Robo\Task;

trait Commands
{
    /**
     * @param string $path
     *
     * @return PhinxTask
     */
    public function init($path = '.')
    {
        $this->action = "init $path";
        return $this;
    }

    /**
     * @param string $migration
     *
     * @return PhinxTask
     */
    public function create($migration)
    {
        $this->action = "create $migration";
        return $this;
    }

    /**
     * @param string|null $target
     *
     * @return PhinxTask
     */
    public function migrate($target = null)
    {
        if ($target !== null) {
            $this->option('-t', $target);
        }

        $this->action = 'migrate';
        return $this;
    }

    /**
     * @param string|null $target
     *
     * @return PhinxTask
     */
    public function rollback($target = null)
    {
        if ($target !== null) {
            $this->option('-t', $target);
        }

        $this->action = 'rollback';
        return $this;
    }

    /**
     * @return PhinxTask
     */
    public function status()
    {
        $this->action = 'status';
        return $this;
    }
}
