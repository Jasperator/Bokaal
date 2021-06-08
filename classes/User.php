<?php

namespace classes;

class User
{
    private $id;
    private $active;
    private $fullname;
    private $email;
    private $password;
    private $profile_img;
    private $bio;
    private $location;
    private $postal_code;
    private $address;
    private $status;
    private $btw;
    private $company;
    private $telephone;




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
     * Get the value of active
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set the value of active
     *
     * @return  self
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get the value of fullname
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * Set the value of fullname
     *
     * @return  self
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }


    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $statement->bindValue(":email", $email);
        $statement->execute();
        $existing_emails = $statement->rowCount();

        //Check if the email is unique
        if ($existing_emails > 0) {
            return $error = "Email already in use";
         } else {

            //If it's unique, save the property
            $this->email = $email;
            return $this;
        }
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {



        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        //Encrypt the password
        $password = password_hash($password, PASSWORD_BCRYPT);
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of profile_img
     */
    public function getProfile_img()
    {
        return $this->profile_img;
    }

    /**
     * Set the value of profile_img
     *
     * @return  self
     */
    public function setProfile_img($profile_img)
    {
        $this->profile_img = $profile_img;

        return $this;
    }
    /**
     * Get the value of bio
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * Set the value of bio
     *
     * @return  self
     */
    public function setBio($bio)
    {
        $this->bio = $bio;

        return $this;
    }

    /**
     * Get the value of location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set the value of location
     *
     * @return  self
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    

    /**
     * Get the value of postal_code
     */ 
    public function getPostal_code()
    {
        return $this->postal_code;
    }

    /**
     * Set the value of postal_code
     *
     * @return  self
     */ 
    public function setPostal_code($postal_code)
    {
        $this->postal_code = $postal_code;

        return $this;
    }
    
    /**
     * Get the value of address
     */ 
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @return  self
     */ 
    public function setAddress($address)
    {
        $this->address = $address;

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
     * Get the value of btw
     */ 
    public function getBtw()
    {
        return $this->btw;
    }

    /**
     * Set the value of btw
     *
     * @return  self
     */ 
    public function setBtw($btw)
    {
        $this->btw = $btw;

        return $this;
    }

    /**
     * Get the value of company
     */ 
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set the value of company
     *
     * @return  self
     */ 
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get the value of telephone
     */ 
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set the value of telephone
     *
     * @return  self
     */ 
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }


    public function getAllUsers()
    {
        //Prepared \PDO statement that fetches the password corresponding to the inputted email
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM users WHERE id <> :id");
        $statement->bindValue(':id', $this->getId());
        $statement->execute();
        $users = $statement->fetchAll(\PDO::FETCH_OBJ);
        return $users;

    }

    //Function that inserts users into the database
    public function save_buyer()
    {
        //Database connection
        $conn = Db::getConnection();

        //Prepare the INSERT query
        $statement = $conn->prepare("INSERT INTO users (fullname,postal_code, location, address ,email, password, status) VALUES (:fullname,:postal_code, :location, :address, :email, :password, :status)");

        //Bind values to parameters from prepared query
        $statement->bindValue(":fullname", $this->getFullname());
        $statement->bindValue(":postal_code", $this->getPostal_code());
        $statement->bindValue(":address", $this->getAddress());
        $statement->bindValue(":location", $this->getLocation());
        $statement->bindValue(":email", $this->getEmail());
        $statement->bindValue(":password", $this->getPassword());
        $statement->bindValue(":status", "buyer");


        //Execute query
        $result = $statement->execute();

        //Return the results from the query
        return $result;
    }

    public function save_seller()
    {
        //Database connection
        $conn = Db::getConnection();

        //Prepare the INSERT query
        $statement = $conn->prepare("INSERT INTO users (fullname, postal_code, location, address, email, password, status, btw, company, telephone) VALUES (:fullname,:postal_code, :location, :address, :email, :password, :status, :btw, :company, :telephone)");

        //Bind values to parameters from prepared query
        $statement->bindValue(":fullname", $this->getFullname());
        $statement->bindValue(":postal_code", $this->getPostal_code());
        $statement->bindValue(":address", $this->getAddress());
        $statement->bindValue(":location", $this->getLocation());
        $statement->bindValue(":email", $this->getEmail());
        $statement->bindValue(":password", $this->getPassword());
        $statement->bindValue(":status", "seller");
        $statement->bindValue(":btw", $this->getBtw());
        $statement->bindValue(":company", $this->getCompany());
        $statement->bindValue(":telephone", $this->getTelephone());



        //Execute query
        $result = $statement->execute();

        //Return the results from the query
        return $result;
    }


    //Magic function __construct that gets called every time a new User() is made
    //Takes one argument: $email which is used to determine what user is taken from the database
    public function __construct($email)
    {

        //Select all of the user's data from the database
        $conn = Db::getConnection();
        $statement = $conn->prepare('SELECT * FROM users WHERE email = :email');
        $statement->bindValue(':email', $email);
        $statement->execute();
        $user = $statement->fetch(\PDO::FETCH_OBJ);

        //If the search returns a result, set all the objects properties to the properties taken from the database
        if (!empty($user)) {
            $this->id = $user->id;
            $this->active = $user->active;
            $this->fullname = $user->fullname;
            $this->email = $user->email;
            $this->password = $user->password;
            $this->profile_img = $user->profile_img;
            $this->bio = $user->bio;
            $this->location = $user->location;
            $this->postal_code = $user->postal_code;
            $this->address = $user->address;
            $this->btw = $user->btw;
            $this->company = $user->company;
            $this->telephone = $user->telephone;
            $this->status = $user->status;

        }
    }

    //Function that changes the password
    public function changePassword($new_password)
    {
        $conn = Db::getConnection();

        //Encrypt the password
        $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

        $insert = $conn->prepare("UPDATE users SET password = :new_password WHERE email = :email");
        $insert->bindValue(':email', $this->getEmail());
        $insert->bindValue(':new_password', $new_password);
        $insert->execute();
    }

    //Function that changes the email
    public function changeEmail($new_email)
    {
        $conn = Db::getConnection();

        //Make email case insensitive
        $new_email = strtolower($new_email);

        $insert = $conn->prepare("UPDATE users SET email = :new_email WHERE id = :id");
        $insert->bindValue(':id', $this->getId());
        $insert->bindValue(':new_email', $new_email);
        $insert->execute();

        //Set the $_SESSION['user'] to the new email, otherwise everything breaks
        $_SESSION['user'] = $new_email;
    }


    //Function that updates profile in the database
    public function completeProfile()
    {
        //Database connection
        $conn = Db::getConnection();

        //Prepare the INSERT query
        $statement = $conn->prepare("UPDATE users SET bio = :bio, postal_code = :postal_code, address = :address, location = :location WHERE email = :email");

        //Bind values to parameters from prepared query
        $statement->bindValue(":bio", $this->getBio());
        $statement->bindValue(":postal_code", $this->getPostal_code());
        $statement->bindValue(":address", $this->getAddress());
        $statement->bindValue(":location", $this->getLocation());
        $statement->bindValue(":email", $_SESSION['user']);

        //Execute query
        $result = $statement->execute();

        //Return the results from the query
        return $result;
    }
    public function completeProfileSeller()
    {
        //Database connection
        $conn = Db::getConnection();

        //Prepare the INSERT query
        $statement = $conn->prepare("UPDATE users SET bio = :bio, postal_code = :postal_code, address = :address, location  = :location, btw = :btw, company = :company, telephone = :telephone WHERE email = :email");

        //Bind values to parameters from prepared query
        $statement->bindValue(":bio", $this->getBio());
        $statement->bindValue(":postal_code", $this->getPostal_code());
        $statement->bindValue(":address", $this->getAddress());
        $statement->bindValue(":location", $this->getLocation());
        $statement->bindValue(":btw", $this->getBtw());
        $statement->bindValue(":company", $this->getCompany());
        $statement->bindValue(":telephone", $this->getTelephone());
        $statement->bindValue(":email", $_SESSION['user']);



        //Execute query
        $result = $statement->execute();

        //Return the results from the query
        return $result;
    }


    public static function checkPassword($email, $password): bool
    {
        //Prepared \PDO statement that fetches the password corresponding to the inputted email
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT password FROM users WHERE email = :email");
        $statement->bindValue(":email", $email);
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        //Check if the password is correct
        if (isset($result['password'])) {
            if (password_verify($password, $result['password'])) {
                return true; 
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function retrieveStatus()
    {
        //Prepared \PDO statement that fetches the password corresponding to the inputted email
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT status FROM users WHERE email = :email");
        $statement->bindValue(':email', $this->getEmail());
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return $result['status'];
        
    }

    //Function that fetches all users from the database except for the active user
    public function getAllExceptUser()
    {
        $conn = Db::getConnection();

        //<> is the same as !=
        $statement = $conn->prepare("SELECT * FROM users WHERE email <> :email");
        $statement->bindValue(':email', $this->getEmail());
        $statement->execute();
        $users = $statement->fetchAll(\PDO::FETCH_OBJ);

        return $users;
    }

    public function getSellersExceptUser()
    {

        $conn = Db::getConnection();

        $results_per_page = 6; // number of results per page
        if (isset($_GET["page"])) { $page = $_GET["page"]; } else { $page=1; };
        $start_from = ($page-1) * $results_per_page;
        //<> is the same as !=
        $statement = $conn->prepare("SELECT * FROM users INNER JOIN distance ON (distance.user_1 = users.id  AND distance.user_2 = :user_id) OR (distance.user_1 = :user_id  AND distance.user_2 = users.id) WHERE email <> :email AND status = 'seller' AND  users.id NOT IN (SELECT favorite_id FROM favorites WHERE user_id = :user_id) ORDER BY distanceValue  ASC LIMIT  $start_from, $results_per_page");
        $statement->bindValue(':email', $this->getEmail());
        $statement->bindValue(':user_id', $this->getId());

        $statement->execute();
        $users = $statement->fetchAll(\PDO::FETCH_OBJ);

        return array($page, $users);
    }

    public function countPages()
    {

        $conn = Db::getConnection();
        $results_per_page = 3;

        $statement = $conn->prepare("SELECT COUNT(id) FROM users WHERE email <> :email AND status = 'seller' AND  id NOT IN (SELECT favorite_id FROM favorites WHERE user_id = :user_id)");
        $statement->bindValue(':email', $this->getEmail());
        $statement->bindValue(':user_id', $this->getId());
        $statement->execute();
        $row = $statement->fetch(\PDO::FETCH_COLUMN);
        $total_pages = ceil($row / $results_per_page); // calculate total pages with results

        return $total_pages;

    }

        //Function that finds all conversations a user is a part of
        public function getActiveConversations()
        {
            $conn = Db::getConnection();
            $statement = $conn->prepare("SELECT * FROM conversations WHERE (user_1 = :user_id OR user_2 = :user_id) AND active = 1");
            $statement->bindValue(":user_id", $this->getId());

            $statement->execute();
            $users = $statement->fetch(\PDO::FETCH_OBJ);
            return $users;
        }
        public function getConversations()
        {
            $conn = Db::getConnection();
    
            //<> is the same as !=
            $statement = $conn->prepare("SELECT * FROM conversations WHERE (user_1 = :user_id OR user_2 = :user_id) AND active = 1");
            $statement->bindValue(':user_id', $this->getId());
    
            $statement->execute();
            $users = $statement->fetchAll(\PDO::FETCH_OBJ);
    
            return $users;
        }

    public function getSpecifiqueConversations($seller_id)
    {
        $conn = Db::getConnection();

        //<> is the same as !=
        $statement = $conn->prepare("SELECT * FROM conversations WHERE (user_1 = :user_id AND user_2 = :seller_id) OR (user_1 = :seller_id AND user_2 = :user_id)AND active = 1");
        $statement->bindValue(':user_id', $this->getId());
        $statement->bindValue(':seller_id', $seller_id);


        $statement->execute();
        $users = $statement->fetch(\PDO::FETCH_OBJ);

        return $users;
    }

    public function getPartnerConversations()
    {
        $conn = Db::getConnection();

        //<> is the same as !=
        $statement = $conn->prepare("SELECT id,  CASE WHEN user_1 <> :user_id THEN user_1 ELSE user_2 END FROM conversations WHERE (user_1 = :user_id OR user_2 = :user_id) AND active = 1");
        $statement->bindValue(':user_id', $this->getId());

        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_COLUMN);
        return $result;
    }

    public function getUserById($user_id)
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("SELECT * FROM users WHERE id = :user_id");
        $statement->bindValue(':user_id', $user_id);

        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_OBJ);

        return $result;
    }

    public function standardProfilePicture()
    {
                //Put the file path in the database
                $conn = Db::getConnection();
                $statement = $conn->prepare("UPDATE users  SET profile_img = ('no-profile.png') WHERE email = :email");
                $statement->bindValue(":email", $this->getEmail());
                $img = $statement->execute();
                return $img;
            }


    public function saveProfile_img()
    {
        //Put all $_FILES array values in seperate variables
        $fileName = $_FILES['profile_img']['name'];
        $fileTmpName = $_FILES['profile_img']['tmp_name'];
        $fileSize = $_FILES['profile_img']['size'];
        $fileError = $_FILES['profile_img']['error'];

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
                define ('SITE_ROOT', realpath(dirname(__FILE__)));

                $fileDestination = '../../uploads/' . $fileName;
                move_uploaded_file($fileTmpName, $fileDestination);

                //Put the file path in the database
                $conn = Db::getConnection();
                $statement = $conn->prepare("UPDATE users  SET profile_img = ('" . $_FILES['profile_img']['name'] . "') WHERE email = :email");
                $statement->bindValue(":email", $this->getEmail());
                $img = $statement->execute();
                return $img;
            }
        }
    }


    public function getAllItemsById($id)
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("SELECT * FROM items WHERE seller_id = :id AND status = :status");

        //Bind values to parameters from prepared query
        $statement->bindValue(":id", $id);
        $statement->bindValue(":status", '');


        //Execute query
        $statement->execute();

        $result = $statement->fetchAll(\PDO::FETCH_OBJ);

        //Return the results from the query
        return $result;

    }

    public function getUserFromId($seller_id)
    {
        $conn = Db::getConnection();

        $statement = $conn->prepare("SELECT * FROM users INNER JOIN distance ON (distance.user_1 = :user_id  AND distance.user_2 = :seller_id) OR (distance.user_1 = :seller_id AND distance.user_2 = :user_id) WHERE id = :seller_id");

        //Bind values to parameters from prepared query
        $statement->bindValue(":user_id", $this->getId());
        $statement->bindValue(":seller_id", $seller_id);

        //Execute query
        $statement->execute();

        $result = $statement->fetch(\PDO::FETCH_OBJ);

        //Return the results from the query
        return $result;

    }
    function getDistance($addressFrom, $postalcodeoFrom, $addressTo, $postalcodeoTo){
        // Google API key
        $apiKey = 'AIzaSyAZvw5R_4B6VsHG9MTrobGTrWFAL3gosNk';

        // Change address format
        $formattedAddrFrom    = str_replace(' ', '+', $addressFrom);
        $formattedAddrTo     = str_replace(' ', '+', $addressTo);

        // Geocoding API request with start address
        $calculateDistanceMatrix = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?origins='.$formattedAddrFrom.','. $postalcodeoFrom .'&destinations='.$formattedAddrTo .'+'. $postalcodeoTo . '&key=' .$apiKey);
        $calculateDistance = json_decode($calculateDistanceMatrix);
        $calculeteDistanceKm = $calculateDistance->rows[0]->elements[0]->distance;
        return($calculeteDistanceKm);



    }
    public function deleteUser(){
        //Database connection
        $conn = Db::getConnection();

        //Prepare the INSERT query
        $statement = $conn->prepare("DELETE FROM users WHERE id = :id");

        //Bind values to parameters from prepared query
        $statement->bindValue(":id", $this->getId());
        //Execute query
        $result = $statement->execute();

        //Return the results from the query
        return $result;
    }


    


}
