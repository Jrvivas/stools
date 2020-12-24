<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Movimiento;

/**
 * MovimientoSearch represents the model behind the search form of `app\models\Movimiento`.
 */
class MovimientoSearch extends Movimiento
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'contacto_id', 'tipo'], 'integer'],
            [['app_idApp', 'fecha', 'comentario', 'fecha_tipo', 'opciones'], 'safe'],
            [['entrada', 'salida'], 'number'],
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
        $query = Movimiento::find();

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
            'contacto_id' => $this->contacto_id,
            'fecha' => $this->fecha,
            'entrada' => $this->entrada,
            'salida' => $this->salida,
            'tipo' => $this->tipo,
            'fecha_tipo' => $this->fecha_tipo,
        ]);

        $query->andFilterWhere(['like', 'app_idApp', $this->app_idApp])
            ->andFilterWhere(['like', 'comentario', $this->comentario])
            ->andFilterWhere(['like', 'opciones', $this->opciones]);

        return $dataProvider;
    }
}
