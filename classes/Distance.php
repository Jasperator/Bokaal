<?php


namespace classes;


class Distance
{
    private $id;
    private $user_1;
    private $user_2;
    private $distance;
    private $distanceValue;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUser1()
    {
        return $this->user_1;
    }

    /**
     * @param mixed $user_1
     */
    public function setUser1($user_1): void
    {
        $this->user_1 = $user_1;
    }

    /**
     * @return mixed
     */
    public function getUser2()
    {
        return $this->user_2;
    }

    /**
     * @param mixed $user_2
     */
    public function setUser2($user_2): void
    {
        $this->user_2 = $user_2;
    }

    /**
     * @return mixed
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param mixed $distance
     */
    public function setDistance($distance): void
    {
        $this->distance = $distance;
    }

    /**
     * @return mixed
     */
    public function getDistanceValue()
    {
        return $this->distanceValue;
    }

    /**
     * @param mixed $distanceValue
     */
    public function setDistanceValue($distanceValue): void
    {
        $this->distanceValue = $distanceValue;
    }

    function insertDistance($userId, $user_2, $distance, $distanceValue){

        //Database connection
        $conn = Db::getConnection();

        //Prepare the INSERT query
        $statement = $conn->prepare("INSERT INTO distance (user_1, user_2, distance, distanceValue) SELECT :id, :user_2,:distance, :distanceValue WHERE NOT EXISTS (SELECT * FROM distance WHERE (user_1 = :id AND user_2 = :user_2) OR (user_1 = :user_2 AND user_2 = :id))");


        //Bind values to parameters from prepared query
        $statement->bindValue(":id", $userId);
        $statement->bindValue(":user_2", $user_2);
        $statement->bindValue(":distance", $distance);
        $statement->bindValue(":distanceValue", $distanceValue);

        //Execute query
        $statement->execute();

        //Return the results from the query

    }

    public function maxDistanceItems($user)
    {
        $conn = Db::getConnection();


        $statement = $conn->prepare("SELECT MAX(distanceValue)  FROM items INNER JOIN distance ON (distance.user_1 = :user_id  AND distance.user_2 = items.seller_id) OR (distance.user_1 = items.seller_id AND distance.user_2 = :user_id)");
        $statement->bindValue(":user_id", $user->getId());

        //Execute query
        $statement->execute();

        $result = $statement->fetch(\PDO::FETCH_COLUMN);

        //Return the results from the query
        return $result;

    }
    public function minDistanceItems($user)
    {
        $conn = Db::getConnection();


        $statement = $conn->prepare("SELECT MIN(distanceValue)  FROM items INNER JOIN distance ON (distance.user_1 = :user_id  AND distance.user_2 = items.seller_id) OR (distance.user_1 = items.seller_id AND distance.user_2 = :user_id)");
        $statement->bindValue(":user_id", $user->getId());

        //Execute query
        $statement->execute();

        $result = $statement->fetch(\PDO::FETCH_COLUMN);

        //Return the results from the query
        return $result;

    }
    function getDistanceById($user, $userID){
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM distance WHERE (user_1 = :id AND user_2 = :user_id) OR  (user_1 = :user_id AND user_2 = :id)");
        $statement->bindValue(":id", $user->getId());
        $statement->bindValue(":user_id", $userID);
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_OBJ);

        return $result;
    }
}