<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 * @see http://example.com Developers'community
 * @license GPLv3
 * @license https://opensource.org/licenses/gpl-3.0.html GNU General Public License version 3
 *
 * @package    lispa\amos\community\migrations
 * @category   CategoryName
 * @author     Lombardia Informatica S.p.A.
 */

use lispa\amos\videoconference\models\Videoconf;
use yii\db\Migration;

/**
 * Class m171219_111336_add_community_field_hits
 */
class m180110_095836_add_columns_ore extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn(Videoconf::tableName(), 'reminder_sent', $this->integer(1)->defaultValue(0)->after('begin_date_hour'));
        $this->addColumn(Videoconf::tableName(), 'notification_before_conference', $this->integer()->defaultValue(null)->after('begin_date_hour'));
        $this->addColumn(Videoconf::tableName(), 'end_date_hour', $this->datetime()->defaultValue(null)->after('begin_date_hour'));


    }
    
    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn(Videoconf::tableName(), 'notification_before_conference');
        $this->dropColumn(Videoconf::tableName(), 'end_date_hour');
    }
}
