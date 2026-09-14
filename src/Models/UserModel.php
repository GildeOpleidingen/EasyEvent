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
        $this->id = $data['id'] ?? null;
        $this->voornaam = $data['voornaam'] ?? null;
        $this->achternaam = $data['achternaam'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->telefoon = $data['telefoon'] ?? null;
        $this->postcode = $data['postcode'] ?? null;
        $this->roles = isset($data['id']) ? RolModel::getRolesByUserId($data['id']) : [];
        $this->plaatsnaam = $data['plaatsnaam'] ?? null;
        $this->huisnummer = $data['huisnummer'] ?? null;
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

    public function setID($value) {$this->id = $value;}
    public function setVoornaam($value) {$this->voornaam = $value;}
    public function setAchternaam($value) {$this->achternaam = $value;}
    public function setEmail($value) {$this->email = $value;}
    public function setTelefoon($value) {$this->telefoon = $value;}
    public function setPostcode($value) {$this->postcode = $value;}

    public function setHuisnummer($value) {$this->huisnummer = $value;}
    public function setPlaatsnaam($value) {$this->plaatsnaam = $value;}
    public function setProfielfoto($value) {$this->profielfoto = $value;}
    public function setIsGeverifieerd($value) {$this->is_geverifieerd = $value;}
    public function setKledingmaat($value) {$this->kledingmaat = $value;}
    public function setOuderId($value) {$this->ouder_ID = $value;}
    public function setRoles($value) {$this->roles = $value;}
    public function setWachtwoord($value){$this->wachtwoord = password_hash($value, PASSWORD_DEFAULT);}

    public static function getById($id)
    {
        $db = Conn::getPDO();
        $stmt = $db->prepare("SELECT * FROM gebruiker WHERE id = ?");
        $stmt->execute([$id]);

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$userData) {
            return null;
        }

        $um = new self();
        $um->setUserData($userData);
        return $um;
    }

    public function updateTelefoon($newPhone)
    {
        $db = Conn::getPDO();
        $stmt = $db->prepare("UPDATE gebruiker SET telefoon = ? WHERE Id = ?");
        $stmt->execute([$newPhone, $this->id]);
        $this->telefoon = $newPhone;
    }

    public function updateAdresGegevens($newPostCode, $newCity, $newHouseNumber)
    {
        $db = Conn::getPDO();

        $query = "UPDATE gebruiker SET ";

        $updateVelden = [];

        if (!empty($newPostCode)) {
            $updateVelden[] = "postcode = :postcode";
        }

        if (!empty($newCity)) {
            $updateVelden[] = "plaatsnaam = :plaatsnaam";
        }

        if (!empty($newHouseNumber)) {
            $updateVelden[] = "huisnummer = :huisnummer";
        }

        $query .= implode(', ', $updateVelden);
        $query .= " WHERE id = :id"; 
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
        $stmt = $db->prepare("SELECT wachtwoord FROM gebruiker WHERE id = :id");
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return "Gebruiker niet gevonden.";
        }

        if (!password_verify($currentPassword, $result['wachtwoord'])) {
            return "Onjuist wachtwoord.";
        }

        if (password_verify($newPassword, $result['wachtwoord'])) {
            return "Je nieuwe wachtwoord mag niet hetzelfde zijn als je huidige wachtwoord.";
        }

        if ($newPassword !== $confirmPassword) {
            return "Nieuwe wachtwoorden komen niet overeen.";
        }

        if (strlen($newPassword) < 8) {
            return "Wachtwoord moet minimaal 8 tekens lang zijn.";
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $stmt = $db->prepare("UPDATE gebruiker SET wachtwoord = :wachtwoord WHERE id = :id");
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

        $sql = "SELECT g.id, g.voornaam, g.achternaam, g.email, g.telefoon, IF(g.geverifieerd = 1, 'Ja', 'Nee') AS Is_Geverifieerd, k.maat, g.ouder_id, GROUP_CONCAT(r.rol SEPARATOR ', ') as Rollen
                FROM gebruiker_rol gr 
                JOIN gebruiker g on g.id = gr.gebruiker_id
                JOIN rol r on r.id = gr.rol_id
                LEFT JOIN kleding_maat k on k.id = g.kleding_maat_id
                GROUP by g.id
                ORDER BY g.achternaam, g.voornaam";
        $stmt = $db->prepare($sql);

        if (!$stmt->execute()) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }

        $allusers = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user = new UserModel();
            $user->setID($row['id']);
            $user->setVoornaam($row['voornaam']);
            $user->setAchternaam($row['achternaam']);
            $user->setEmail($row['email']);
            $user->setTelefoon($row['telefoon']);
            $user->setIsGeverifieerd($row['Is_Geverifieerd']);
            $user->setKledingmaat($row['maat']);
            $user->setOuderId($row['ouder_id']);
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
        $hnr= $um->getHuisnummer();
        // $isgev= 1;
        $km = $um->getKledingmaat();

        //rol
        $rollen = $um->getRoles();

        $sql = "INSERT INTO `gebruiker`(`voornaam`, `achternaam`, `email`, `telefoon`, `postcode`, `plaatsnaam`, 
            `wachtwoord`, `huisnummer`, `kleding_maat_id`)
            VALUES (:vn, :an, :em, :tel, :pc, :pln, :ww, :hnr, :km)";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":vn",$vn);
        $stmt->bindParam(":an", $an);
        $stmt->bindParam(":em", $em);
        $stmt->bindParam(":tel", $tel);
        $stmt->bindParam(":pc", $pc);
        $stmt->bindParam(":pln", $pln);
        $stmt->bindParam(":ww", $ww);
        $stmt->bindParam(":hnr", $hnr);
        //  $stmt->bindParam(":isgev", $isgev);
        $stmt->bindParam(":km", $km);
        
        if($stmt->execute())
        {
            $last_id = $db->lastInsertId();
        
            foreach($rollen as $rol){
                //Koppel de gebruiker rol aan deze nieuwe gebruiker.
                $stmt = $db->prepare("INSERT INTO `gebruiker_rol`(`gebruiker_id`, `rol_id`) VALUES (:gebruikerId, :rolId)");
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
        $stmt = $db->prepare("DELETE FROM `gebruiker_rol` WHERE gebruiker_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()){
            $stmt = $db->prepare("DELETE FROM gebruiker WHERE id = :id");
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

     public function updatePassword(string $email, string $hashedPassword): bool {
        $db = Conn::getPDO();
        $stmt = $db->prepare("UPDATE gebruiker SET wachtwoord = :wachtwoord WHERE email = :email");
        $stmt->bindParam(':wachtwoord', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public static function checkAccess($method, $requiredProperty, $userModel) {

        if ($requiredProperty == "eventID") {
            $userID = $userModel->getId();
            $overeenkomst = false;
            
            $db = Conn::getPDO();
            $stmt = $db->prepare("SELECT * FROM `event` WHERE organisator_id = :id");
            $stmt->bindParam(':id', $userID);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as $event) {
                if ($event["organisator_id"] == $userID && $event["id"] == $_GET["eventID"]) {
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
