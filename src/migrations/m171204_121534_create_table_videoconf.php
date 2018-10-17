<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 * @see http://example.com Developers'community
 * @license GPLv3
 * @license https://opensource.org/licenses/gpl-3.0.html GNU General Public License version 3
 *
 * @package    lispa\amos\videoconference\migrations
 * @category   CategoryName
 * @author     Lombardia Informatica S.p.A.
 */

use lispa\amos\core\migration\AmosMigrationTableCreation;

/**
 * Class m171204_121534_create_table_videoconf
 */
class m171204_121534_create_table_videoconf extends AmosMigrationTableCreation
{
    /**
     * @inheritdoc
     */
    protected function setTableName()
    {
        $this->tableName = '{{%videoconf}}';
    }

    /**
     * @inheritdoc
     */
    protected function setTableFields()
    {
        $this->tableFields = [
            'id' => $this->primaryKey(),
            'id_room_videoconference' => $this->string(255)->null()->comment('Id room on Jitsi'),
            'status' => $this->string(255)->defaultValue(null)->comment('Status'),
            'title' => $this->string(255)->null()->comment('Title'),
            'description' => $this->text()->null()->comment('Description'),
            'begin_date_hour' => $this->dateTime()->null()->comment('Begin Date And Hour'),
        ];
    }

    /**
     * @inheritdoc
     */
    protected function beforeTableCreation()
    {
        parent::beforeTableCreation();
        $this->setAddCreatedUpdatedFields(true);
    }

}
