<?php
    /*
     *  *********************
     *  *   DATABSE CLASS   *
     *  *********************
     *  The databsse class serves as a gateway to working wih databases
     *  1. It provides methods for basic database transactions (CRUD)
     *  2. The default database is the MySQL database
     *
    */
    
    class Database
    {
        private $handle;      #   This would hold the connection resource
        private $dbError = '';   #   This holds errors that may occur, for testing purposes
        
        /*  */
        public function __construct()
        {
            #
            $this->handle = mysqli_connect(
                                           DatabaseCredential::dbHost,
                                           DatabaseCredential::dbUser,
                                           DatabaseCredential::dbPass
                                           );
        }
        
        /*  @function cleanvariable(Str $var)
         *  Cleans a variable to guard against SQL Injections
         *
         *  It returns a cleaned data
        */
        public function cleanVariable($var)
        {
            return mysqli_real_escape_string($this->handle, $var);
        }
        
        /*  Close the database connection   */
        public function closeConnection()
        {
            mysqli_close($this->handle);
        }
        
        /*  */
        public function getConn()
        {
            return $this->handle;
        }
        
        /*  */
        public function getErrMessage()
        {
            return $this->dbError;
        }
        
        /*
         *  Select a database for use
         *  Takes the name of the database as an argument
         *
         *  It returns true on success and false otherwise
        */
        public function selectDb($db_name)
        {
            $retVal = false;
            $db_name = $this->cleanVariable($db_name);  #   Clean parameter for attacks
            if(mysqli_select_db($this->handle, $db_name)) $retVal = true;
            
            #
            return $retVal;
        }
        
        /*
         *  Inserts a new record into a database table
         *  It takes two parameters:
         *  1. The name of table into which data is to be inserted
         *  2. An associative array of the columns and values (columns are the keys)
         *
         *  It returns true on success and false otherwise
        */
        public function insertRecord($table = '', $data = [])
        {
            $retVal = false;    #   Default return value
            $fields= '';        #   Array to hold table field names
            $values = '';       #    Array to hold record field values
            
            /*  If data array and table name are not empty */
            if(!empty($data) && $table != '')
            {
                #   Clean table name and data values against attacks
                #   In the process, create a string of fields and values
                $table = $this->cleanVariable($table);
                foreach ($data as $key => $value)
                {
                    $fields .= $this->cleanVariable($key).",";
                    if(is_int($value)) $values .= $this->cleanVariable($value)."'";
                    else $values .= "'".$this->cleanVariable($value)."',";
                }
                
                #   Trim any trailing commas on the right of the string
                $fields = rtrim($fields, ',');
                $values = rtrim($values, ',');
                
                #   Build the query string
                $query = "INSERT INTO ".$table."(".$fields.") VALUES(".$values.")";
                if(mysqli_query($this->handle, $query)) $retVal = true;
                else $this->dbError = mysqli_error($this->handle);   
            }else $this->dbError = 'Parameters cannot be empty';
            
            #
            return $retVal;
        }
        
        /*  This function updates a record
         *  it takes 5 parameters:
         *  1. The table name
         *  2. The field to be updated
         *  3. The new value
         *  4. The constraining field
         *  5. The constraining value
         *
         *  It returns true on success and false otherwise
        */
        public function updateRecord($table = '', $field = '', $fieldValue = '', $constraintField = '', $constraintValue = '')
        {
            $retVal = false;
            
            #   If any parameter is empty, do not proceed
            if(empty($table) || empty($field) || empty($fieldValue) || empty($constraintField) || empty($constraintValue))
                $this->dbError = "Paramenters cannot be empty";
            else
            {
                #   Format values as appropriate (add quotes to none integer values)
                is_int($constraintValue) ? : $constraintValue = "'".$constraintValue."'";
                is_int($fieldValue) ? : $fieldValue = "'".$fieldValue."'";
                
                #   Clean input data and Build query string 
                $query = "UPDATE ".$this->cleanVariable($table)." SET ".$this->cleanVariable($field)." = ".$$this->cleanVariable($fieldValue)."
                WHERE ".$this->cleanVariable($constraintField)." = ".$this->cleanVariable($constraintValue);
                
                #   run query
                if(mysqli_query($this->handle, $query)) $retVal = true;
                else $this->dbError = mysqli_error($this->handle);
            }
            
            #
            return $retVal;
        }
        
        /*
         *  This updates a specified field for all records.
         *  It takes 3 parameters:
         *  1. The table name
         *  2. The field to update
         *  3. The new field value
         *
         *  It returns true on success and false otherwise
         *
        */
        public function updateAllRecords($table ='', $field = '', $fieldValue = '')
        {
            $retVal = false;
            
            #   If any parameter is empty, we can not proceed
            if(empty($table) || empty($field) || empty($fieldValue)) $this->dbError = "Parameters cannot be empty";
            else
            {
                #   If value is not integer, wrap it in quotes
                is_int($fieldValue) ? : $fieldValue = "'".$fieldValue."'";
                
                #   Clean data against attacks
                $table = $this->cleanVariable($table);
                $field = $this->cleanVariable($field);
                $fieldValue = $this->cleanVariable($fieldValue);
                
                #   Build the query string
                $query = "UPDATE ".$table." SET ".$field." = ".$fieldValue;
                
                #   Run the query
                if(mysqli_query($this->handle, $query)) $retVal = true;
                else $this->dbError = mysqli_error($this->handle);
                
            }
            
            #
            return $retVal;
        }
        
        /*  @method fetchData(Str $table, mixed $fields, mixed $constraints, Str constraintLevel)
         *  Fetches data from a table in the database.
         *  It takes 4 parameters:
         *  1. The table name
         *  2. The fields to be selected
         *  3. The constraints to be applied
         *  4. The constraint level ('tight' for AND, 'loose' for OR)
         *  
         *  It returns an empty array if no record is returned
         *  It returns an array of requested data
        */
        public function fetchData($table = '', $fields = [], $constraints = [], $constraintLevel = 'tight')
        {
            $retVal = [];
            
            #   If the table name, fields or constraints are empty, we may not proceed
            if($table == '' || empty($fields) || empty($constraints))
                $this->dbError = "Parameters cannot be empty";
            else
            {
                $fieldString = '';
                $constraintString = '';
                
                $numOfConstraints = sizeof($constraints);   #   Get number of constraints passed
                $i = 0;                                     #   Variable to Keep track of constraint count
                
                #   Decide the type of logical operator to use on constraints
                $connector = "AND";                         #   AND IS USED BY DEFAULT
                if($constraintLevel == 'loose') $connector = "OR";
                
                /*  Clean parameters    */
                $table = $this->cleanVariable($table);
                $constraintLevel = $this->cleanVariable($constraintLevel);
                
                #   create fields strings
                foreach ($fields as $field)
                {
                    $fieldString .= $this->cleanVariable($field).", ";
                }
                
                #   Create constraint string
                foreach ($constraints as $constraint => $value)
                {
                    #   If we are on the last constraint, do not add a connector to it
                    if($i == ($numOfConstraints - 1)) $constraintString .= $constraint ." = ". $value;
                    else $constraintString .= $constraint ." = ".$value. " ".$connector." ";
                }
                
                $fieldString = rtrim($fieldString, ','); #  Removing any trailing commas(,)
                
                #   Prepare SQl
                $query = "SELECT ".$fieldString." FROM ".$table." WHERE ".$constraintString;
                
                #   Run SQL
                $query_run = mysqli_query($this->handle, $query);
                
                #   If one or more records are affected
                if(mysqli_affected_rows($this->handle) >= 1)
                {
                    $n = mysqli_num_rows($query_run);   #   Number of rows returned
                    for($i = 0; $i < $n; $i++)          #   Loop through returned array
                    {
                        $result = mysqli_fetch_assoc($query_run);
                        foreach($fields as $field)      #   Get data for each requested field
                        {
                            $retVal[$i][$field] = $result[$field];
                        }
                    }
                }else $this->dbError = "No record Affected";
            }
            
            #
            return $retVal;
        }
    }