<?php

namespace App\Models;

use App\Conn;
use PDO;

class VolunteerModel
{
    public function getOpenActivities(): array
    {
        $db = Conn::getPDO();

        $sql = "
            SELECT
                e.id AS event_id,
                e.naam AS event_name,
                a.naam AS activity_name,
                et.datum AS event_date,
                aet.begin_tijd AS start_time,
                aet.eind_tijd AS end_time,
                COALESCE(
                    NULLIF(a.locatie, ''),
                    CONCAT(et.straatnaam, ' ', et.huisnummer,
                           ', ', et.plaatsnaam)
                ) AS location,
                aet.aantal_personen AS volunteer_capacity,
                COUNT(DISTINCT p.gebruiker_id) AS registered_volunteers

            FROM activiteit_event_tijd aet

            JOIN activiteit a
                ON a.id = aet.activiteit_id

            JOIN event_tijd et
                ON et.id = aet.event_tijd_id

            JOIN event e
                ON e.id = et.event_id

            LEFT JOIN planning p
                ON p.activiteit_event_tijd_id = aet.id

            WHERE et.datum >= CURDATE()
              AND e.removed = 0

            GROUP BY
                aet.id,
                e.id,
                e.naam,
                a.naam,
                et.datum,
                aet.begin_tijd,
                aet.eind_tijd,
                a.locatie,
                et.straatnaam,
                et.huisnummer,
                et.plaatsnaam,
                aet.aantal_personen

            HAVING registered_volunteers < volunteer_capacity

            ORDER BY et.datum ASC, aet.begin_tijd ASC
        ";

        return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
