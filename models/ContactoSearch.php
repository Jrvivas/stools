<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Contacto;

/**
 * ContactoSearch represents the model behind the search form of `app\models\Contacto`.
 */
class ContactoSearch extends Contacto
{
    public $txtSearch;
    public $nombreCampo;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['txtSearch'], 'string', 'max' => 30],
            [['nombreCampo'], 'string', 'max' => 30]
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
        $query = Contacto::find();

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
        if($this->nombreCampo=='Todos'){
            $query->andFilterWhere(['or',['like', 'nombre', $this->txtSearch],
                            ['like', 'direccion', $this->txtSearch],
                            ['like', 'localidad', $this->txtSearch],
                            ['like', 'cel', $this->txtSearch],
                            ['like', 'tel', $this->txtSearch],
                            ['like', 'email', $this->txtSearch],
                            ['like', 'empresa', $this->txtSearch],
                            ['like', 'cuit', $this->txtSearch]]);
        }else{
            $query->andFilterWhere(['or',['like', $this->nombreCampo, $this->txtSearch]]);
        }
        

        return $dataProvider;
    }
}
