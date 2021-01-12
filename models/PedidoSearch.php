<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pedido;
use Yii;

/**
 * PedidoSearch represents the model behind the search form of `app\models\Pedido`.
 */
class PedidoSearch extends Pedido
{

    public $txtSearch;
    public $estado;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['txtSearch'], 'string', 'max' => 30],
            [['estado'], 'string', 'max' => 80]
           
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

    //=====================================FILTROS=============================
    /**
     * Aplica los filtros segun el usuario y muestra los pedidos que le corresponde al usuario actual
     */
    private function filterForUser(&$query){

        $idApp=Yii::$app->params['sesionApp']['idApp'];
        $userRole=Yii::$app->params['sesionApp']['userRole'];
        $idUser=Yii::$app->params['sesionApp']['userId'];

        switch(Perfil::roleToCodePerfil($userRole)){
            case 'ADM':
            case 'EJE':
                // llamamos todos los pedidos de la aplicacion
                $query->where(['pedido.app_idApp'=>$idApp]); 
                break;
            case 'RES':
                // llamamod a todos los pedido del responsable y sus encargados
                $empleados=User::getEmployes($idApp,$idUser); //Obtenemos los empleados del usuario
                $query->where(['pedido.app_idApp'=>$idApp,'idResponsable'=>array_merge([$idUser],$empleados)]); 
                break;

            case 'OPE':
                $query->where(['pedido.app_idApp'=>$idApp,'idResponsable'=>$idUser]);           

        }

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
        $query = Pedido::find();

        //$query = Pedido::findForUser();
       
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

        // Aplicamos el filtro por sesion
        $this->filterForUser($query);

          //TODO--- VER CONSULTA
        if(!empty($this->txtSearch)){
           $query->leftJoin('contacto', 'contacto.app_idApp = pedido.app_idApp AND contacto.id=pedido.contacto_id');
            $query->andFilterWhere(['or',['like', 'pedido.nombre', $this->txtSearch],
            ['like', 'contacto.nombre', $this->txtSearch],
            ['like', 'contacto.empresa', $this->txtSearch],
            ['like', 'contacto.cel', $this->txtSearch],
            ['like', 'contacto.cuit', $this->txtSearch],
            ['like', 'pedido.comentarios', $this->txtSearch],
            ['like', 'estado', $this->txtSearch]]); 
        }else{
           $query->andWhere("estado <> 'ENTREGADO' OR (estado='ENTREGADO' AND saldo<>0)");
           $query->andWhere("estado <> 'ANULADO'");
        }

         $query->orderBy(['prioridad'=>SORT_DESC,'fechaEntrega'=>SORT_ASC]);


        /* Para ver laa consulta
        $command = $query->createCommand();
        echo $command->getSql();
        */

        return $dataProvider;
    }
}
