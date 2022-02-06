<?php

namespace common\models\query;

use common\models\Comment;

/**
 * This is the ActiveQuery class for [[\common\models\Comment]].
 *
 * @see \common\models\Comment
 */
class CommentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Comment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Comment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function videoId($video_id)
    {
        return $this->andWhere(['video_id' => $video_id]);
    }

    public function parent()
    {
        return $this->andWhere(['parent_id' => null]);
    }

    public function latest()
    {
        return $this->orderBy('pinned DESC, created_at DESC');
    }
}
