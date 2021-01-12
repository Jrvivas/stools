<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Productos;

/**
 * modelsProductosSearch represents the model behind the search form of `app\models\Productos`.
 */
class ProductosSearch extends Productos
{

    public $txtSearch;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['txtSearch'], 'string', 'max' => 30],
            [['categoriaCodigo'],'string','max'=>255]
           
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
        $query = Productos::find();

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
        /*$query->andFilterWhere([
            'id' => $this->id,
            'precio' => $this->precio,
            'costo' => $this->costo,
            'precio1' => $this->precio1,
            'precio2' => $this->precio2,
        ]);*/
       /* $query->andFilterWhere([
            'app_idApp' => $this->app_idApp
        ]);*/
        $query->andWhere(['=', 'app_idApp', $this->app_idApp]);
        $query->andFilterWhere(['=','categoriaCodigo',$this->categoriaCodigo]);
        $query->andFilterWhere(['or',['like', 'codigo', $this->txtSearch],['like', 'nombre', $this->txtSearch],['like', 'descripcion', $this->txtSearch]]);

        return $dataProvider;
    }
}
