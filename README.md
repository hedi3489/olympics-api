# Olympics API
## Overview
The Olympics API provides access to various resources related to the 2024 Paris Olympics. It offers information about athletes, coaches, venues, events, countries, and results. Additionally, it provides functionality to compute the Body Mass Index (BMI) and Basal Metabolic Rate (BMR) based on user input.
--API written by `Hedi Belhassine (hedi3489)` and `Daniel Levitin (DatPika)`

## Root Resource
The root endpoint ("/") provides a summary of the available resources, with detailed information on each resource, including URIs, available operations, filtering, sorting, and pagination options. The API is structured to offer endpoints for both querying and manipulating data.

## Global Options
- Pagination: `current_page`, `page_size`
- Ordering: `asc`, `desc`

## Available Resources
**`/athletes`**
- Collection URI: `localhost/olympics-api/athletes`
- Singleton URI: `localhost/olympics-api/athletes/{id}`
- Methods: `GET`, `POST`, `PUT`, `DELETE`
- Filtering Options: `country_id`, `gender`, `ethnicity`
- Sorting Options: `Any (validation not implemented)`
- Ordering & Pagination: `Implemented`
- Implemented by: `Daniel Levitin`

**`/coaches`**
- Collection URI: `localhost/olympics-api/coaches`
- Singleton URI: `localhost/olympics-api/coaches/{id}`
- Methods: `GET`, `POST`, `PUT`, `DELETE`
- Filtering Options: `gender`, `sport`, `been_in_olympics`
- Sorting Options: `Any (validation not implemented)`
- Ordering & Pagination: `Implemented`
- Implemented by: `Daniel Levitin`

**`/venues`**
- Collection URI: `localhost/olympics-api/venues`
- Singleton URI: `localhost/olympics-api/venues/{id}`
- Methods: `GET`, `POST`, `PUT`, `DELETE`
- Filtering Options: `venue_name`, `min_capacity`, `max_capacity`, `min_date_constructed`, `max_date_constructed`
- Sorting Options: `venue_id`, `venue_name`, `location`, `capacity`, `type`, `date_constructed`, `address`
- Ordering & Pagination: `Implemented`
- Implemented by: `Hedi Belhassine`

**`/events`**
- Collection URI: `localhost/olympics-api/events`
- Singleton URI: `localhost/olympics-api/events/{id}`
- Methods: `GET`, `POST`, `PUT`, `DELETE`
- Filtering Options: `venue_name`, `min_capacity`, `max_capacity`, `min_date_constructed`, `max_date_constructed`
- Sorting Options: `event_id`, `event_name`, `event_sport`, `start_date`, `end_date`, `number_of_participants`, `is_paralympic`, `venue_id`
- Ordering & Pagination: `Implemented`
- Implemented by: `Hedi Belhassine`


## GET Example: `/venues`
- Fetches all venues.
- Supports filtering by name, capacity range, and construction date.

**Query Parameters:**
- `venue_name`: Filter venues by name. Use partial or full names (e.g., `venue_name=Stadium`).
- `min_capacity`: Specify the minimum seating capacity for venues (e.g., `min_capacity=1000`).
- `max_capacity`: Specify the maximum seating capacity (e.g., `max_capacity=50000`).
- `min_date_constructed`: Filter venues built after a specific date. Format: YYYY-MM-DD (e.g., `min_date_constructed=2000-01-01`).
- `max_date_constructed`: Filter venues built before a specific date. Format: YYYY-MM-DD (e.g., `max_date_constructed=2020-12-31`).
Example: `https://localhost/olympics-api/venues?venue_name=Stade&min_capacity=80000`

**Path Parameters:**
- `GET /venues/{venue_id}`: Fetches a specific venue by venue_id provided in the path (e.g, `https://localhost/olympics-api/venues/18`)
