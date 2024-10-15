# olympics-api
## Overview <a id="overview"></a>
This API provides access to information related to the **Paris 2024 Olympics**, including:
- Athletes
- Coaches
- Countries
- Venues
- Events
- Results

# Routes <a id="routes"></a>
Currently implemented routes:
## `GET /venues`
- Fetches all venues.
- Supports filtering by name, capacity range, and construction date.

**Query Parameters:**
- venue_name: Filter venues by name. Use partial or full names (e.g., venue_name=Stadium).
- min_capacity: Specify the minimum seating capacity for venues (e.g., min_capacity=1000).
- max_capacity: Specify the maximum seating capacity (e.g., max_capacity=50000).
- min_date_constructed: Filter venues built after a specific date. Format: YYYY-MM-DD (e.g., min_date_constructed=2000-01-01).
- max_date_constructed: Filter venues built before a specific date. Format: YYYY-MM-DD (e.g., max_date_constructed=2020-12-31).
Example: https://localhost/olympics-api/venues?venue_name=Stade&min_capacity=80000

**Path Parameters:**
- GET /venues/{venue_id}: Fetches a specific venue by venue_id provided in the path (e.g, https://localhost/olympics-api/venues/18)
##

## `GET /events`
 -Fetches all events.
- Supports filtering by event name, number of participants, and whether the event is Paralympic.

**Query Parameters:**
- event_name: Filter events by name. Use partial or full names (e.g., event_name=Swimm).
- min_participants: Specify the minimum number of participants for the event (e.g., min_participants=5).
- max_participants: Specify the maximum number of participants for the event (e.g., max_participants=100).
- is_paralympic: Filter events based on whether they are part of the Paralympics. Acceptable values are:
  - 0: Non-Paralympic event
  - 1: Paralympic event
Example: https://localhost/olympics-api/events?is_paralympic=0&min_participants=10&max_participants=100

**Path Parameters:**
- GET /events/{event_id}: Fetches a specific event by event_id provided in the path (e.g, https://localhost/olympics-api/events/20)
##


# Validation Helper <a id="validationhelper"></a>
Custom methods added to the ValidationHelper class for validating request parameters:

## `isDateRangeValid($request, string $date, string $minOrMax): bool`
Checks whether a given date is valid based on the provided minOrMax constraint.

 **Parameters:**
 - $request: The HTTP request for error handling.
 - $date: The date string in YYYY-MM-DD format.
 - $minOrMax: Specifies whether the date is a minimum or maximum date for the error message to be displayed on the client side.
 - Throws: A HttpBadRequestException if the date is missing or the format is invalid.


## `minMaxValidation($request, $min, $max, $type, $param_name)`
Validates that a minimum value is smaller than a maximum value for integer or date ranges.
 
 **Parameters:**
 - $request: The HTTP request for error handling.
 - $min: The minimum value provided by the client.
 - $max: Maximum value  provided by the client.
 - $type: The datatype of the values (int or date) since each is handled different.
 - $param_name: Name of the parameter specified by the client. Required for the error message to be displayed on the client side.
 - Throws: A HttpBadRequestException if the validation fails.

## `isNameValid($request, $name, $resource): bool`
Check weather a name consists of letters and spaces only.

**Parameters:**
- $request: The HTTP request for error handling.
- $name: The name to be validated (e.g, venue_name or event_name).
- $resource: The type of resource being validated (e.g., venue or event).
- Throws: A HttpBadRequestException if the name is missing or invalid.
