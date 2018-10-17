<?php

namespace lispa\amos\videoconference\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lispa\amos\videoconference\models\Videoconf;

/**
 * VideoconfSearch represents the model behind the search form about `lispa\amos\videoconference\models\Videoconf`.
 */
class VideoconfSearch extends Videoconf
{

    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['id_room_videoconference', 'status', 'title', 'description', 'begin_date_hour', 'created_at', 'updated_at',
                'deleted_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function getScope($params)
    {
        $scope = $this->formName();
        if (!isset($params[$scope])) {
            $scope = '';
        }
        return $scope;
    }

    /**
     * Search all the videoconferences visible by the logged user
     *
     * @param array $params $_GET search parameters array
     * @param int|null $limit
     * @return ActiveDataProvider
     */
    public function searchAll($params, $limit = null)
    {
        return $this->search($params, 'all', $limit);
    }

    /**
     * @param $params
     * @param null $limit
     * @return ActiveDataProvider
     */
    public function searchAdminAllVideoconf($params, $limit = null)
    {
        return $this->search($params, 'admin-all', $limit);
    }

    /**
     * @param array $params
     * @return ActiveQuery $query
     */
    public function baseSearch($params)
    {
        //init the default search values
        $this->initOrderVars();

        //check params to get orders value
        $this->setOrderVars($params);

        return Videoconf::find()->distinct();
    }

    /**
     * @param array $params $_GET search parameters array
     * @param string $queryType, depending on the index tab user is on (communities created by me, my communities, all communities,..)
     * @param bool $onlyActiveStatus
     * @param int|null $limit the query limit
     * @return ActiveDataProvider $dataProvider
     */
    public function search($params, $queryType, $limit = null, $onlyActiveStatus = false)
    {

        $query = $this->buildQuery($queryType, $params, $onlyActiveStatus);
        $query->joinWith('videoconfUsersMms');
        $query->limit($limit);
        $user = \Yii::$app->getUser();
        if(!$user->can('VIDEOCONF_READ')){
            $query->andWhere(['user_profile_id' => $user->id]);
        }


        /** @var  $notify AmosNotify Per ora no
          $notify = Yii::$app->getModule('notify');
          if($notify)
          {
          $notify->notificationOff(Yii::$app->getUser()->id, Community::className(),$query, \lispa\amos\notificationmanager\models\NotificationChannels::CHANNEL_READ);
          } */
        $dp_params = ['query' => $query,];
        if ($limit) {
            $dp_params ['pagination'] = false;
        }
        $dataProvider = new ActiveDataProvider($dp_params);

        //check if can use the custom module order
        if ($this->canUseModuleOrder()) {
            $dataProvider->setSort([
                'defaultOrder' => [
                    $this->orderAttribute => (int) $this->orderType
                ]
            ]);
        } else { //for widget graphic last news, order is incorrect without this else
            $dataProvider->setSort([
                'defaultOrder' => [
                    'created_at' => SORT_DESC
                ]
            ]);
        }

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }


        $query->andFilterWhere([
            'videoconf.id' => $this->id,
            'begin_date_hour' => $this->begin_date_hour,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,
//            'deleted_at' => $this->deleted_at,
//            'created_by' => $this->created_by,
//            'updated_by' => $this->updated_by,
//            'deleted_by' => $this->deleted_by,
        ]);

        $query->andFilterWhere(['like', 'id_room_videoconference', $this->id_room_videoconference])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @param bool|false $onlyActiveStatus
     * @return ActiveQuery $query
     */
    public function buildQuery($queryType, $params, $onlyActiveStatus = false)
    {

        $query  = $this->baseSearch($params);
        $userId = Yii::$app->getUser()->getId(); // TODO: questo è il profile? se no, va cercato il profile

        switch ($queryType) {
            case 'created-by':
                $query->andFilterWhere(['videoconf.created_by' => $userId]);
                break;
            case 'all':
                break;
                /** @var ActiveQuery $queryClosed */
                $query->innerJoin(VideoconfUsersMm::tableName(),
                        'videoconf.id = '.VideoconfUsersMm::tableName().'.videoconf_id'
                        .' AND '.VideoconfUsersMm::tableName().'.user_profile_id = '.$userId)
                    /* ->andFilterWhere([
                      'videoconf.status' => Videoconf::STATUS_END
                      ]) */
                    ->andWhere(VideoconfUsersMm::tableName().'.deleted_at is null');
                break;
            case 'admin-all':
                /* no filter */
                break;
        }

        return $query;
    }

    public function xxx_orig_search($params)
    {
        //pr($params, '$params');exit;
        $query = Videoconf::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $scope = $this->getScope($params);

        if (!($this->load($params, $scope) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'begin_date_hour' => $this->begin_date_hour,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
        ]);

        $query->andFilterWhere(['like', 'id_room_videoconference', $this->id_room_videoconference])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}