<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pedido;
use Yii;

/**
 * PedidoSearch represents the model behind the search form of `app\models\Pedido`.
 */
class PedidoSearchJson extends Pedido
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
        $query = Pedido::find();

        // add conditions that should always apply here
        $query->joinWith('cliente');
       // $query->joinWith('responsable');
       $query->leftJoin('users', ' users.id=pedido.idResponsable');

       $query->select(['pedido.*','respNombre'=>'users.nombre','respUserName'=>'users.userName','respEmail'=>'users.email']);


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $query->all();
        }

        // grid filtering conditions
        if(User::isInvitado( $this->app_idApp)){
           // sin invitados solo se listará los pedidos de realizado por el
           // sin es un responsable ademas debe ver los operadores a su cargo
            
           //hacer un join con la tabla invitado para saber si el pedido pertenese a algun
           // subordinado
          $query->leftJoin('invitado', 'invitado.app_idApp = pedido.app_idApp AND invitado.idInvitado=pedido.idResponsable');
          //  $query->leftJoin('invitado', 'invitado.app_idApp = pedido.app_idApp ');
          //  $query->andWhere("(pedido.app_idApp='$this->app_idApp' AND pedido.idResponsable=".Yii::$app->user->identity->id.") OR (pedido.app_idApp='$this->app_idApp' AND invitado.idSuperior=".Yii::$app->user->identity->id.") OR (pedido.app_idApp='$this->app_idApp' AND  invitado.role=".User::ROLE_ADMIN.")");
          if(User::getRole($this->app_idApp)===User::ROLE_ADMIN){
                $query->andWhere(['=', 'pedido.app_idApp', $this->app_idApp]); 
          }else{
                $query->andWhere("(pedido.app_idApp='$this->app_idApp' AND pedido.idResponsable=".Yii::$app->user->identity->id.") OR (pedido.app_idApp='$this->app_idApp' AND invitado.idSuperior=".Yii::$app->user->identity->id.") ");
          }
        
       
           //$query->andWhere("app_idApp='$this->app_idApp' AND idResponsable=".Yii::$app->user->identity->id);
        
        }else{
            $query->andWhere(['=', 'pedido.app_idApp', $this->app_idApp]); 
        }
           //  $query->andWhere(['=', 'pedido.app_idApp', $this->app_idApp]);

          
        if(!empty($this->txtSearch)){
           //$query->leftJoin('contacto', 'contacto.app_idApp = pedido.app_idApp AND contacto.id=pedido.contacto_id');
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
        $query->asArray();

        return $query;
    }
}
