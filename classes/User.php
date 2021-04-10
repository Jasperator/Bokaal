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

    public static function getAll()
    {
        //Database connection
        $conn = Db::getConnection();

        //Prepare and executestatement
        $statement = $conn->prepare("SELECT email, fullname, profile_img from users");
        $statement->execute();

        //Fetch all rows as an array indexed by column name
        $users = $statement->fetchAll(\PDO::FETCH_OBJ);

        //Return the result from the query
        return $users;
    }

    //Function that inserts users into the database
    public function save_buyer()
    {
        //Database connection
        $conn = Db::getConnection();

        //Prepare the INSERT query
        $statement = $conn->prepare("INSERT INTO users (fullname, email, password, status) VALUES (:fullname, :email, :password, :status)");

        //Bind values to parameters from prepared query
        $statement->bindValue(":fullname", $this->getFullname());
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
        $statement = $conn->prepare("INSERT INTO users (fullname, email, password, status, btw, company, telephone) VALUES (:fullname, :email, :password, :status, :btw, :company, :telephone)");

        //Bind values to parameters from prepared query
        $statement->bindValue(":fullname", $this->getFullname());
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
        $statement = $conn->prepare("UPDATE users SET bio = :bio, location = :location WHERE email = :email");

        //Bind values to parameters from prepared query
        $statement->bindValue(":bio", $this->getBio());
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
        $statement = $conn->prepare("UPDATE users SET bio = :bio, location  = :location, btw = :btw, company = :company, telephone = :telephone WHERE email = :email");

        //Bind values to parameters from prepared query
        $statement->bindValue(":bio", $this->getBio());
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


    public static function checkPassword($email, $password)
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
                $fileDestination = 'uploads/' . $fileName;
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



    
}
