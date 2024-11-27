# QA Inputs Documentation

This is the Markdown file to serve as a use guide for documenting our `olypics-api` web service's resources and their inputs for Quality Assurance testing purposes.

*`NOTE: "can be used independently" means that the parameters shown underneath can be used in any combination.`*

## GET Operations

### Examples of correct URIs for /athletes resource:

- **/athletes**

Expected Output:

```json
//...
```

#### Pagination

Either parameter can be used independently.

- **/athletes?current_page=3&page_size=9**

Expected Output:

```json
//...
```

#### Filtering

Either parameter can be used independently.

*`NOTE: Some combinations may not yield any results.`*

- **/athletes?gender=Female&ethnicity=Mexican&country_id=85**

Expected Output:

```json
//...
```

#### Sorting

- **/athletes?sort_by=sport&order_by=desc**
- **/athletes?sort_by=date_of_birth&order_by=asc**
- **/athletes?sort_by=height&order_by=desc**
- **/athletes?sort_by=weight&order_by=asc**
- **/athletes?sort_by=gold_medals&order_by=desc**
- **/athletes?sort_by=silver_medals&order_by=asc**
- **/athletes?sort_by=bronze_medals&order_by=desc**
- **/athletes?sort_by=total_medals&order_by=asc**

Expected Output for **`/athletes?sort_by=sport&order_by=desc`** :

```json
//...
```
