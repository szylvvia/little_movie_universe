<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Tests\TestCase;

class DatabaseConnectionFeatureTest extends TestCase
{
    use DatabaseTransactions;

    public function testDatabaseHasProperTables()
    {
        $tables = DB::select('SHOW TABLES');
        $databaseName = Config::get('database.connections.mysql.database');
        $tables = array_column(json_decode(json_encode($tables), true),"Tables_in_".$databaseName);
        $mandatoryTables = ["answers", "artists","collections","failed_jobs","images","migrations","movie_has_artist",
                            "movies","password_reset_tokens","password_resets","personal_access_tokens","questions",
                            "quizzes","rates","users"];
        $tablesDiff = array_diff($tables,$mandatoryTables);
        $this->assertEmpty($tablesDiff);
    }
}
