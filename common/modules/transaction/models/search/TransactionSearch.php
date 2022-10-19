<?php

namespace common\modules\transaction\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\transaction\models\Transaction;

/**
 * TransactionSearch represents the model behind the search form of `common\modules\transaction\models\Transaction`.
 */
class TransactionSearch extends Transaction
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'time', 'created_at', 'perform_at', 'cancel_at', 'amount', 'state', 'reason', 'user_id'], 'integer'],
            [['transaction_id'], 'safe'],
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
        $query = Transaction::find();

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
            'time' => $this->time,
            'created_at' => $this->created_at,
            'perform_at' => $this->perform_at,
            'cancel_at' => $this->cancel_at,
            'amount' => $this->amount,
            'state' => $this->state,
            'reason' => $this->reason,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['ilike', 'transaction_id', $this->transaction_id]);

        return $dataProvider;
    }
}
