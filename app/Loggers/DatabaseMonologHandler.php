<?php

namespace App\Loggers;

use Illuminate\Support\Facades\DB;
use Monolog\Handler\AbstractProcessingHandler;
use Illuminate\Support\Facades\Auth;
use Monolog\Logger;

class DatabaseMonologHandler extends AbstractProcessingHandler
{
    protected $table;
    protected $connection;
    public function __construct($level = Logger::DEBUG, $bubble = true)
    {
        $this->table = env('DB_LOG_TABLE', 'dtb_logs');
        $this->connection = env('DB_LOG_CONNECTION', 'mysql_log');
        if (is_callable('parent::__construct')) {
            parent::__construct($level, $bubble);
        }
    }

    protected function write(array $record): void
    {
        $data = [
            'instance' => gethostname(),
            'message' => $record['message'],
            'channel' => $record['channel'],
            'level' => $record['level'],
            'level_name' => $record['level_name'],
            'context' => json_encode($record['context']),
            'remote_addr' => isset($_SERVER['REMOTE_ADDR']) ? ip2long($_SERVER['REMOTE_ADDR']) : null,
            'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null,
            'created_by' => Auth::id() > 0 ? Auth::id() : null,
            'created_at' => $record['datetime']->format('Y-m-d H:i:s'),
        ];
        DB::connection($this->connection)->table($this->table)->insert($data);

        $ratio = env('DB_LOG_FLUSH_RATIO', 100);
        if (rand(0, $ratio - 1) == 0) {
            $this->deleteOld();
        }

    }

    protected function deleteOld()
    {
        $limit = env('DB_LOG_PRESERVE_DAYS', 30);
        $date = date('Y-m-d H:i:s', strtotime("-$limit days"));
        DB::connection($this->connection)->table($this->table)->where('created_at', '<', $date)->delete();
    }
}
