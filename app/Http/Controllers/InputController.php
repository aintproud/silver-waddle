<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Database\{Connection, DatabaseManager};

class InputController extends Controller
{
    private readonly Connection $connection;

    public function __construct(DatabaseManager $database)
    {
        $this->connection = $database->connection();
    }

    public function index(InputRequest $request): InputResponse
    {
        $time = $request->getTime();
        $diff = $request->getDiff();
        $this->connection->insert('INSERT INTO events (time, diff) VALUES (:time, :diff)', ['time' => $time, 'diff' => $diff]);
        $object = $this->connection->selectOne('SELECT 2+:value AS a', ['value' => $request->getTime()]);
        return new InputResponse($object?->a === $request->getTime() + 2);
    }
}
