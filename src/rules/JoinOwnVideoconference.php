<?php
/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 * @see http://example.com Developers'community
 * @license GPLv3
 * @license https://opensource.org/licenses/gpl-3.0.html GNU General Public License version 3
 *
 * @package    lispa\amos\videoconference
 * @category   CategoryName
 * @author     Lombardia Informatica S.p.A.
 */

namespace lispa\amos\videoconference\rules;

use lispa\amos\videoconference\AmosVideoconference;
use lispa\amos\admin\models\UserProfile;
use yii\rbac\Item;
use yii\rbac\Rule;
use lispa\amos\videoconference\models\Videoconf;
use lispa\amos\videoconference\models\VideoconfUsersMm;
use lispa\amos\admin\AmosAdmin;

/**
 * Class JoinOwnVideoconference
 * @package lispa\amos\admin\rbac
 */
class JoinOwnVideoconference extends Rule
{
    public $name        = 'joinYourVideoconference';
    public $description = '';

    /**
     * @param string|integer $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        $model = ((isset($params['model']) && $params['model']) ? $params['model'] : new VideoconfUsersMm());
if(!($model instanceof VideoconfUsersMm)){
    $model = new VideoconfUsersMm();
}
        if (!$model->videoconf_id) {
            $post = \Yii::$app->getRequest()->post();
            $get  = \Yii::$app->getRequest()->get();

            if (isset($get['id'])) {
                $model = $this->instanceModel($model, $get['id']);
            } elseif (isset($post['id'])) {
                $model = $this->instanceModel($model, $post['id']);
            }
        }

        if (isset($model->user_profile_id)) {
            $userProfile = AmosAdmin::instance()->createModel('UserProfile');
            $profile     = $userProfile::findOne($model->user_profile_id);
            return ($profile->user_id == $user);
        }
        return false;
    }

    /**
     * @param Videoconf $model
     * @param int $modelId
     * @return mixed
     */
    private function instanceModel($model, $modelId)
    {
        /** @var Videoconf $videconfInstance */
        $videconfInstance = new VideoconfUsersMm;
        $instancedModel   = $videconfInstance::findOne(['videoconf_id' => $modelId]);
        if (!is_null($instancedModel)) {
            $model = $instancedModel;
        }
        return $model;
    }
}