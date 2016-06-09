<?php
abstract class Model_Dvelum_Vote extends Model
{
    protected $resourceIdField;

    /**
     * Check if user can vote for resource
     * @param mixed $resourceId
     * @param integer $userId
     * @return bool
     */
    public function canVote($resourceId, $userId)
    {
        return (boolean) $this->getCount(
            [
                'user_id'=>$userId,
                $this->resourceIdField => $resourceId
            ]
        );
    }

    /**
     * Add vote
     * @param mixed $resourceId
     * @param integer $userId
     * @param integer $voteValue
     * @return bool
     */
    public function addVote($resourceId, $userId, $voteValue)
    {
        if(intval($voteValue) > 0){
            $voteValue = 1;
        }else{
            $voteValue = -1;
        }

        try{
            $vote = new Db_Object($this->getObjectName());
            $vote->setValues([
                'user_id'=>$userId,
                $this->resourceIdField => $resourceId,
                'vote'=>$voteValue
            ]);
            if(!$vote->save(false,false)){
                return false;
            }
        } catch(Exception $e) {
            $this->logError($e->getMessage());
            return false;
        }
        return true;
    }
}