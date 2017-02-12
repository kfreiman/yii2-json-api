<?php
/**
 * @author Kirill Freiamn <k.freiman@ya.ru>
 */

namespace tuyakhov\jsonapi;

use \yii\rest\ActiveController as BaseActiveController;

class ActiveController extends BaseActiveController
{


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return array_merge(parent::actions(), [
            'create' => [
                'class' => 'tuyakhov\jsonapi\actions\CreateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $this->createScenario,
            ],
            'update' => [
                'class' => 'tuyakhov\jsonapi\actions\UpdateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $this->createScenario,
            ],
        ]);
    }

}
