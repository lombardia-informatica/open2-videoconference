<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 * @see http://example.com Developers'community
 * @license GPLv3
 * @license https://opensource.org/licenses/gpl-3.0.html GNU General Public License version 3
 *
 * @package    lispa\amos\moodle\assets
 * @category   CategoryName
 * @author     Lombardia Informatica S.p.A.
 */

namespace lispa\amos\videoconference\assets;

use yii\web\AssetBundle;
use Yii;

/**
 * Class VideoconferenceAsset
 * @package lispa\amos\videoconference\assets
 */
class VideoconferenceAsset extends AssetBundle {

    /**
     * @inheritdoc
     */
    public $sourcePath = '@vendor/lispa/amos-videoconference/src/assets/web';
    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];

    /**
     * @inheritdoc
     */
    public $css = [
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        //"https://jitsi01.smart.it/libs/external_api.min.js",
        //'js/videoconference.js'
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init() {
        $videoconferenceConfig = Yii::$app->getModule('videoconference')->config;
        $jitsiDomain = $videoconferenceConfig['jitsiDomain'] ?: null;
        
        $this->js = [
            "https://".$jitsiDomain."/libs/external_api.min.js",
            'js/videoconference.js'
        ];
        parent::init();
    }

}
