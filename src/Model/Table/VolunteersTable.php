<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class VolunteersTable extends Table
{
    public function initialize(array $config)
    {
        # use created/modified columns
        # https://book.cakephp.org/3.0/en/orm/behaviors/timestamp.html
        $this->addBehavior('Timestamp');
    }
}

?>
