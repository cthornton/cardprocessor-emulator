Cardprocessor Emulator
======================

This is a light-weight emulator of what could be a card processor. It's designed to aid in development of a card processor API receiving end.

This is **not practical for real life use**!!!

## Setup
To setup the database, edit the `db/config.php` file. Afterwards, type `./project migrate` in the terminal to setup the database.

If you're running PHP 5.4 (via the Macports package `php54`) you can simply type in the terminal `./project server` to run a development server.

## Accessing Data
You can access data in either an XML or JSON format (default to JSON). Requests are in the format of:

`localhost:3000/Company?format=xml&username=..&password=..`

Note that you will have to specify your username/password each time when making an API call (except when creating a company). You may use either POST or GET requests.

## Attributes
Each object has specific attributes and will be listed like such further in the documentation:
* + attribute* (datatype): description
* # attribute (datatype): description
* - attribute (datatype): description

`+` indicates that this attribute may be edited after creation.


`#` indicates that this attribute may be edited *only* on creation. 

`-` indicates that this attribute may never be specified and is created automatically. 

`~` indicates that this attribute is **required** (cannot be blank)

You may notice some attributes that you would imagine to be integers are actually strings (such as phone number). This is not a mistake; some attributes (such as zipcode) may not validate and will accept any garbage input that is passed to it. As such, it is *your* responsibility to make sure that these values returned are valid. For example, be cautious directly parsing a zipcode into an integer.

## Returning Data
You can use XML or JSON. I recommend using XML.

### XML
A XML request will ALWAYS have this body:

	<?xml version="1.0" encoding="UTF-8" ?>
	<response>
		<error code="0" errors="false">Error String</error>
		<body>
			More elements or a more detailed error description
		</body>
	</response>
	

In the event of no errors, the response will always have an array of elements, even if there is one, as such:

	...
	<body>
		<element>
			<attribute>Value</attribute>
			<attribute2>Value</attribute>
			...
		</element>
	</body>
	

Each attribute should be unique and repeated with each element. This should be very easy to get via xpath, such as `//body/*`

#### Error Handling
*Only check for errors by looking at the error tag*!!! Do NOT look for errors by checking any other tag! Each XML response will *always* have the tag `<error code="code" errors="true or false">Error String</error>`, regardless of any errors.

To check for errors, see if `errors="true"` is there. This can *easily* be gotten by using xpath, such as `//error[@errors='true']`.

## Companies
You must first create a company. Afterwards, you must **always log in using the created username and password**.

There is no way to retrieve a list of companies, so make sure to keep track of them yourself.

### Attributes
* - id (int): the unique ID of the company. Never used for anything
* ~ # name (string): A human-readable name of the company (i.e. "Easy Co")
* ~ # username (string): The username that this company will log in with
* ~ # password (string): The password that this company will log in with

### Actions

**Create a new company** `/Company/new?username=username&password=password&name=CompanyName`

Note this is one of the few irregular calls and will return an XML in the format of:
	
	<body>
		<companyId>numeric ID</companyId>
	</body>

**View company data:** `/Company?username=..&password=..`

Note this is one of the few irregular calls and will return an XML in the format of:
	
	<body>
		<id>company ID</id>
		<username>company Username</username>
	</body>


## Persons
A person is somebody who has a card and can make transactions.

### Attributes:
* - id (int): unique person ID
* + first_name (string)
* + last_name (string)
* + address (string)
* + address_1 (string)
* + city (string)
* + state (string): a two-leter code
* + zipcode (string)
* + phone (string)
* + ssn (string)

No attributes are required

### Actions

View all people for the current company:  `/Person...`

Make a new person: `/Person/new?&first_name=value&attribute2=value`

View a specific person: `/Person/view?personId=thePersonId`

Update a person: `/Person/update…`

