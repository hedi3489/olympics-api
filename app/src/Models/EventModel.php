<?php

namespace App\Models;

use App\Core\PDOService;

class EventModel extends BaseModel
{
    private string $table_name = "events";

    public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo);
    }

    /**
     * Gets all events in the DB
     * @return array - The resulting array of events
     */
    public function getEvents(): array
    {
        $sql = "SELECT * FROM events LIMIT 500";
        $events = $this->fetchAll($sql);
        return (array) $events;
    }

    /**
     * Gets all events with an event_name
     * @return array - The resulting array of events
     */
    public function getEventsByName(array $req_params): array
    {
        $events = [];
        $query_args = [];
        $sql = "SELECT * FROM events WHERE 1";

        //* Add to the query
        //? the given name if it's set and not empty
        if (isset($req_params["venue_name"])) {
            $sql .= " AND venue_name LIKE CONCAT('%', :venue_name, '%')";
            $query_args["venue_name"] = $req_params['venue_name'];
        }
        // Instead of using fetchAll(), we use our new more specific method paginate()
        // $players = $this->fetchAll($sql, $query_args);
        $events = $this->paginate($sql, $query_args);
        return $events;
    }

    //TODO How to do array | bool in php
    /*public function getPlayerById(string $player_id): mixed
    {
        $sql = "SELECT * FROM {$this->table_name} WHERE player_id=:player_id";
        $player_info = $this->fetchSingle(
            $sql,
            ["player_id" => $player_id]
        );
        return $player_info;
    }*/

    /*public function getGoalsByPlayerId(string $player_id): mixed
    {
        // 1) Fetch the player info
        $player = $this->getPlayerById($player_id);
        // 2) Fetch the list of goals, tournaments and matches
        //* Here we use Heredoc to format
        $goals_query = <<<SQL
            SELECT * FROM goals g, tournaments t, matches m
            WHERE g.tournament_id=t.tournament_id
            AND g.match_id=m.match_id
            AND player_id=:player_id
        SQL;
        $goals = $this->paginate(
            $goals_query,
            ["player_id" => $player_id]
        );
        //* 3) Produce a well structure response
        $result = [
            "player" => $player,
            "goals" => $goals,
        ];
        return $result;
    }*/
}
