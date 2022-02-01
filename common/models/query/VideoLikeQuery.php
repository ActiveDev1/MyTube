<?php

namespace common\models\query;

use common\models\VideoLike;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\VideoLike]].
 *
 * @see \common\models\VideoLike
 */
class VideoLikeQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return VideoLike[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    public function userIdVideId($userId, $videoId)
    {
        return $this->andWhere(['video_id' => $videoId, 'user_id' => $userId]);
    }

    public function liked()
    {
        return $this->andWhere(['type' => VideoLike::TYPE_LIKE]);
    }

    public function disliked()
    {
        return $this->andWhere(['type' => VideoLike::TYPE_DISLIKE]);
    }

    /**
     * {@inheritdoc}
     * @return VideoLike|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
