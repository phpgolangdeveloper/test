<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class test extends Command
{
    /**
     * The name and signature of the console command.
     * 意思就是：command:name脚本名
     * {--func= : this is function name} 函数名
     * {param?} 接受参数  ?为非必填参数
     * @var string
     */
    protected $signature = 'command:name {--func= : this is function name} {param?}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $function = $this->option('func');
        $param    = $this->argument('param');
        TestService::xRun($function,$param);

    }
}
