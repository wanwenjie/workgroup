<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


class ChatCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:test {message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'chat test';

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
        event(new \App\Events\ChatMessageWasReceived($this->argument('message')));
    }
}
