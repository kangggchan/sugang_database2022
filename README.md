# SUGANG

SUGANG is a web-based course registration application.

## Installation

Step 1: Connect with your database.
Step 2: Run all of the queries in [2021117446_codes.sql](./2021117446_codes.sql) to set up database.
Step 3: Use phpMyAdmin to import data from [Data](./data/) folder (COURSE, STUDENT).
Step 4: In [dbconfig.php](./dbconfig.php), change mysqli_connect attributes to connect with your database with the form ("host", "username", "password", "Database_Name")
Step 5: Open [index.php](./index.php) to run the application.

## Usage

```python
import foobar

# returns 'words'
foobar.pluralize('word')

# returns 'geese'
foobar.pluralize('goose')

# returns 'phenomenon'
foobar.singularize('phenomena')
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](https://choosealicense.com/licenses/mit/)