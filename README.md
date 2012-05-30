Cardprocessor Emulator
======================

This is a light-weight emulator of what could be a card processor. It's designed to aid in development of a card processor API recieving end.

## Setup
If you're running PHP 5.4 or greater, you can simply type in the terminal `./server`

Currently the SQL setup file is not available.

## Accessing Data
You can access data in either an XML or JSON format (default to JSON). Requests are in the format of:

`localhost:3000/Company?format=xml&username=..&password=..`

Note that you will have to specify your username/password each time when making an API call.

### Companies
To create a new company:

`/Company/new?username=username&password=password&name=CompanyName`

Which will return the ID of the company that was created.

To view company data:

`/Company?username=..&password=..`

### Persons
A person is somebody who has a card and can make transactions.

Attributes:
* first_name
* last_name
* address
* address_1
* city
* state (two-leter code)
* zipcode
* phone
* ssn

No attributes are required


To view all people for the current company:

`Person?username...`

To make a new person:

`/Person/new?username..&password=..&attribute=value&attribute2=value`

To view a specific person:

`Person/view?personId=thePersonId`

### Accounts
To view an account for a particular user:

`/Person/accounts`

To create an account for a person:
`/Person.createAccount`


### Cards

Attributes:
* status
* number
* expiration
* balance

To issue a card (returns card number, expiration date, etc)

`Account/issueCard?accountId=theAccountId`

To view cards for an account:

`Account/cards`

To view more details about a particular card:

`Card?cardNum=someCardNumber`

OR you can use the card ID instead of cardNum, so you don't need to store card numbers in your database:

`Card?cardId=someCardId`

To load balance to a card (may fail if it caused card balance to go below zero or card is deactivated):

`Card/loadBalance?cardNum=num&amount=12.345`

To deactivate a card (cannot be undone!):

`Card/deactivate?cardNum=num`


### Transactions
Represents transactions made.

Attributes:
* card_id
* amount
* merchant
* description
* type

To view transactions for a particular card:

`Card/transactions?cardNum=someCardNumber`


Or for a particular account:

`Account/transactions`