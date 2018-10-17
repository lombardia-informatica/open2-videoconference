<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 * @see http://example.com Developers'community
 * @license GPLv3
 * @license https://opensource.org/licenses/gpl-3.0.html GNU General Public License version 3
 *
 * @package    lispa\amos\videoconference\controllers
 * @category   CategoryName
 * @author     Lombardia Informatica S.p.A.
 */

namespace lispa\amos\videoconference\controllers;

use lispa\amos\dashboard\controllers\base\DashboardController;
use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

class DefaultController extends DashboardController {

    /**
     * @var string $layout Layout per la dashboard interna.
     */
    public $layout = "@vendor/lispa/amos-core/views/layouts/dashboard_interna";
    
    
    /**
     * Lists all Videoconference models.
     * @return mixed
     */
    public function actionIndex() {
        return $this->redirect(['/videoconference/videoconf/index']);

       /* Url::remember();

        $params = [
            'currentDashboard' => $this->getCurrentDashboard()
        ];

        return $this->render('index', $params);*/
       
    }

}
