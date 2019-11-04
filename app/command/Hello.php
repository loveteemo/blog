<?php
declare (strict_types = 1);

namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use think\Db;

class Hello extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('hello')
            ->setDescription('跑脚本');
    }

    protected function execute(Input $input, Output $output)
    {
      $res = \think\facade\Db::table('sss')->find();
    	// 指令输出
    	$output->writeln('hello');
    }
}
