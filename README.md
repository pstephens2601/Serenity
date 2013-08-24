Welcome to Serenity | "Serene PHP made easy"
===========================================

The goal of Serenity is to give php developers a easy to learn framework that will make web application development fast and easy.

Full documentation will eventually be avilible at [www.serenephp.com](http://www.serenephp.com),  however, currently this framework is being used for my own personal use while I work out the bugs.

Documentation
------

###Models

The following functions are availible to all of your models through the baseModel class. These functions should be used in most instances for interaction with the database.

*******************************************
find()

This function is used to find and retrive the information for one object for one object in order to populate its attributes.  It can be passed one argument, in the form of the id for the object you wish to find, or 4 arguments in the form of (database column, value, database column, value).  Passing find() 4 arguments in this format will allow you to conduct searches where the values in two columns match the values given.  This use of find can be helpful for functions such as validating user login information.

ex. of a simple login script:

```php
if ($user->find('email', $email_entered, 'password_hash', md5($password_entered))
{
	//code to execute if user is logged in.
}
else
{
	//code to execute if user is logged out
}
```

*******************************************
save()

Saves the information stored in the objects public attributes to the coresponding columns in the database. This function can be passed a single argument in the form of an array, containing information to be assigned to the objects attributes before the information is stored in the database.

The save() function will return true is the save is successful, and false if it is not.  It also requires that the $is_valid attribute of the object being saved is set to true.  This attribute is set to false when information in one the the models attributes fails a validation test set in the model.

ex. of a save to the database:

```php
	$user->save();
```

*******************************************




