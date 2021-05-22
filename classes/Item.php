<?php

namespace classes;

class Item
{
    private $id;
    private $seller_id;
    private $title;
    private $description;
    private $quantity;
    private $unit;
    private $price;
    private $currency;
    private $item_image;
    private $status;
    private $buyer_id;


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
     * Get the value of seller_id
     */ 
    public function getSeller_id()
    {
        return $this->seller_id;
    }

    /**
     * Set the value of seller_id
     *
     * @return  self
     */ 
    public function setSeller_id($seller_id)
    {
        $this->seller_id = $seller_id;

        return $this;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of quantity
     */ 
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */ 
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get the value of unit
     */ 
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set the value of unit
     *
     * @return  self
     */ 
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */ 
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of currency
     */ 
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set the value of currency
     *
     * @return  self
     */ 
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get the value of item_image
     */ 
    public function getItem_image()
    {
        return $this->item_image;
    }

    /**
     * Set the value of item_image
     *
     * @return  self
     */ 
    public function setItem_image($item_image)
    {
        $this->item_image = $item_image;

        return $this;
    }

    
    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of buyer_id
     */ 
    public function getBuyer_id()
    {
        return $this->buyer_id;
    }

    /**
     * Set the value of buyer_id
     *
     * @return  self
     */ 
    public function setBuyer_id($buyer_id)
    {
        $this->buyer_id = $buyer_id;

        return $this;
    }

    public function save_item()
    {
        //Database connection
        $conn = Db::getConnection();

         //Put all $_FILES array values in seperate variables
         $fileName = $_FILES['item_image']['name'];
         $fileTmpName = $_FILES['item_image']['tmp_name'];
         $fileSize = $_FILES['item_image']['size'];
         $fileError = $_FILES['item_image']['error'];
 
         //Get the file extension
         $fileExt = explode('.', $fileName);
         $fileActualExt = strtolower(end($fileExt));
 
         //Make an array with allowed extensions
         $allowed = array('jpg', 'jpeg', 'png');
 
         if (!(in_array($fileActualExt, $allowed))) {
             //If the file is not a valid extension
             throw new \Exception("The file has to be an image.");
         } elseif ($fileSize > 2000000) {
             //If the file is too big
             throw new \Exception("Your image is too big.");
         } else {
             if ($fileError === 0) {
                 $fileDestination = '/uploads/' . $fileName;
                 move_uploaded_file($fileTmpName, $fileDestination);

      
        //Prepare the INSERT query
        $statement = $conn->prepare("INSERT INTO items (seller_id, title, description, quantity, unit, price, currency, item_image) VALUES (:seller_id, :title, :description, :quantity, :unit, :price, :currency, ('" . $_FILES['item_image']['name'] . "'))");

        //Bind values to parameters from prepared query
        $statement->bindValue(":seller_id", $this->getSeller_id());
        $statement->bindValue(":title", $this->getTitle());
        $statement->bindValue(":description", $this->getDescription());
        $statement->bindValue(":quantity", $this->getQuantity());
        $statement->bindValue(":unit", $this->getUnit());
        $statement->bindValue(":price", $this->getPrice());
        $statement->bindValue(":currency", $this->getCurrency());

        //Execute query
        $result = $statement->execute();

        //Return the results from the query
        return $result;

    }
}

    }
    public function getAllItemsExceptSeller($user)
    {
        $conn = Db::getConnection();

        //<> is the same as !=
        $statement = $conn->prepare("SELECT * FROM items WHERE seller_id <> :seller_id AND status = :status");
        $statement->bindValue(':seller_id', $user->getId());
        $statement->bindValue(':status', "");

        $statement->execute();
        $items = $statement->fetchAll(\PDO::FETCH_OBJ);

        return $items;
    }

    public function getAllItems()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM items WHERE status = :status");
        $statement->bindValue(':status', "");

        $statement->execute();
        $items = $statement->fetchAll(\PDO::FETCH_OBJ);

        return $items;
    }

    public function getAllItemsCart($user){
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM items WHERE buyer_id = :buyer_id AND status = 'pending'");
        $statement->bindValue('buyer_id', $user->getId());
        $statement->execute();

        $cart = $statement->fetchAll(\PDO::FETCH_OBJ);

        return $cart;




    }

    public function getAllItemsBought($user){
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM items WHERE buyer_id = :buyer_id AND status = 'bought'");
        $statement->bindValue('buyer_id', $user->getId());
        $statement->execute();

        $result = $statement->fetchAll(\PDO::FETCH_OBJ);

        return $result;




    }


    
    public function buyItem($user, $id)
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("UPDATE items SET status = :status, buyer_id = :buyer_id WHERE id = :id");
        $statement->bindValue(':status', "pending");
        $statement->bindValue(':buyer_id', $user->getId());
        $statement->bindValue(':id', $id);
        $result = $statement->execute();

        return $result;

    }

    public function deleteItemCart($item_id){
        //Database connection
        $conn = Db::getConnection();
    
        //Prepare the INSERT query
        $statement = $conn->prepare("UPDATE items SET status = :status, buyer_id = :buyer_id Where id = :id");
    
        //Bind values to parameters from prepared query
        $statement->bindValue(":id", $item_id); 
        $statement->bindValue(":status", "");
        $statement->bindValue(":buyer_id", 0);    
        //Execute query
        $result = $statement->execute();
    
        //Return the results from the query
        return $result;
    }

    public function buyAll($user){
        //Database connection
        $conn = Db::getConnection();
    
        //Prepare the INSERT query
        $statement = $conn->prepare("UPDATE items SET status = 'bought' WHERE buyer_id = :buyer_id AND status = 'pending'");
    
        //Bind values to parameters from prepared query
        $statement->bindValue(":buyer_id", $user->getId()); 
        //Execute query
        $result = $statement->execute();
    
        //Return the results from the query
        return $result;
    }


}