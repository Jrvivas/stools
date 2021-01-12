<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cuenta;

/**
 * CuentaSearch represents the model behind the search form of `app\models\Cuenta`.
 */
class CuentaSearch extends Cuenta
{

    public $txtSearch;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['txtSearch'], 'string', 'max' => 30]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Cuenta::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andWhere(['=', 'app_idApp', $this->app_idApp]);

        $query->andFilterWhere(['like', 'nombre', $this->txtSearch]);

        return $dataProvider;
    }
}
