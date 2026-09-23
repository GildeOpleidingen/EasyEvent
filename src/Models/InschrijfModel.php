<?php
namespace App\Models;

use App\Models\DBModel;

class InschrijfModel extends DBModel
{
    public function getEventTijden(int $eventId): array
    {
        $stmt = $this->db->prepare("
            SELECT id, datum, begin_tijd, eind_tijd
            FROM event_tijd
            WHERE event_id = :event_id
        ");
        $stmt->execute([':event_id' => $eventId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function inschrijven(int $gebruikerId, array $eventTijdIds): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO inschrijving (gebruiker_id, event_tijd_id)
            VALUES (:gebruiker_id, :event_tijd_id)
        ");
        foreach ($eventTijdIds as $tijdId) {
            $stmt->execute([
                ':gebruiker_id' => $gebruikerId,
                ':event_tijd_id' => $tijdId
            ]);
        }
    }

    public function uitschrijven(int $gebruikerId, int $eventId): void
    {
        $stmt = $this->db->prepare("
            DELETE i
            FROM inschrijving i
            INNER JOIN event_tijd et ON et.id = i.event_tijd_id
            WHERE i.gebruiker_id = :gebruiker_id
            AND et.event_id = :event_id
        ");
        $stmt->execute([
            ':gebruiker_id' => $gebruikerId,
            ':event_id' => $eventId
        ]);
    }

    public function isIngeschreven(int $gebruikerId, int $eventId): bool
    {
        $stmt = $this->db->prepare("
            SELECT 1
            FROM inschrijving i
            INNER JOIN event_tijd et ON et.id = i.event_tijd_id
            WHERE i.gebruiker_id = :gebruiker_id
            AND et.event_id = :event_id
            LIMIT 1
        ");
        $stmt->execute([
            ':gebruiker_id' => $gebruikerId,
            ':event_id' => $eventId
        ]);
        return (bool)$stmt->fetchColumn();
    }

    public function markeerInschrijvingen(array $events, int $gebruikerId): array
    {
        foreach ($events as $event) {
            $event->isIngeschreven = $this->isIngeschreven($gebruikerId, $event->getEventID());
        }
        return $events;
    }
}
