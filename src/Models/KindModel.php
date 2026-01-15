<?php
namespace App\Models;

use App\Conn;
use PDO;

class KindModel extends DBModel{
    public function voegKindToe(int $ouderId, array $data) {
        $sql = "INSERT INTO gebruiker (ouder_id, voornaam, achternaam, postcode, plaatsnaam, huisnummer)
                VALUES (:ouder_id, :voornaam, :achternaam, :postcode, :plaatsnaam, :huisnummer)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':ouder_id' => $ouderId,
            ':voornaam' => $data['voornaam'],
            ':achternaam' => $data['achternaam'],
            ':postcode' => $data['postcode'],
            ':plaatsnaam' => $data['plaatsnaam'],
            ':huisnummer' => $data['huisnummer']
        ]);
    }


    public static function getKinderenByOuder(int $ouderId) {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();

        $sql = "SELECT * FROM gebruiker WHERE ouder_id = :ouderId";
        $stmt = $db->prepare($sql);
        $stmt->execute([':ouderId' => $ouderId]);

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getOuder(int $id) {
        $sql = "SELECT * FROM gebruiker WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(\PDO::FETCH_OBJ);
    }
}

