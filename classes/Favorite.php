<?php

namespace classes;

class Favorite
{
    private $id;
    private $user_id;
    private $favorite_id;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of user_id
     */ 
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */ 
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of favorite_id
     */ 
    public function getFavorite_id()
    {
        return $this->favorite_id;
    }

    /**
     * Set the value of favorite_id
     *
     * @return  self
     */ 
    public function setFavorite_id($favorite_id)
    {
        $this->favorite_id = $favorite_id;

        return $this;
    }

    public function getAllFavorites($user){

                    //Database connection
                    $conn = Db::getConnection();

                    //Prepare the SELECT query
                    $statement = $conn->prepare("SELECT * FROM users INNER JOIN distance ON (distance.user_1 = users.id  AND distance.user_2 = :user_id) OR (distance.user_1 = :user_id  AND distance.user_2 = users.id) WHERE users.id IN (SELECT favorite_id FROM favorites WHERE user_id = :user_id)");
            
                    //Bind values to parameters from prepared query
                    $statement->bindValue(":user_id", $user->getId());
         
                    //Execute query

                    $statement->execute();
                    $favorites = $statement->fetchAll(\PDO::FETCH_OBJ);            
                    //Return the results from the query
                    return $favorites;
    }


public function insertFavorite($user, $favorite_id){
            //Database connection
            $conn = Db::getConnection();

            //Prepare the INSERT query
            $statement = $conn->prepare("INSERT INTO favorites (user_id, favorite_id) VALUES (:user_id, :favorite_id)");
    
            //Bind values to parameters from prepared query
            $statement->bindValue(":user_id", $user->getId());
            $statement->bindValue(":favorite_id", $favorite_id);
 
    
            //Execute query
            $result = $statement->execute();
    
            //Return the results from the query
            return $result;
}

public function deleteFavorite($user, $favorite_id){
    //Database connection
    $conn = Db::getConnection();

    //Prepare the INSERT query
    $statement = $conn->prepare("DELETE FROM favorites Where user_id = :user_id AND favorite_id = :favorite_id");

    //Bind values to parameters from prepared query
    $statement->bindValue(":user_id", $user->getId());
    $statement->bindValue(":favorite_id", $favorite_id);


    //Execute query
    $result = $statement->execute();

    //Return the results from the query
    return $result;
}
    public function deleteOwnFavorites($user){
        //Database connection
        $conn = Db::getConnection();

        //Prepare the INSERT query
        $statement = $conn->prepare("DELETE FROM favorites WHERE user_id = :id");

        //Bind values to parameters from prepared query
        $statement->bindValue(":id", $user->getId());
        //Execute query
        $result = $statement->execute();

        //Return the results from the query
        return $result;
    }
}