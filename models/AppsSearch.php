<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Apps;

/**
 * AppsSearch represents the model behind the search form of `app\models\Apps`.
 */
class AppsSearch extends Apps
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idApp', 'nombre', 'codigoApp', 'urlLogo', 'color1', 'color2', 'color3'], 'safe'],
            [['idUser'], 'integer'],
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
        $query = Apps::find();

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
        $query->andFilterWhere([
            'idUser' => $this->idUser,
        ]);

        $query->andFilterWhere(['like', 'idApp', $this->idApp])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'codigoApp', $this->codigoApp])
            ->andFilterWhere(['like', 'urlLogo', $this->urlLogo])
            ->andFilterWhere(['like', 'color1', $this->color1])
            ->andFilterWhere(['like', 'color2', $this->color2])
            ->andFilterWhere(['like', 'color3', $this->color3]);

        return $dataProvider;
    }
}
