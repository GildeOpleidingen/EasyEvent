<?php

namespace App\Models;

use App\Conn;
use Dotenv\Parser\Value;
use PDO;

class UserModel
{
    private $id;
    private $voornaam;
    private $achternaam;
    private $email;
    private $telefoon;
    private $postcode;
    private $roles;
    private $plaatsnaam;
    private $huisnummer;
    private $wachtwoord;
    private $gebruikersNaam;
    private $profielfoto;

    private array $organisations;
    private array $accessToEntities;

    private $is_geverifieerd;
    private $ouder_ID;
    private $kledingmaat;

    public function __construct()
    {

    }

    public function setUserData(array $data)
    {
        $this->id = $data['ID'] ?? null;
        $this->voornaam = $data['Voornaam'] ?? null;
        $this->achternaam = $data['Achternaam'] ?? null;
        $this->email = $data['E-mail'] ?? null;
        $this->telefoon = $data['Telefoon'] ?? null;
        $this->postcode = $data['Postcode'] ?? null;
        $this->roles = isset($data['ID']) ? RolModel::getRolesByUserId($data['ID']) : [];
        $this->plaatsnaam = $data['Plaatsnaam'] ?? null;
        $this->huisnummer = $data['Huisnummer'] ?? null;
    }

    public function getId() { return $this->id; }
    public function getVoornaam() { return $this->voornaam; }
    public function getAchternaam() { return $this->achternaam; }
    public function getEmail() { return $this->email; }
    public function getTelefoon() { return $this->telefoon; }
    public function getPostcode() { return $this->postcode; }
    public function getPlaatsnaam() { return $this->plaatsnaam; }
    public function getHuisnummer() { return $this->huisnummer; }
    public function getKledingmaat() { return $this->kledingmaat; }
    public function getIsGeverifieerd() { return $this->is_geverifieerd; }
    public function getRoles() { return $this->roles; }
    private function getWachtwoord() { return $this->wachtwoord;}
    public function getGebruikersNaam() {return $this->gebruikersNaam;}

    public function setID($value) {$this->id = $value;}
    public function setVoornaam($value) {$this->voornaam = $value;}
    public function setAchternaam($value) {$this->achternaam = $value;}
    public function setEmail($value) {$this->email = $value;}
    public function setTelefoon($value) {$this->telefoon = $value;}
    public function setPostcode($value) {$this->postcode = $value;}

    public function setHuisnummer($value) {$this->huisnummer = $value;}
    public function setPlaatsnaam($value) {$this->plaatsnaam = $value;}
    public function setGebruikersnaam($value) {$this->gebruikersNaam = $value;}
    public function setProfielfoto($value) {$this->profielfoto = $value;}
    public function setIsGeverifieerd($value) {$this->is_geverifieerd = $value;}
    public function setKledingmaat($value) {$this->kledingmaat = $value;}
    public function setOuderId($value) {$this->ouder_ID = $value;}
    public function setRoles($value) {$this->roles = $value;}
    public function setWachtwoord($value){$this->wachtwoord = password_hash($value, PASSWORD_DEFAULT);}

    public static function getById($id)
    {
        $db = Conn::getPDO();
        $stmt = $db->prepare("SELECT * FROM gebruiker WHERE Id = ?");
        $stmt->execute([$id]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        $um = new self();
        return $userData ? $um->setUserData($userData) : null;
    }

    public function updateTelefoon($newPhone)
    {
        $db = Conn::getPDO();
        $stmt = $db->prepare("UPDATE gebruiker SET Telefoon = ? WHERE Id = ?");
        $stmt->execute([$newPhone, $this->id]);
        $this->telefoon = $newPhone;
    }

    public function updateAdresGegevens($newPostCode, $newCity, $newHouseNumber)
    {
        $db = Conn::getPDO();

        $query = "UPDATE gebruiker SET ";

        $updateVelden = [];

        if (!empty($newPostCode)) {
            $updateVelden[] = "Postcode = :postcode";
        }

        if (!empty($newCity)) {
            $updateVelden[] = "Plaatsnaam = :plaatsnaam";
        }

        if (!empty($newHouseNumber)) {
            $updateVelden[] = "Huisnummer = :huisnummer";
        }

        $query .= implode(', ', $updateVelden);
        $query .= " WHERE Id = :id"; 
        $stmt = $db->prepare($query);

        if (!empty($newPostCode)) {
            $stmt->bindParam(':postcode', $newPostCode);
        }
        if (!empty($newCity)) {
            $stmt->bindParam(':plaatsnaam', $newCity);
        }
        if (!empty($newHouseNumber)) {
            $stmt->bindParam(':huisnummer', $newHouseNumber);
        }

        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        $this->postcode = $newPostCode;
        $this->plaatsnaam = $newCity;
        $this->huisnummer = $newHouseNumber;
    }

    public function updateWachtwoord($currentPassword, $newPassword, $confirmPassword)
    {
        if (!$currentPassword || !$newPassword || !$confirmPassword) {
            return "Alle velden zijn verplicht.";
        }

        $db = Conn::getPDO();
        $stmt = $db->prepare("SELECT Wachtwoord FROM gebruiker WHERE ID = :id");
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return "Gebruiker niet gevonden.";
        }

        if (!password_verify($currentPassword, $result['Wachtwoord'])) {
            return "Onjuist wachtwoord.";
        }

        if (password_verify($newPassword, $result['Wachtwoord'])) {
            return "Je nieuwe wachtwoord mag niet hetzelfde zijn als je huidige wachtwoord.";
        }

        if ($newPassword !== $confirmPassword) {
            return "Nieuwe wachtwoorden komen niet overeen.";
        }

        if (strlen($newPassword) < 8) {
            return "Wachtwoord moet minimaal 8 tekens lang zijn.";
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $stmt = $db->prepare("UPDATE gebruiker SET Wachtwoord = :wachtwoord WHERE ID = :id");
        $stmt->bindParam(':wachtwoord', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "Wachtwoord succesvol bijgewerkt.";
        } else {
            return "Fout bij het bijwerken van het wachtwoord.";
        }
    }

    public function setOrganisations(array $organisations): void
    {
        $this->organisations = $organisations;
    }

    public static function getAllUsers() {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();

        $sql = "SELECT g.ID, g.Voornaam, g.Achternaam, g.`E-mail`, g.Telefoon, IF(g.Is_Geverifieerd = 1, 'Ja', 'Nee') AS Is_Geverifieerd, k.KledingMaat, g.Ouder_ID, GROUP_CONCAT(r.Rol SEPARATOR ', ') as Rollen
                FROM kpl_gebruiker_rol gr 
                JOIN gebruiker g on g.ID = gr.gebruiker_ID
                JOIN rol r on r.ID = gr.rol_ID
                LEFT JOIN Kleding k on k.ID = g.KledingMaat
                GROUP by g.id
                ORDER BY g.Achternaam, g.Voornaam";
        $stmt = $db->prepare($sql);

        if (!$stmt->execute()) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }

        $allusers = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user = new UserModel();
            $user->setID($row['ID']);
            $user->setVoornaam($row['Voornaam']);
            $user->setAchternaam($row['Achternaam']);
            $user->setEmail($row['E-mail']);
            $user->setTelefoon($row['Telefoon']);
            $user->setIsGeverifieerd($row['Is_Geverifieerd']);
            $user->setKledingmaat($row['KledingMaat']);
            $user->setOuderId($row['Ouder_ID']);
            $user->setRoles($row['Rollen']);

            $allusers[] = $user;
        }

        return $allusers;
    }

    public static function save(self $um){
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();
        
        $vn = $um->getVoornaam();
        $an = $um->getAchternaam();
        $em = $um->getEmail();
        $tel = $um->getTelefoon();
        $pc = $um->getPostcode();
        $pln = $um->getPlaatsnaam();
        $ww = $um->getWachtwoord();
        $gn = $um->getGebruikersNaam();
        $hnr= $um->getHuisnummer();
        // $isgev= 1;
        $km = $um->getKledingmaat();

        //rol
        $rollen = $um->getRoles();

        $sql = "INSERT INTO `gebruiker`(`Voornaam`, `Achternaam`, `E-mail`, `Telefoon`, `Postcode`, `Plaatsnaam`, 
            `Wachtwoord`, `Gebruikersnaam`, `Huisnummer`, `KledingMaat`)
            VALUES (:vn, :an, :em, :tel, :pc, :pln, :ww, :gn, :hnr, :km)";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":vn",$vn);
        $stmt->bindParam(":an", $an);
        $stmt->bindParam(":em", $em);
        $stmt->bindParam(":tel", $tel);
        $stmt->bindParam(":pc", $pc);
        $stmt->bindParam(":pln", $pln);
        $stmt->bindParam(":ww", $ww);
        $stmt->bindParam(":gn", $gn);
        $stmt->bindParam(":hnr", $hnr);
        //  $stmt->bindParam(":isgev", $isgev);
        $stmt->bindParam(":km", $km);
        
        if($stmt->execute())
        {
            $last_id = $db->lastInsertId();
        
            foreach($rollen as $rol){
                //Koppel de gebruiker rol aan deze nieuwe gebruiker.
                $stmt = $db->prepare("INSERT INTO `kpl_gebruiker_rol`(`gebruiker_ID`, `rol_ID`) VALUES (:gebruikerId, :rolId)");
                $stmt->bindParam('gebruikerId', $last_id);
                $stmt->bindParam('rolId', $rol);
                $stmt->execute();
            }
        }
        else{
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }
    }

    public function delete($id){
        $db = Conn::getPDO();
        $stmt = $db->prepare("DELETE FROM `kpl_gebruiker_rol` WHERE gebruiker_ID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()){
            $stmt = $db->prepare("DELETE FROM gebruiker WHERE ID = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
            if ($stmt->execute()) {
                return "Gebruiker succesvol verwijdert.";
            } else {
                return "Fout bij het verwijderen van gebruiker met id: " . $id;
            }            
        } else {
            return "Fout bij het verwijderen van de rollen voor gebruiker met id: " . $id;
        }
    }

    public static function checkAccess($method, $requiredProperty, $userModel) {

        if ($requiredProperty == "eventID") {
            $userID = $userModel->getId();
            $overeenkomst;
            
            $db = Conn::getPDO();
            $stmt = $db->prepare("SELECT * FROM `event` WHERE Organisator = :id");
            $stmt->bindParam(':id', $userID);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as $event) {
                if ($event["Organisator"] == $userID && $event["ID"] == $_GET["eventID"]) {
                    $overeenkomst = true;
                    break;
                } else {
                    $overeenkomst = false;
                }
            }
            if ($overeenkomst) {
                return $_GET["eventID"];
            } else {
                return false;
            }
        }
    }
}
