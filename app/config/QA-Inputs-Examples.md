# Sample Markdown File

This is a sample Markdown file to serve as a template for documenting your web service's resources and their inputs.

`NOTE:` This file contains the documentation for POST, PUT, and DELETE operations. However, you should also include documentation for the GET operations and the filters supported on resources.

## Examples of Correct Inputs for /disasters

### POST /disasters

```json
[
  {
    "name": "winter storm",
    "description": "A winter storm is freezing rain which comes with violent winds, low temperature, and lot of snow and ice.",
    "avg_temperature": -30,
    "avg_precipitation": 80,
    "avg_air_quality": 20,
    "avg_humidity": 40,
    "avg_pressure": 30
  },
  {
    Etc.
  }
]
```

### PUT /disasters
-> disaster_id is mandatory
-> everything else is optional, BUT a minimum of one is required
```json
[
  {
    "disaster_id": 1,
    "name": "earthquake",
    "description": "An earthquake is a sudden and violent shaking of the ground.",
    "avg_temperature": 20,
    "avg_precipitation": 20,
    "avg_air_quality": 50,
    "avg_humidity": 32,
    "avg_pressure": 50
  },
  {
    "disaster_id": 2,
    "avg_pressure": 30
  },
  {
    Etc.
  }
]
```

### DELETE /disasters
```json
[
  5,
  6,
  Etc.
]
```

## Examples of Incorrect Inputs for /disasters

### POST /disasters
```json
[
  {
    "name": 23,
    "description": "A winter storm is freezing rain which comes with violent winds, low temperature, and lot of snow and ice.",
    "avg_temperature": 2.4,
    "avg_deaths": 2003
  },
  {
    "name": "winter storms"
  }
]
```

### PUT /disasters
```json
[
  {
    "disaster_id": "winter storm",
    "name": "earthquake",
    "avg_temperature": 20,
    "avg_precipitation": 20,
    "avg_air_quality": 50,
    "avg_humidity": 32,
    "avg_pressure": 50
  },
  {
    "disaster_id": 2,
  }
]
```

### DELETE /disasters
```json
[
  "Remove Storms",
  "Remove id number 3"
]
```


## Examples of Incorrect Inputs for /distance/{country_id}

### POST /distance
```json
{
  "units": [
    "all",
    "m",
    "km",
    unit
  ]
}
```

```json
{
  "latitude": 46.2276,
  "longitude": -2.2137,
  "units": [
    
  ]
}
```

## Examples of Correct Inputs for /account

### POST /register
-> only one account at a time
```json
{
  "first_name": "Jordan",
  "last_name": "Chea",
  "email": "jordanchea@gmail.com",
  "password": "Web_Services",
  "role": "admin"
}
```

## Examples of Incorrect Inputs for /account

POST /register
-> only one account at a time
```json
[
  {
    "first_name": "Jordan",
    "last_name": "Chea",
    "email": "jordanchea@gmail.com",
    "password": "Web_Services",
    "role": "admin"
  },
  {
    "first_name": "Jordan",
    "last_name": "Chea"
  }
]
```

## Examples of Correct Inputs for /token

### POST /token
```json
{
  "email": "jordanchea@gmail.com",
  "password": "Web_Services"
}
```

## Examples of Incorrect Inputs for /token

### POST /token
```json
{
  "email": jordanchea@gmail.com,
  "password": ***
}
```
