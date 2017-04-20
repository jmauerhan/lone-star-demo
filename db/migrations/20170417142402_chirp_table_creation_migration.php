<?php

use Phinx\Migration\AbstractMigration;

class ChirpTableCreationMigration extends AbstractMigration
{
    public function up()
    {
        $chirps = $this->table('chirp', ['id' => false, 'primary_key' => 'id']);
        $chirps->addColumn('id', 'uuid')
               ->addColumn('chirp_text', 'string', ['limit' => 100])
               ->save();
    }

    public function down()
    {
        $this->dropTable('chirp');
    }
}
