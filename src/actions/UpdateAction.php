<?php
/**
 * @author Anton Tuyakhov <atuyakhov@gmail.com>
 */

namespace tuyakhov\jsonapi\actions;

use Yii;
use yii\helpers\Url;
use yii\rest\UpdateAction as BaseUpdateAction;
use yii\web\ServerErrorHttpException;
use yii\db\BaseActiveRecord;

/**
 * UpdateAction implements the API endpoint for updating resources.
 * @link http://jsonapi.org/format/#crud-updating
 */
class UpdateAction extends BaseUpdateAction
{

    /**
     * @inheritdoc
     */
    public function run($id)
    {
        /* @var $model BaseActiveRecord */
        $model = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        $model->scenario = $this->scenario;
        $model->load(Yii::$app->getRequest()->getBodyParams());
        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }

        return $model;
    }

}
