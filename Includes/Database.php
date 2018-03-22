<?php
/**
 * Created by PhpStorm.
 * Users: sohail
 * Date: 1/22/2018
 * Time: 11:57 AM
 */

class Database
{

    private $host ="mongodb://localhost:27017";


    private $client;
    private $error;
    private $database;
    private $userCollection;
    private $articleCollection;
    private $categoryCollection;


    public function __construct()
    {

        //connection to mongodb and select database
        try
        {
            if ( is_null( $this->client) )
            {

                $this->client = new MongoDB\Client($this->host);

                $this->database = $this->client->wyredLearning;

                $this->userCollection= $this->database->Users;

                $this->articleCollection= $this->database->Articles;
                $this->categoryCollection= $this->database->category;

//                die(print_r($this->userCollection));
            }
        }
        catch (MongoDB\Driver\Exception\ConnectionException $e)
        {
            $this->error = $e->getMessage();
            die("Failed to connect to database ".$this->error);
        }


    }
    public  function GetAll()
    {
        return $this->userCollection->find();

    }
    public function collectionCount()
    {
        return $this->userCollection->count();

    }
//register new user
    public function Insert($data)
    {
        $idOfInsertedDoc = null;
        $insertedDocument = $this->userCollection->insertOne(['name'=>$data['name'],'email'=>$data['email'],'password'=>$data['password']]);
        $idOfInsertedDoc = $insertedDocument->getInsertedId();


        if ($idOfInsertedDoc != null)
        {

            return true;
        }
        else
        {

            return false;
        }

    }
    //if email is already exist for new user to register
    public  function mailExist($email)
    {

        $flag = false;
        try {

            $document = $this->userCollection->find(['email' => $email]);

        }
        catch (MongoException $e)
        {
            die("user not found ".$e);
        }
        foreach ($document as $Array => $subArray)
        {
            foreach ($subArray as $key => $value)
            {

                if ($email == $value)
                {
                    $flag = true;
                }
            }
        }

        if ($flag)
        {
            return true;
        }
        else
        {
            return false;
        }


    }
    //login
    public function LoginWithEmail($email,$password)
    {


        try
        {
            $user = $this->userCollection->findOne(['$and'=>[['email'=>$email],['password'=>$password]]]);
        }
        catch (MongoDB\Driver\Exception\Exception $e)
        {
            $this->error = $e->getMessage();
            die("Failed to Fetch User from the database ".$this->error);
        }



        if (!empty($user))
        {

            return $user;
        }
        else
        {

            return false;
        }
    }
    public function GetAllPosts()
    {
        $result = $this->articleCollection->find(
                [],['sort'=> ['postCreated' =>-1]]
                
                
                );
//         if(!empty($result)) {
//             foreach ($result as $item)
//         {
//            print_r($item['title']);
//         }
//         }
//         else
//             {
//                 die("there is no data");
//             }

        return $result;

    }
    public function AddPosts($data)
    {
   
        $article =
            [
                'title' => $data['title'],
                'body' => $data['body'],
                'name'=> $data['userName'],
                'userId'=>$data['userId'],
                'postCreated' => $data['postCreated'],
                'image'=>$data['image']

            ];
        try {
            $this->articleCollection->insertOne($article);
            return true;
        }
        catch(MongoDB\Driver\Exception\Exception $e)
        {
            die('Failed to insert data '.$e->getMessage());
            return false;
        }


    }
    public function getPostByID($id)
    {
        try
        {
            return $this->articleCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
        }
        catch(MongoDB\Driver\Exception\Exception $e)
        {
            die('Failed to get data '.$e->getMessage());

        }
    }

    public function updatePostEdit($data)
    {


        try {
            $this->articleCollection->updateOne(['userId'=>$data['userId']],['$set'=>['title'=>$data['title'],'body'=>$data['body']]]);
            return true;
        }
        catch(MongoDB\Driver\Exception\Exception $e)
        {
            die('Failed to insert data '.$e->getMessage());
            return false;
        }


    }
    
     public function deletePost($id)
    {
      

        try {
           return  $this->articleCollection->deleteOne(['_id'=>new MongoDB\BSON\ObjectId ($id )]);
        
        }
        catch(MongoDB\Driver\Exception\Exception $e)
        {
            die('Failed to Delete data '.$e->getMessage());
            return false;
        }


    }

}