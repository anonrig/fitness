<?php

require_once ("include/autoLoader.php");
require_once("include/DBHelper.php");

class FitnessProgram {
        private $programId; //id of the fitness program

        private $title; //title of the fitness program

        private $details; //description about the program, string

        private $user; //associated user object

        private $exercises = array(); //array of the exercises. takes name(string), time(datetime), bodypart(string), repetition(string), weight(string), day(index 1 to 7, string, may change it to integer on db)
        
        private $exerciseParts = array("name", "day", "repetition");
        
        private static $db = null;
        
        public static $currentTime = 'DATE_ADD(NOW(), INTERVAL 8 HOUR)';
        
        private static $dbTablePrograms = "programs";

        private static $dbTableProgramDetails = "programdetails";
        
        /**
         * Constructor
         */
        public function __construct(User $userObject, $title, $details, $saveToDb = true) {
                
                if (isset($userObject)){
                        $userObject->setFitnessProgram($this);
                        //Contruct the fitness program without any exercises
                        
                        $this->user = $userObject;
                        $this->title = $title;
                        $this->details = $details;

                        $userId = $this->user->getUserId();
                                
                        // Write the object to the db
                        if ($saveToDb){
								$db = null;
								// Setup the database connection
								if ($db == null){
										$db = new DBHelper();
								}
								self::$db = $db;
                                $title = $this->title;
                                $details = $this->details;
                                $currentTime = self::$currentTime;
                                $query = "INSERT INTO programs (title, details, user_id, created_at, updated_at) VALUES ('$title', '$details', '$userId', $currentTime, $currentTime)";
                                
                                // Will write to the DB
                                $db -> query($query);
                        }
                        // Set the id anyway
                        $this->programId = $this->getProgramId();
                } else {
                        throw new InvalidArgumentException("User not defined");
                }
        }
        
        // METHODS 
        
        /**
         * Add one exercise at a time when this function is called.
         */
        public static function getCount(){
			if (self::$db == null){
				self::$db = new DBHelper();
			}
			
			$query = "SELECT COUNT(*) FROM programs";
			
			$result = self::$db->query($query);
			
			return $result;
		}
        public function addComment($user_id, $comment){
	        if (self::$db == null){
				self::$db = new DBHelper();
            }
            
            $db = self::$db;
            $currentTime = self::$currentTime;
            
            $fitnessprogram_id = $this->programId;
            
            $query = "INSERT INTO comments (user_id, program_id, comment_text, created_at, updated_at) ";
            $query .= "VALUES ('$user_id', '$fitnessprogram_id', '$comment', $currentTime, $currentTime)";
            
            //Update the database
            $db -> query($query);
        }
        
        public function mergeExercise($exerciseId){
	        if (self::$db == null){
				self::$db = new DBHelper();
            }
            
            $db = self::$db;
            
            $query = "SELECT * FROM programdetails WHERE id='$exerciseId'";
            /* echo $query; */
            $result = $db-> query($query);
            
         /*    var_dump($result); */
            $currentExercise = array();
            $currentExercise['name'] = $result[0]['name'];
            $currentExercise['repetition'] = $result[0]['repetition'];
            $currentExercise['day'] = $result[0]['day'];
			
			/* var_dump($currentExercise); */
	        
	        $this->addExercise($currentExercise);
        }
        public function getNotification(){
        	if (self::$db == null){
				self::$db = new DBHelper();
            }
            
            $db = self::$db;
	        $fitnessprogram_id = $this->programId;
	        
	        $query = "SELECT u.name, c.program_id FROM users u, comments c, programs p WHERE c.program_id = '$fitnessprogram_id' AND u.id = c.user_id AND c.program_id = p.id ORDER BY c.created_at DESC LIMIT 5";
	        
	        $result = $db ->query($query);
            
            return $result;
        }
        
        public function getAllComments(){
	        if (self::$db == null){
				self::$db = new DBHelper();
            }
            
            $db = self::$db;
            
            $fitnessprogram_id = $this->programId;
             
            $query = "SELECT * FROM comments c, users u WHERE c.program_id = '$fitnessprogram_id' AND c.user_id = u.id";
            
            $result = $db ->query($query);
            
            return $result;
        }
        public static function getAdminCommentById($comment_id){
	        if (self::$db == null){
				self::$db = new DBHelper();
            }
            
            $db = self::$db;
            
            $query = "SELECT * FROM comments WHERE id ='$comment_id'";
            
            $result = $db ->query($query);
            
            return $result;
        }
        
        public static function getAdminComments(){
	        if (self::$db == null){
				self::$db = new DBHelper();
            }
            
            $db = self::$db;
            
             
            $query = "SELECT c.id as cid, u.id, u.name, c.comment_text, c.id as cid FROM comments c, users u WHERE c.user_id = u.id";
            
            $result = $db ->query($query);
            
            return $result;
        }
        
        public function addExercise(array $exercise){
                /** TODO: takes an array named exercise and addes it to database. */
                if (self::$db == null){
                        self::$db = new DBHelper();
                }
                $db = self::$db;
                // Create a new valid exercise
                $newExercise = array();
                foreach($exercise as $part => $value){
                        $newExercise[$part] = $exercise[$part];
                }
                
                // Set the variables to write in the DB
                $name = $newExercise["name"];
                $repetition = $newExercise["repetition"];
                $day = $newExercise["day"];
                
                array_push($this->exercises, $newExercise);
                
                $userId = $this->user->getUserId();
                $programId = $this->getProgramId();
                
                $dbTable = self::$dbTableProgramDetails;
                
                $currentTime = self::$currentTime;
                
                // Generate query to store the exercise in the DB
                $query = "INSERT INTO $dbTable (name, program_id, repetition, day, user_id, created_at, updated_at) ";
                $query .= "VALUES (";
                $query .= "'$name', 
                                        '$programId', 
                                        '$repetition', 
                                        '$day', 
                                        '$userId',
                                        $currentTime,
                                        $currentTime";
                $query .= ")";
                
                //Update the database
                $db -> query($query);
                
        }
        
        public function editFitnessProgram($fitnessTitle, $fitnessDetails){
	        if (self::$db == null){
		        self::$db = new DBHelper();
	        }
	        
	        $fitnessId = $this->getProgramId();
	        $query = "UPDATE programs SET title='$fitnessTitle', details='$fitnessDetails' WHERE id='$fitnessId'";
	        echo $query;
	        self::$db ->query($query);
        }
        
        public function getExerciseById($exerciseId){
	        if (self::$db == null){
            	self::$db = new DBHelper();
            }
            $db = self::$db;
            $dbTable = self::$dbTableProgramDetails;
            
            $query = "SELECT * FROM programdetails WHERE id='$exerciseId'";
            
            $result = $db -> query($query);
            
            return ($result);
        }
        public function deleteExercise($exerciseId){
	        if (self::$db == null){
            	self::$db = new DBHelper();
            }
            $db = self::$db;
            $dbTable = self::$dbTableProgramDetails;
            $query = "DELETE FROM $dbTable WHERE id='$exerciseId'";
            
            $db ->query($query);
        }
        
        /**
         * Display all the exercises corresponding to a user and returns a json
         */
        private function displayAllExercises() {
                if (self::$db == null){
                        self::$db = new DBHelper();
                        self::$db->connect();
                }

                $query = "SELECT * FROM $this->dbTablePrograms p, $this->dbTableProgramDetails pg WHERE p.user_id = pg.user_id";
                $query .= " AND p.id = pg.program_id AND ";
                $query .= "user_id = '" . $user->getUserId() . "'";

                //display return the array of all exercises             

                $result = self::$db -> query($query);

                $resultArray = $result;

                return json_encode($resultArray);
        }

        /**
         * Display a specific day from a user's fitness program with an user's id input
         * and returns an array of that specific day
         */
        public function displaySpecificDay($day) {
                if (self::$db == null){
                        self::$db = new DBHelper();
                        self::$db->connect();
                }
                $query = "SELECT * FROM programs p, programdetails pg WHERE p.user_id = pg.user_id";
                $query .= " AND p.id = pg.program_id AND ";
                $query .= "p.user_id = '" . $this->user->getUserId() . "' AND pg.day = '$day'";

                $result = self::$db -> query($query);
                $properties =  $result;

                return json_encode($properties);

        }

        /**
         * Write the program descriptions to the database
         */
        public function save(){
                $query = "UPDATE $this->dbTablePrograms ";
                $query .= "SET ";
                foreach($this as $property=>$value){
                        $query .= "$property='$value',";
                }
                $query = rtrim($query, ',');
                $query .= " WHERE user_id='".$this->user->getUserId() ."';";
                self::$db->query($query);
        }
        
        /**
         * Remove a fitness program from the database with its exercises
         */
        public function remove(){
                $query = "DELETE FROM '$this->dbTablePrograms' ";
                $query .= "WHERE user_id='$this->user->getUserId()';";
                self::$db->query($query); //delete title and description from programs table

                $query = "DELETE FROM '$this->dbTableProgramDetails' ";
                $query .= "WHERE user_id='$this->user->getUserId()';";
                self::$db->query($query); //delete all exercises in a specific fitness program
        }
        
        public function toArray(){
                $properties = array();
                foreach($this as $prop=>$value){
                        $properties[$prop] = $value;
                }
                return $properties;
        }

        public function toJson() {
                // Create a json string containing user's info
                return json_encode($this->toArray());
        }
        
        /**
         * Magic methods
         */


        /**
         * Getters
         */

         public static function getAllPrograms($page = 1){
			if (self::$db == null){
				self::$db = new DBHelper();
			}
			
			$dbTable = self::$dbTablePrograms;
			if ($page == 1) {
				$query = "SELECT * FROM $dbTable LIMIT 0, 10";
			} else {
				$count = $page * 10;
				$lCount = $count - 10;
				
				$query = "SELECT * FROM $dbTable LIMIT $lCount, $count";
			}
			
			$result = self::$db -> query($query);
			
			return $result;
         }
        public function displayId() {
                return $this->userId;
        }

        public function displayTitle() {
                return $this->title;
        }

        public function displayDetails() {
                return $this->details;
        }
        
        public function getProgramId(){
                if (!isset($this->programId)){
                        $userId = $this->user->getUserId();
                        $table = self::$dbTablePrograms;
                        $query = "SELECT id FROM $table WHERE title = '$this->title' AND user_id = '$userId'";
                        $result = self::$db->query($query);
                        $result = $result[0];
                        return $result["id"];
                } else {
                        return $this->programId;
                }
        }
        
		private function retrieveExercises($user){
				$program = $this;
								
				$programId = $program->getProgramId();
                $programDetails = self::$dbTableProgramDetails;
				
				$exQuery = "SELECT * FROM $programDetails WHERE program_id = '$programId'";
				$exercises = self::$db->query($exQuery);
				$toSetExercises = array();
				if (count($exercises) != 0){
					foreach ($exercises as $exercise){
						$day = $exercise["day"];
						if (!array_key_exists($day, $toSetExercises)) $toSetExercises[$day] = array();
						array_push($toSetExercises[$day], $exercise);
					}
					
					$program->setExercises($toSetExercises);
				}
		}
		
        public static function getFitnessProgramByUser(User $user){
                $fitnessProg = null;
                
                if (self::$db == null){
                        self::$db = new DBHelper();
                }
                $userId = $user->getUserId();

                $query = "SELECT * FROM programs p WHERE user_id = '$userId';";
                
                $resultArray = self::$db -> query($query);
                
                if (count($resultArray) != 0){
                        // Create a new FitnessProgram object without writing it to the db
                        $fitnessProg = new self($user, $resultArray[0]['title'], $resultArray[0]['details'], false);
                        
                        // Set the exercises
	                $fitnessProg->retrieveExercises($user);
	                
	                return $fitnessProg;
                }
                
                
        }
        
        public static function getFitnessProgramById($id){
			if (self::$db == null){
				self::$db = new DBHelper();
			}
			$programs = self::$dbTablePrograms;
			$programDetails = self::$dbTableProgramDetails;
			$query = "SELECT * FROM $programs WHERE id = '$id'";
			$result = self::$db->query($query);
			$params = $result[0];
			
			$program = new self(User::getUserByUserId($params["user_id"]), $params["title"], $params["details"], false);
				
			$program->retrieveExercises($user);
	
			return $program;
			
		}
		
		public function getUserId(){
			return $this->user->getUserId();
		}
		
		public function getTitle(){
			return $this->title;
		}
		
		public function getDetails(){
			return $this->details;
		}
		
		public function getExercises(){
			return $this->exercises;
		}
        
        /**
         * Setters
         */
         
        // TODO Write the new values to the db
         
        public function setExercises(array $exercises = null){
			$this->exercises = $exercises;
		}

        public function setUserObject(User $user){
                $this->user = $user;
        }

        public function setTitle($titleOfProgram){
                $this->title = $titleOfProgram;
        }

        public function setDetails($detailsOfProgram){
                $this->details = $detailsOfProgram;
        }
         
}


// TEST
