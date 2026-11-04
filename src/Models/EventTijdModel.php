<?php

namespace App\Models;

use App\Conn;
use DateTime;
use PDO;

class EventTijdModel extends DBModel{
    public int $eventId;
    public DateTime $datum;
    public DateTime $beginTijd;
    public DateTime $eindTijd;
    public string $land;
    public string $plaatsnaam;
    public string $straatnaam;
    public string $huisnummer;
    public string $postcode;

    public function __construct(int $eventId, DateTime $datum, DateTime $beginTijd, DateTime $eindTijd, string $land, string $plaatsnaam, string $straatnaam, string $huisnummer, string $postcode)
    {
        $this->eventId = $eventId;
        $this->datum = $datum;
        $this->beginTijd = $beginTijd;
        $this->eindTijd = $eindTijd;
        $this->land = $land;
        $this->plaatsnaam = $plaatsnaam;
        $this->straatnaam = $straatnaam;
        $this->huisnummer = $huisnummer;
        $this->postcode = $postcode;
    }

    public static function getAllEventTijdenById(int $eventId) {
        $mysql = Conn::getInstance();
        $db = $mysql->getPDO();

        $sql = "SELECT * FROM event_tijd WHERE event_id = :eventid;";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(":eventid", $eventId);

        if (!$stmt->execute()) {
            die('Query failed: ' . implode(' ', $stmt->errorInfo()));
        }

        $eventTijden = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $datum = DateTime::createFromFormat('Y-m-d', $row['datum']);
            $beginTijd = DateTime::createFromFormat('H:i:s', $row['begin_tijd']);
            $eindTijd = DateTime::createFromFormat('H:i:s', $row['eind_tijd']);

            $eventTijd = new EventTijdModel($row['event_id'], $datum, $beginTijd, $eindTijd, $row['land'], $row['plaatsnaam'], $row['straatnaam'], $row['huisnummer'], $row['postcode']);
            
            $eventTijden[] = $eventTijd;
        }
        
        return $eventTijden;
    }
}