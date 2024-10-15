# olympics-api
## Overview
This API provides access to information related to the **Paris 2024 Olympics**, including:
- Athletes
- Coaches
- Countries
- Venues
- Events
- Results

# Routes
Currently implemented routes:
**Endpoint**: `/api/venues`  
**Method**: `GET`
**Venue Endpoints**: `GET /venues`
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
