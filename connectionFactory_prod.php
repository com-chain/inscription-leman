<?php 
class ConnectionFactory { 
        
       
    public static function GetConnection() { 
      date_default_timezone_set("UTC");
          $mysqli = new mysqli("myMysqlHostnameOrIpWithOptionalPort","myDbUser","myDbPassword","myDbName");
          if ($mysqli->connect_errno) {
                  echo "Failed to connect to MySQL: " . $mysqli->connect_error;
          }
          
          if (!$mysqli->set_charset("utf8")) {
        printf("Erreur lors du chargement du jeu de caractères utf8 : %s\n", $mysqli->error);
     } 
          
          return $mysqli;  
    } 
}

function validMember($mysqli, $Code) {
        $stmt = $mysqli->prepare("
        SELECT 
            Reg_Code.PersonId,
            RecordTypeId,
            Reg_Legal.Name,
            Reg_Legal.Contact,
            Reg_Legal.ContactSurname,
            Reg_Individual.FirstName, 
            Reg_Individual.LastName, 
            Code 
        FROM Reg_Code 
        INNER JOIN Reg_Person ON Reg_Person.Id=Reg_Code.PersonId
        LEFT OUTER JOIN Reg_Legal ON Reg_Person.Id = Reg_Legal.Id
        LEFT OUTER JOIN Reg_Individual ON Reg_Person.Id = Reg_Individual.Id
        WHERE Code=?");
        
        $stmt->bind_param("s", $Code);
        $stmt->bind_result($id, $type,$company,$ct_name, $ct_surname,$surname,$lastname,$res_code);
        $stmt->execute();
        $result = array( "Valid"=>False);
        while ($stmt->fetch()){
            if ($type == 1) {
                $person = $ct_surname." ".$ct_name;
            } else {
                $person = $surname." ".$lastname;
            }
        
            $result = array("id"=>$id,"code"=>$res_code, "Valid"=>($res_code==$Code), "Name"=>$person, "Company"=>$company, "Type"=>$type);
        }
        return $result;
} 

?>
