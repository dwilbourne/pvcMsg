# pvcMsg

Messages are used throughout the pvc code.  There are two types that extend the base class Msg: UserMsg and ErrorExceptionMsg.  As their names indicate, they have different purposes.  User messages provide feedback to users.  For example, if a user types in an invalid value, you can send back a user message hinting as to how to correct the input error.  ErrorException Messages are used within things implementing Throwable (e.g. errors and exceptions). Most examples of errors and exceptions use a text string as the first argument, which has often been created using an sprintf construct.  For example, $msgtext = sprintf('This is a %s message.', $x) is the kind of thing that might be used as the first argument when throwing an exception.

There are differing schools of thought about whether to echo back data which has created 'a problem' for your code.  Surely it is more helpful in an error exception message to actually see the data if you are a programmer.  Users should never see error or exception messages period.  But you might or might not want to allow them to see invalid data echoed back.  So all of the stock errors and exceptions in PHP have been rebranded inside the pvc framework and modified to use message objects as their first argment.  In this way, the message can bubble up as high as possible before you make a determination as to whether to echo back the data or not.

Here is an example of why this is useful.  Pvc has a a library of validators.  These validators are used both in validating user input but also in validating state in a variety of other objects in the framework.  Thus, a validator object does not know whether it needs to create an ErrorException message or a User message.  All it knows is that in the event some data is invalid, it creates a message.  Higher up in the call stack, there is an object which will know what to do, and it can then easily take the Msg and convert it to either an ErrorExceptionMsg or a UserMsg as appropriate. That is also the point at which you would usually determine whether or not you want to echo back the invalid data in some way.