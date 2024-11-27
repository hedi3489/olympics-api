# QA Inputs Documentation

This is the Markdown file to serve as a use guide for documenting our `olympics-api` web service's resources and their inputs for Quality Assurance testing purposes.

*`NOTE: "can be used independently" means that the parameters shown underneath can be used in any combination.`*

*`STARTING URL FOR LOCAL: localhost/olympics-api/{resource}`*

## Examples of correct URIs/Inputs for /athletes

### GET Operations

/athletes  
/athletes/{athlete_id}

#### Pagination

- int ```current_page``` (default 1)
- int ```page_size``` (default 15)

Either parameter can be used independently.

/athletes?current_page=3&page_size=9

#### Filtering

 (no default filtering)

- string ```gender```
- string ```ethnicity```
- int ```country_id```

Either parameter can be used independently.

*`NOTE: Some combinations may not yield any results.`*

/athletes?gender=Female&ethnicity=Mexican&country_id=85

#### Sorting

- string ```athlete_name``` (default)
- string ```sport```
- Date ```date_of_birth```
- int ```height```
- int ```weight```
- int ```gold_medals```
- int ```silver_medals```
- int ```bronze_medals```
- int ```total_medals```
- string ```order_by``` (default `asc`)

/athletes?sort_by=athlete_name&order_by=asc (default)  
/athletes?sort_by=sport&order_by=desc  
/athletes?sort_by=date_of_birth&order_by=asc  
/athletes?sort_by=height&order_by=desc  
/athletes?sort_by=weight&order_by=asc  
/athletes?sort_by=gold_medals&order_by=desc  
/athletes?sort_by=silver_medals&order_by=asc  
/athletes?sort_by=bronze_medals&order_by=desc  
/athletes?sort_by=total_medals&order_by=asc

## POST /athletes

```json
{
  "athlete_name": "MR BEAAAAST",
  "country_id": 1,
  "gender": "Male",
  "sport": "Homeless",
  "date_of_birth": "2010-12-31",
  "height": 10,
  "weight": 2,
  "ethnicity": "Beast",
  "is_paralympic": 1,
  "gold_medals": 100,
  "silver_medals": 0,
  "bronze_medals": 0,
  "total_medals": 100
}
```

## Examples of correct URIs/Inputs for /coaches

### GET Operations

/coaches  
/coaches/{coach_id}

#### Pagination

- int ```current_page``` (default 1)
- int ```page_size``` (default 15)

Either parameter can be used independently.

/coaches?current_page=3&page_size=9

#### Filtering

 (no default filtering)

- string ```gender```
- string ```sport```
- tinyint (0 or 1) ```been_in_olympics```

Either parameter can be used independently.

*`NOTE: Some combinations may not yield any results.`*

/coaches?been_in_olympics=1&gender=Male&sport=Athletics

#### Sorting

- string ```coach_name``` (default)
- Date ```date_of_birth```
- string ```order_by``` (default `asc`)

/coaches?sort_by=coach_name&order_by=asc (default)  
/coaches?sort_by=date_of_birth&order_by=desc  

### POST /coaches

```json
{
  "coach_name": "MS YEAAAAST",
  "gender": "Female",
  "date_of_birth": "1984-12-31",
  "been_in_olympics": 1,
  "sport": "Landlord"
}
```


## Examples of correct URIs/Inputs for /venues

### GET Operations

/venues  
/venues/{venue_id}

#### Pagination

- int ```current_page``` (default 1)
- int ```page_size``` (default 15)

Either parameter can be used independently.

/venues?current_page=3&page_size=9

#### Filtering

- string ```venue_name``` (default filtering)
- int ```min_capacity```
- int ```max_capacity```
- date ```min_date_constructed```
- date ```max_date_constructed```

Either parameter can be used independently.

*`NOTE: Some combinations may not yield any results.`*

/venues?sort_by=address&max_date_constructed=1900-01-01

#### Sorting

- string ```venue_name``` (default)
- string ```address```
- string ```type```
- int ```capacity```
- Date ```date_constructed```

- string ```order_by``` (default `asc`)
 
/venues?sort_by=capacity&order_by=desc
/venues?order_by=desc&type=multiuse&min_capacity=80000
/venues?sort_by=address&max_date_constructed=2010-01-01
/venues?sort_by=address&max_date_constructed=1900-01-01&page_size=3
/venues?order_by=desc&min_date_constructed=2000-01-01&min_capacity=50000

## POST /venues

```json
{
  "venue_name": "Thriller Bark",
  "address": "Bermuda",
  "capacity": "20000",
  "type": "Stinky",
  "date_constructed": "2024-11-12",
  "historical_significance": "home to countless zombies.",
  "parking_facilities": "no parking facilities."
}
```

## PUT /venues/13

```json
{
  "venue_name": "Undead Burg",
  "address": "Lordran",
  "capacity": "6363",
  "type": "Super Stinky",
  "date_constructed": "1800-10-20",
  "historical_significance": "home to countless undead.",
  "parking_facilities": "Check the sewers. Beware of rats."
}
```

## Examples of correct URIs/Inputs for /events

### GET Operations

/events
/events/{event_id}

#### Pagination

- int ```current_page``` (default 1)
- int ```page_size``` (default 15)

Either parameter can be used independently.

/venues?current_page=3&page_size=9

#### Filtering

- string ```event_name``` (default filtering)
- int ```is_paralympic```
- Date ```min_participants```
- Date ```max_participants```

Either parameter can be used independently.

*`NOTE: Some combinations may not yield any results.`*

/events?sort_by=address&max_date_constructed=1900-01-01

#### Sorting

'event_name', 'event_sport', 'start_date', 'end_date', 'number_of_participants', 'is_paralympic'

- string ```event_name``` (default)
- int ```event_sport```
- int ```number_of_participants```
- int ```is_paralympic```
- Date ```start_date```
- Date ```end_date```

- string ```order_by``` (default `asc`)

/events?order_by=asc&event_name=Event
/events?order_by=asc&page_size=5&is_paralympic=1
/events?order_by=asc&page_size=5&is_paralympic=0&sort-by=number_of_participants

## POST /events

```json
{
  "event_name": "2v2 Rocket League",
  "event_sport": 5,
  "start_date": "2024-07-25",
  "end_date": "2024-08-09",
  "number_of_participants": 4,
  "is_paralympic": 1,
  "venue_id": 5
}
```

## PUT /events/8

```json
{
  "event_name": "Brawlhalla",
  "event_sport": 4,
  "start_date": "2024-07-25",
  "end_date": "2024-08-09",
  "number_of_participants": 4,
  "is_paralympic": 1,
  "venue_id": 1
}
```
