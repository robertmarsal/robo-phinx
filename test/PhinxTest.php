<?php
namespace RbTest\Robo\Task;

use Rb\Robo\Task\Phinx;
use PHPUnit_Framework_TestCase;

class PhinxTest extends PHPUnit_Framework_TestCase
{
    use Phinx;

    protected function task($class, $pathToPhinx = null)
    {
        return new $class($pathToPhinx);
    }

    public function testTraitExists()
    {
        $this->assertTrue(method_exists($this, 'taskPhinx'));
    }

    public function testInitUseDotIfNoPathIsSpecified()
    {
        $command =
            $this->taskPhinx('phinx')
                ->init()
                ->getCommand();
        $this->assertEquals('phinx init . ', $command);
    }

    /**
     * @dataProvider initDataProvider
     */
    public function testInitCompositionIsCorrect($path, $equals)
    {
        $command =
            $this->taskPhinx('phinx')
                 ->init($path)
                 ->getCommand();
        $this->assertEquals($equals, $command);
    }

    public static function initDataProvider()
    {
        return [
            [
                '.', 'phinx init . ',
                'test', 'phinx init test ',
            ]
        ];
    }

    /**
     * @dataProvider createDataProvider
     */
    public function testCreateCompositionIsCorrect($migration, $equals)
    {
        $command =
            $this->taskPhinx('phinx')
                 ->create($migration)
                 ->getCommand();
        $this->assertEquals($equals, $command);
    }

    public static function createDataProvider()
    {
        return [
            [
                'Migration123', 'phinx create Migration123 ',
                'MigrationTest', 'phinx create MigrationTest ',
            ]
        ];
    }

    /**
     * @dataProvider migrateDataProvider
     */
    public function testMigrateCompositionIsCorrect($target, $equals)
    {
        $command =
            $this->taskPhinx('phinx')
                 ->migrate($target)
                 ->getCommand();
        $this->assertEquals($equals, $command);
    }

    public static function migrateDataProvider()
    {
        return [
            [
             '123', 'phinx migrate  -t 123',
             '655', 'phinx migrate  -t 655',
             '986', 'phinx migrate  -t 986',
            ],
        ];
    }

    /**
     * @dataProvider rollbackDataProvider
     */
    public function testRollbackCompositionIsCorrect($target, $equals)
    {
        $command =
            $this->taskPhinx('phinx')
                 ->rollback($target)
                 ->getCommand();
        $this->assertEquals($equals, $command);
    }

    public static function rollbackDataProvider()
    {
        return [
            [
             '123', 'phinx rollback  -t 123',
             '655', 'phinx rollback  -t 655',
             '986', 'phinx rollback  -t 986',
            ],
        ];
    }

    public function testStatusCompositionIsCorrect()
    {
        $command =
            $this->taskPhinx('phinx')
                 ->status()
                 ->getCommand();
        $this->assertEquals('phinx status ', $command);
    }

    public function testConfigUsesPhinxYmlFileByDefault()
    {
        $command =
            $this->taskPhinx('phinx')
                 ->config()
                 ->getCommand();
        $this->assertEquals('phinx   -c phinx.yml', $command);
    }

    /**
     * @dataProvider configDataProvider
     */
    public function testConfigCompositionIsCorrect($file, $equals)
    {
        $command =
            $this->taskPhinx('phinx')
                 ->config($file)
                 ->getCommand();
        $this->assertEquals($equals, $command);
    }

    public static function configDataProvider()
    {
        return [
            [
                'config.php', 'phinx   -c config.php',
                'config/phinx.php', 'phinx   -c config/phinx.php'
            ],
        ];
    }

    public function testParserUsesYamlFormatByDefault()
    {
        $command =
            $this->taskPhinx('phinx')
                 ->parser()
                 ->getCommand();
        $this->assertEquals('phinx   -p yaml', $command);
    }

    /**
     * @dataProvider parserDataProvider
     */
    public function testParserCompositionIsCorrect($format, $equals)
    {
        $command =
            $this->taskPhinx('phinx')
                 ->parser($format)
                 ->getCommand();
        $this->assertEquals($equals, $command);
    }

    public static function parserDataProvider()
    {
        return [
            [
                'php', 'phinx   -p php',
                'yaml', 'phinx   -p yaml',
            ],
        ];
    }

    public function testEnvironmentUsesDevelopmentByDefault()
    {
        $command =
            $this->taskPhinx('phinx')
                 ->environment()
                 ->getCommand();
        $this->assertEquals('phinx   -e development', $command);
    }

    /**
     * @dataProvider environmentDataProvider
     */
    public function testEnvironmentCompositionIsCorrect($environment, $equals)
    {
        $command =
            $this->taskPhinx('phinx')
                 ->environment($environment)
                 ->getCommand();
        $this->assertEquals($equals, $command);
    }

    public static function environmentDataProvider()
    {
        return [
            [
                'development', 'phinx   -e development',
                'test', 'phinx   -e test',
                'production', 'phinx   -e production',
            ],
        ];
    }

    public function testGetCommandCompositionIsCorrect()
    {
        $command =
            $this->taskPhinx('phinx')
                 ->environment('production')
                 ->parser('yaml')
                 ->status()
                 ->getCommand();
        $this->assertEquals('phinx status  -e production -p yaml', $command);
    }
}



