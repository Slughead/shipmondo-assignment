## Shipmondo Assignment 2025
This project is made as a submission to the assigment given here: https://github.com/NovitasDK/shipmondo-backend-assignment

### Limitations:
    1. Error handling.
    This has deliberately not been implemented fully - it seemed beyond the scope, but should definitely be handled properly in a production environment.

    2. Currency as float value.
    Handling currencies in float values might yield some rounding issues in the long run. Could be solved by using the full amount in cents, saved as an unsigned integer, and then adjusted upon display.

    3. No ORM
    The data models I've made are not exactly ORM's - more like a simplistic layer to communicate with each table using PDO, separated into models. They don't represent a single row of those tables, however.

    4. Tests
    There are no tests :(

### Potential expansions:
    1. More endpoint coverage.
    Obviously, more endpoints could be implemented as needed, but I've chosen the YAGNI (you ain't gonna need it) approach to this, so I've stuck to the two endpoints given by the assignment.

    2. UI.
    I suppose we could add a UI for this, giving the user more control of the available actions here, instead of using the hardcoded API simulations.

    3. ORM.
    One could consider using actual ORM data models referencing to the database table rows. Although it's not always the case, that you'd want to use ORMs.
    
    4. Data migrations
    Creating the data schemas via functions like that is not really ideal. A better solution could be to have actual migration scripts that ensure the correct state of the database.

    5. Abstractions
    This project is using concrete classes instead of abstractions - using abstractions where it makes sense, would be a very nice addition - would also apply more to the SOLID principles.

    6. Dependency Injection
    In light of the missing abstractions mentioned above, it could be nice to use a proper container to create the objects with, using the depency injection instead of manually newing objects up and sending them along to the function parameters. 

    7. Output formatting
    Since this assignment specifically said not to focus on the UI, I have purposely neglected that part - In that regard there is also formatting the readable outputs from the code. It's not particularly pretty, and could certainly be done better - but it mainly makes sense to do so if the project has a UI.

    8. Tests
    For God's sake, get some test coverage! :D Maybe even using TDD for the expansions - that would be nice.


### Example run-through output
```
C:\Code\PHP\shipmondo-assignment>php index.php

 - [action] Fetching the account balance remotely via the API:
Array
(
    [amount] => 99999649
    [currency_code] => DKK
    [date] => 2025-07-01 21:07:39
)

 - [action] Saving the fetched balance in the database.

 - [action] Getting the current balance (newest row in the database):
Array
(
    [id] => 20
    [amount] => 99999649.00
    [currency_code] => DKK
    [date] => 2025-07-01 21:07:39
)


 - [action] Creating a shipment remotely via the API.
Array
(
    [package_number] => 056212039154
    [shipment_id] => 25909289
)

 - [action] Saving the created shipment in the database.

 - [action] Fetching the account balance remotely via the API:
Array
(
    [amount] => 99999599
    [currency_code] => DKK
    [date] => 2025-07-01 21:07:41
)

 - [action] Saving the fetched balance in the database.

 - [action] Getting the current balance (newest row in the database):
Array
(
    [id] => 21
    [amount] => 99999599.00
    [currency_code] => DKK
    [date] => 2025-07-01 21:07:41
)

C:\Code\PHP\shipmondo-assignment>_
```