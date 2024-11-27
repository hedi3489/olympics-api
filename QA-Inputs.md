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
