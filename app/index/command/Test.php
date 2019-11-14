<?php
namespace app\index\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use app\common\model\Articles;

class Test extends Command
{
    protected function configure()
    {
        $this->setName('Test')->setDescription("计划任务 Test");
    }

    protected function execute(Input $input, Output $output)
    {
        // $output->writeln('Date Crontab job start...');
        /*** 这里写计划任务列表集 START ***/

        $this->test();

        /*** 这里写计划任务列表集 END ***/
        // $output->writeln('Date Crontab job end...');
    }

    private function test()
    {
        // echo "test\r\n";
        // Articles::where('title','like','%测试%')->delete();
        Articles::destroy(function($query){
            $query->where('title','like','%测试%');
        });
    }
}
