# Factory for CakePHP

## Installation

Clone the application inside your Plugins folder

	$ git clone https://github.com/aeolu/cakefactory.git CakeFactory
	
Load it and make sure you read the Plugin's bootstrap folder. Append this to your `Config/bootstrap.php`:

	CakePlugin::load('CakeFactory', array('bootstrap' => true));
	

## Settings

The default location of your factories in the bootstrap here `Plugin/CakeFactory/Config/bootstrap.php`

	define('FACTORY', ROOT . DS . APP_DIR . DS . 'Test' . DS . 'Factory');


## Creating Factories

You can create your factories by default inside your `Test/Factory/`. Name it with `ModelName.json`

So, if you have a user that's related to a roles file, you'll have files `User.json` and `Role.json`


### Role.json

	{
		"name": "Administrator"
		"description": "Access to anything and everything"
	}
	
### User

	{
		"username": "username#{n}",
		"password": "a valid password",
		"password_confirmation": "a valid password",
		"role_id": {
			"model": "Role",
			"attributes": {
				"name": "Standard"
			}
		}
	}
	
	
## Notes

### Creating counters

Just add `#{n}` inside and it'll be the counter for unique stuff

### Associating Factories

Added this just in case custom relations are used

	"role_id": {
		"model": "Role"
	}
	
### Overriding Association Values

You can see above, but wait, YOU CAN NEST IT!

	"user_id": {
		"model": "User",
		"attributes": {
			
			"role_id": {
				"model": "Role",
				"attributes": { "name": "Standard" }
			}
			
		}
	}
	
	
## License

This is released under WTFPL. So, do what the eff, you want with it. Though tell me so I can feel that fuzzy self-esteem stuff.