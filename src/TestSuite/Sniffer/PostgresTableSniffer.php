<?php
declare(strict_types=1);

namespace CakephpFixtureFactories\TestSuite\Sniffer;


use Cake\Utility\Hash;

class PostgresTableSniffer extends BaseTableSniffer
{
    public function getDirtyTables(): array
    {
//        $sequences = $this->connection->execute("
//            SELECT sequence_name  FROM information_schema.sequences;
//        ")->fetchAll();
//        $sequences = Hash::extract($sequences, '{n}.0');
//
//        $stats = $this->connection->newQuery();
//        $tables = [];
//        foreach ($sequences as $sequence) {
//            $stats->select("nextval('$sequence')");
//            $tables[] = preg_replace("/_id_seq$/", '', $sequence );
//        }
//        $stats = $stats->execute()->fetchAll()[0];
//        $stats = array_combine($tables, $stats);
//
//        return array_keys(
//            array_filter(
//                $stats,
//                function($var) { return $var > 1; }
//            )
//        );

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