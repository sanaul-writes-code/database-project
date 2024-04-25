# The Flora Shop

This repository is a fork of the repository https://github.com/requiem-wrld/database-project and includes modifications to enable the display of flower information based on user searches. The modifications involve the addition of backend code `display.php` and modifications to `index.html` to allow redirection to `display.php` upon form submission.

## Changes Made

- Added `display.php`: This PHP file handles the display of flower information based on user searches. It retrieves the search parameters via POST method and fetches relevant flower data from the database by performing sql query on the flower table in the database.

- Modified `index.html`: The modifications made to `index.html` include:
  - Commenting out the JavaScript implementation of search functionality.
  - Adding attributes `action="display.php"` and `method="POST"` to the form with id "searchForm", enabling redirection to `display.php` upon form submission.

## Flower Information Template

The displayed flower information on `display.php` follows the template below:
```
Flower ID: 1
Scientific Name: Rosa chinensis
Regular Name: Chinese Rose
Color: Red
Edibility: Not edible
Survivability out of water: 3
Region: Asia
Amount of Pollen: 0.75
Price: 9.99
```

## Usage

To use the functionality provided by this repository, follow these steps:

1. Ensure that the database containing flower information is properly configured and accessible.
2. Enter the desired flower name in the search field on `index.html`.
3. Upon form submission, you will be redirected to `display.php`, where the flower information corresponding to your search will be displayed.
