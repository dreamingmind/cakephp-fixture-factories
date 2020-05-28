<?php
declare(strict_types=1);

namespace CakephpFixtureFactories\TestSuite\Sniffer;


use Cake\Utility\Hash;

class PostgresTableSniffer extends BaseTableSniffer
{
    public function getDirtyTables(): array
    {
        $tables = $this->connection->execute("
            SELECT relname FROM pg_stat_all_tables
	            WHERE schemaname = 'public'
	            AND relname NOT LIKE '%phinxlog'
	            AND n_tup_ins > 0;
        ")->fetchAll();
        return Hash::extract($tables, '{n}.0');
    }

    public function getAllTables(): array
    {
        $tables = $this->connection->execute("            
            SELECT table_name
            FROM information_schema.tables
            WHERE table_schema = 'public'            
        ")->fetchAll();
        return Hash::extract($tables, '{n}.0');
    }
}