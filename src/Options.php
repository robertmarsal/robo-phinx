<?php
namespace Rb\Robo\Task;

trait Options
{
    /**
     * @param string $file
     *
     * @return PhinxTask
     */
    public function config($file = 'phinx.yml')
    {
        $this->option('-c', $file);
        return $this;
    }

    /**
     * @param string $format
     *
     * @return PhinxTask
     */
    public function parser($format = 'yaml')
    {
        $this->option('-p', $format);
        return $this;
    }

    /**
     * @param string $environment
     *
     * @return PhinxTask
     */
    public function environment($environment = 'development')
    {
        $this->option('-e', $environment);
        return $this;
    }

    /**
     * @param string $template
     *
     * @return PhinxTask
     */
    public function template($template)
    {
        $this->option('-t', $template);
        return $this;
    }
}
