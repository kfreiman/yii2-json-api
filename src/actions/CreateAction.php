<?php
/**
 * @author Anton Tuyakhov <atuyakhov@gmail.com>
 */

namespace tuyakhov\jsonapi\actions;

use Yii;
use yii\helpers\Url;
use yii\rest\CreateAction as BaseCreateAction;
use yii\web\ServerErrorHttpException;
use yii\db\BaseActiveRecord;

/**
 * CreateAction implements the API endpoint for create resources.
 * @link http://jsonapi.org/format/#crud-creating
 */
class CreateAction extends BaseCreateAction
{

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        /* @var $model \yii\db\BaseActiveRecord */
        $model = new $this->modelClass([
            'scenario' => $this->scenario,
        ]);

        $model->load(Yii::$app->getRequest()->getBodyParams());
        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        return $model;
    }

}
