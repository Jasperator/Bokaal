<?php

namespace classes;

class Item
{
    private $id;
    private $seller_id;
    private $title;
    private $category;
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
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
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
                 $fileDestination = '../../uploads/' . $fileName;
                 move_uploaded_file($fileTmpName, $fileDestination);

      
        //Prepare the INSERT query
        $statement = $conn->prepare("INSERT INTO items (seller_id, title, description, category, quantity, unit, price, currency, item_image) VALUES (:seller_id, :title, :description,:category, :quantity, :unit, :price, :currency, ('" . $_FILES['item_image']['name'] . "'))");

        //Bind values to parameters from prepared query
        $statement->bindValue(":seller_id", $this->getSeller_id());
        $statement->bindValue(":title", $this->getTitle());
        $statement->bindValue(":category", $this->getCategory());
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
    public function countPagesAllItemsExceptSeller($user)
    {

        $conn = Db::getConnection();
        $results_per_page = 12;

        $statement = $conn->prepare("SELECT COUNT(id) FROM items WHERE seller_id <> :user_id AND status = :status");
        $statement->bindValue(':user_id', $user->getId());
        $statement->bindValue(':status', '');

        $statement->execute();
        $row = $statement->fetch(\PDO::FETCH_COLUMN);
        $total_pages = ceil($row / $results_per_page); // calculate total pages with results

        return $total_pages;

    }
    public function countPagesAllItems()
    {

        $conn = Db::getConnection();
        $results_per_page = 12;

        $statement = $conn->prepare("SELECT COUNT(id) FROM items WHERE status = :status");
        $statement->bindValue(':status', '');

        $statement->execute();
        $row = $statement->fetch(\PDO::FETCH_COLUMN);
        $total_pages = ceil($row / $results_per_page); // calculate total pages with results

        return $total_pages;

    }
    public function getAllItemsExceptSeller($user)
    {
        $conn = Db::getConnection();

        $results_per_page = 12; // number of results per page
        if (isset($_GET["page"])) { $page = $_GET["page"]; } else { $page=1; };
        $start_from = ($page-1) * $results_per_page;

        $statement = $conn->prepare("SELECT * FROM items INNER JOIN distance ON (distance.user_1 = :user_id  AND distance.user_2 = items.seller_id) OR (distance.user_1 = items.seller_id AND distance.user_2 = :user_id)  WHERE seller_id <> :user_id AND status = :status  ORDER BY distanceValue ASC LIMIT  $start_from, $results_per_page");
        $statement->bindValue(':user_id', $user->getId());
        $statement->bindValue(':status', '');

        $statement->execute();
        $items = $statement->fetchAll(\PDO::FETCH_OBJ);

        return array($page, $items);
    }
    public function getAvailableItemsFromSeller($user)
    {
        $conn = Db::getConnection();

        //<> is the same as !=
        $statement = $conn->prepare("SELECT * FROM items WHERE seller_id = :seller_id AND status = :status");
        $statement->bindValue(':seller_id', $user->getId());
        $statement->bindValue(':status', '');

        $statement->execute();
        $items = $statement->fetchAll(\PDO::FETCH_OBJ);

        return $items;
    }


    public function getAllItems($user)
    {
        $conn = Db::getConnection();

        $results_per_page = 12; // number of results per page
        if (isset($_GET["page"])) { $page = $_GET["page"]; } else { $page=1; };
        $start_from = ($page-1) * $results_per_page;

        $statement = $conn->prepare("SELECT * FROM items INNER JOIN distance ON (distance.user_1 = :user_id  AND distance.user_2 = items.seller_id) OR (distance.user_1 = items.seller_id AND distance.user_2 = :user_id) WHERE status = :status ORDER BY distanceValue ASC LIMIT  $start_from, $results_per_page");
        $statement->bindValue(':status', "");
        $statement->bindValue(':user_id', $user->getId());


        $statement->execute();
        $items = $statement->fetchAll(\PDO::FETCH_OBJ);

        return array($page, $items);
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
    public function getItem($id)
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("SELECT * FROM items WHERE id = :id");

        //Bind values to parameters from prepared query
        $statement->bindValue(":id", $id);

        //Execute query
        $statement->execute();

        $result = $statement->fetch(\PDO::FETCH_OBJ);

        //Return the results from the query
        return $result;

    }

    public function updateItem($item_id)
    {
        //Database connection
        $conn = Db::getConnection();

        //Prepare the INSERT query
        $statement = $conn->prepare("UPDATE items SET title = :title, category = :category, description = :description, quantity  = :quantity, unit = :unit, price = :price, currency = :currency WHERE id = :item_id");

        //Bind values to parameters from prepared query
        $statement->bindValue(":title", $this->getTitle());
        $statement->bindValue(":category", $this->getCategory());
        $statement->bindValue(":description", $this->getDescription());
        $statement->bindValue(":quantity", $this->getQuantity());
        $statement->bindValue(":unit", $this->getUnit());
        $statement->bindValue(":price", $this->getPrice());
        $statement->bindValue(":currency", $this->getCurrency());
        $statement->bindValue(":item_id", $item_id);


        //Execute query
        $result = $statement->execute();

        //Return the results from the query
        return $result;

    }
    public function searchItemName($name, $user)
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("SELECT * FROM `items` WHERE (title LIKE :name OR description LIKE  :name) AND status = :status AND seller_id <> :user_id");

        //Bind values to parameters from prepared query
        $statement->bindValue(":name", $name);
        $statement->bindValue(":status", '');
        $statement->bindValue(":user_id", $user->getId());


        //Execute query
        $statement->execute();

        $result = $statement->fetchAll(\PDO::FETCH_OBJ);

        //Return the results from the query
        return $result;

    }

    public function searchItemCategory($category, $user)
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("SELECT * FROM items WHERE category = :category AND status = :status AND seller_id <> :user_id");

        //Bind values to parameters from prepared query
        $statement->bindValue(":category", $category);
        $statement->bindValue(":status", '');
        $statement->bindValue(":user_id", $user->getId());



        //Execute query
        $statement->execute();

        $result = $statement->fetchAll(\PDO::FETCH_OBJ);

        //Return the results from the query
        return $result;

    }

    public function maxPrice()
    {
        $conn = Db::getConnection();


        $statement = $conn->prepare("SELECT MAX(price) FROM `items` WHERE status = :status");
        $statement->bindValue(":status", '');


        //Execute query
        $statement->execute();

        $result = $statement->fetch(\PDO::FETCH_COLUMN);

        //Return the results from the query
        return $result;

    }
    public function searchItemCategoryAndName($name, $category, $user, $maxPrice,$distanceRange)
    {
        $conn = Db::getConnection();
        $results_per_page = 12; // number of results per page
        if (isset($_GET["page"])) { $page = $_GET["page"]; } else { $page=1; };
        $start_from = ($page-1) * $results_per_page;


        $statement = $conn->prepare("SELECT * FROM items INNER JOIN distance ON (distance.user_1 = :user_id  AND distance.user_2 = items.seller_id) OR (distance.user_1 = items.seller_id AND distance.user_2 = :user_id) WHERE category = $category AND (title LIKE :name OR description LIKE  :name) AND status = :status AND seller_id <> :user_id AND price <= :maxPrice AND distanceValue <= :distance ORDER BY distanceValue ASC LIMIT  $start_from, $results_per_page");

        //Bind values to parameters from prepared query
        $statement->bindValue(":name", $name);
        $statement->bindValue(":status", '');
        $statement->bindValue(":user_id", $user->getId());
        $statement->bindValue(":maxPrice",$maxPrice);
        $statement->bindValue(":distance",$distanceRange);

        //Execute query
        $statement->execute();

        $result = $statement->fetchAll(\PDO::FETCH_OBJ);

        //Return the results from the query
        return array($page, $result);

    }
    public function searchItemCategoryAndNameCount($name, $category, $user, $maxPrice,$distanceRange)
    {
        $conn = Db::getConnection();
        $results_per_page = 12; // number of results per page
      $statement = $conn->prepare("SELECT COUNT(id) FROM items INNER JOIN distance ON (distance.user_1 = :user_id  AND distance.user_2 = items.seller_id) OR (distance.user_1 = items.seller_id AND distance.user_2 = :user_id) WHERE category = $category AND (title LIKE :name OR description LIKE  :name) AND status = :status AND seller_id <> :user_id AND price <= :maxPrice AND distanceValue <= :distance ORDER BY distanceValue");

        //Bind values to parameters from prepared query
        $statement->bindValue(":name", $name);
        $statement->bindValue(":status", '');
        $statement->bindValue(":user_id", $user->getId());
        $statement->bindValue(":maxPrice",$maxPrice);
        $statement->bindValue(":distance",$distanceRange);

        //Execute query
        $statement->execute();
        $row = $statement->fetch(\PDO::FETCH_COLUMN);

        $total_pages = ceil($row / $results_per_page); // calculate total pages with results

        return $total_pages;

    }


    public function getUserFromItem($user, $id)
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("SELECT * FROM users INNER JOIN distance ON (distance.user_1 = :user_id  AND distance.user_2 = (SELECT seller_id FROM items WHERE id = :id)) OR (distance.user_1 = (SELECT seller_id FROM items WHERE id = :id) AND distance.user_2 = :user_id) WHERE id = (SELECT seller_id FROM items WHERE id = :id)");

        //Bind values to parameters from prepared query
        $statement->bindValue(":user_id", $user->getId());
        $statement->bindValue(":id", $id);

        //Execute query
        $statement->execute();

        $result = $statement->fetch(\PDO::FETCH_OBJ);

        //Return the results from the query
        return $result;

    }

    public function getAllItemsBySellerId($itemId)
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("SELECT * FROM items WHERE seller_id IN (SELECT seller_id from items WHERE id = :itemId) AND status = :status AND id <> $itemId");

        //Bind values to parameters from prepared query
        $statement->bindValue(":itemId", $itemId);
        $statement->bindValue(":status", '');


        //Execute query
        $statement->execute();

        $result = $statement->fetchAll(\PDO::FETCH_OBJ);

        //Return the results from the query
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

    public function deleteOwnItem($item_id, $user){
        //Database connection
        $conn = Db::getConnection();

        //Prepare the INSERT query
        $statement = $conn->prepare("DELETE FROM items WHERE id = :id AND seller_id = :seller_id AND status = :status AND buyer_id = :buyer_id");

        //Bind values to parameters from prepared query
        $statement->bindValue(":id", $item_id);
        $statement->bindValue(":seller_id", $user->getId());
        $statement->bindValue(":status", "");
        $statement->bindValue(":buyer_id", 0);
        //Execute query
        $result = $statement->execute();

        //Return the results from the query
        return $result;
    }


    public function deleteAllOwnItem($user){
        //Database connection
        $conn = Db::getConnection();

        //Prepare the INSERT query
        $statement = $conn->prepare("DELETE FROM items WHERE seller_id = :seller_id AND status = :status AND buyer_id = :buyer_id");

        //Bind values to parameters from prepared query
        $statement->bindValue(":seller_id", $user->getId());
        $statement->bindValue(":status", "");
        $statement->bindValue(":buyer_id", 0);
        //Execute query
        $result = $statement->execute();

        //Return the results from the query
        return $result;
    }
    public function deleteAllItemCart($user){
        //Database connection
        $conn = Db::getConnection();

        //Prepare the INSERT query
        $statement = $conn->prepare("UPDATE items SET status = :status, buyer_id = :buyer_id Where buyer_id = :id");

        //Bind values to parameters from prepared query
        $statement->bindValue(":id", $user->getId());
        $statement->bindValue(":status", "");
        $statement->bindValue(":buyer_id", 0);
        //Execute query
        $result = $statement->execute();

        //Return the results from the query
        return $result;
    }


    public function getAllSellersCart($user){
        //Database connection
        $conn = Db::getConnection();

        //Prepare the INSERT query
        $statement = $conn->prepare("SELECT * FROM users WHERE id IN (SELECT seller_id FROM `items` WHERE status = 'pending' AND  buyer_id = :buyer_id)");

        //Bind values to parameters from prepared query
        $statement->bindValue(":buyer_id", $user->getId());

        //Execute query
        $statement->execute();

        $result = $statement->fetchAll(\PDO::FETCH_OBJ);

        //Return the results from the query
        return $result;
    }

    public function getBoughtItems($user, $seller_id){
        //Database connection
        $conn = Db::getConnection();

        //Prepare the INSERT query
        $statement = $conn->prepare("SELECT * FROM items WHERE status = 'pending' AND  buyer_id = :buyer_id AND seller_id = :seller_id");

        //Bind values to parameters from prepared query
        $statement->bindValue(":buyer_id", $user->getId());
        $statement->bindValue(":seller_id", $seller_id);


        //Execute query
        $statement->execute();

        $result = $statement->fetchAll(\PDO::FETCH_OBJ);

        //Return the results from the query
        return $result;
    }

    public function startConversationSellers($user, $seller_id){
        //Database connection
        $conn = Db::getConnection();

        //Prepare the INSERT query
            $statement = $conn->prepare("INSERT INTO conversations (user_1, user_2, active) SELECT :buyer_id, :seller_id, 1 WHERE NOT EXISTS (SELECT * FROM conversations WHERE (user_1 = :buyer_id AND user_2 = :seller_id) OR (user_1 = :seller_id AND user_2 = :buyer_id) )");

        //Bind values to parameters from prepared query
        $statement->bindValue(":buyer_id", $user->getId());
        $statement->bindValue(":seller_id", $seller_id);

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

    public function countAllItems($user)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT COUNT(id) FROM `items` WHERE buyer_id = :user_id AND status = 'pending'");
        $statement->bindValue(":user_id", $user->getId());

        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_COLUMN);

        return $result;

    }



}