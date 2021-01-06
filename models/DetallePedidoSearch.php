<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DetallePedido;

/**
 * DetallePedidoSearch represents the model behind the search form of `app\models\DetallePedido`.
 */
class DetallePedidoSearch extends DetallePedido
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'inst', 'productos_id', 'pedido_id'], 'integer'],
            [['cantidad', 'ancho', 'alto', 'monto', 'fraccion'], 'number'],
            [['detalle', 'app_idApp'], 'safe'],
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
        $query = DetallePedido::find();

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
            'id' => $this->id,
            'cantidad' => $this->cantidad,
            'ancho' => $this->ancho,
            'alto' => $this->alto,
            'monto' => $this->monto,
            'fraccion' => $this->fraccion,
            'inst' => $this->inst,
            'productos_id' => $this->productos_id,
            'pedido_id' => $this->pedido_id,
        ]);

        $query->andFilterWhere(['like', 'detalle', $this->detalle])
            ->andFilterWhere(['like', 'app_idApp', $this->app_idApp]);

        return $dataProvider;
    }
}
