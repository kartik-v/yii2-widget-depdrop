<?php

namespace kartik\depdrop;

use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\helpers\Json;
use yii\web\Response;

/**
 * Class DepDropAction
 * @package kartik\depdrop
 *
 *
 *
 *  * A typical usage  is like the following:
 *
 * ```php
 *
 *    //inside controller
 *
 *    public function actions()
 *    {
 *        return \yii\helpers\ArrayHelper::merge(parent::actions(), [
 *            'subcategory' => [
 *                'class' => \kartik\depdrop\DepDropAction::className(),
 *                'outputFunction' => function ($selectedId, $params) {
 *                    return [
 *                        [
 *                            'id'=>1,
 *                            'name'=>'Car',
 *                        ],
 *                        [
 *                            'id'=>2,
 *                            'name'=>'bike',
 *                        ],
 *                    ];
 *
 *                     // return self::getSubCategory($selectedId);
 *
 *
 *
 *                     //with group
 *                    return [
 *                        'group1'=>[
 *                            ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
 *                            ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
 *                        ],
 *                        'group2'=>[
 *                            ['id'=>'<sub-cat-id-3>', 'name'=>'<sub-cat-name3>'],
 *                            ['id'=>'<sub-cat-id-4>', 'name'=>'<sub-cat-name4>']
 *                        ]
 *                    ];
 *                }
 *            ]
 *        ]);
 *    }
 * ```
 *
 *
 */
class DepDropAction extends Action
{

    /**
     *
     */
    const MAIN_PARAM = 'depdrop_parents';
    /**
     *
     */
    const OTHER_PARAMS = 'depdrop_params';
    /**
     * @var
     */
    public $outputFunction;
    /**
     * @var
     */
    public $selectedFunction;

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if (!is_callable($this->outputFunction)) {
            throw new InvalidConfigException('outputFunction must be callable');
        }
    }

    /**
     * Runs the action.
     */
    public function run()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($selected = Yii::$app->getRequest()->post(self::MAIN_PARAM)) {
            if ($selected) {
                $selectedId = $selected[0];
                $params = Yii::$app->getRequest()->post(self::OTHER_PARAMS, []);
                return ['output' => $this->getOutput($selectedId,$params), 'selected' => $this->getSelected($selectedId,$params)];
            }
        }
        return Json::encode(['output' => '', 'selected' => '']);
    }

    /**
     * @param $id
     * @param $params
     * @return mixed
     */
    private function getOutput($id, $params)
    {
        $outputFunction = $this->outputFunction;
        return $outputFunction($id,$params);
    }

    /**
     * @param $id
     * @param $params
     * @return string
     */
    private function getSelected($id, $params)
    {
        $selectedFunction = $this->selectedFunction;
        if (is_callable($selectedFunction)) {
            return $selectedFunction($id,$params);
        }
        return '';
    }


}
