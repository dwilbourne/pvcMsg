=======
Example
=======

The first step is create a message catalog.  Here is an example of a simple english message catalog with
content pulled from some Symfony examples.::

    <?php

    return [
	    'symfony_great' => 'Symfony is GREAT!',

	    'my_name_is' => 'My name is {name}.',

	    'invitation_title' => '{organizer_gender, select,
            female   {{organizer_name} has invited you to her party!}
            male     {{organizer_name} has invited you to his party!}
            multiple {{organizer_name} have invited you to their party!}
            other    {{organizer_name} has invited you to their party!}
        }',
    ];

The convention for naming such a message catalog file is <domain>.<locale>.<filetype>.  Let's say that the domain for
these messages is something spectacularly uncreative, such as 'messages'.  Thus, the filename for this message catalog
would be 'messages.en.php'.

The next step is to instantiate a DomainCatalog object.  That object requires a loaderFactory, which is responsible for the
mechanics of retrieving the messages from the repository and stuffing them into the DomainCatalog object via its
'load' method.  Then, we can create a MsgFrmtr object, which is created with the DomainCatalog object as its
argument, like so::

            $messagesDirectory = 'path/to/some/messagesFiles/';
            $loaderFactory = new DomainCatalogFileLoaderPHP($messagesDirectory);
            $domainCatalog = new DomainCatalog($loaderFactory);
            $domainCatalog->load($domain, $locale);
            $frmtr = new MsgFrmtr($domainCatalog);

If the steps seem a bit painful, it is due to the two layers of abstraction embedded in the process.  The
first is that messages might not kept in files - they could, for example, be kept in a database. The
second is that even if the messages are in files, we potentially need flexibility to handle different file
formats.  For example, yaml, XLIFF, and json are other possible file types.

Construction of a message requires three parameters:

1. the message id - i.e. the key in the array above which is returned by the message catalog
2. an array of parameters used in the message
3. a 'message domain', representing a group of messages

In this case, the code would look like this::

            $domain = 'messages';
            $testMsgId = 'invitation_title';
            $parameters = ['organizer_gender' => 'female', 'organizer_name' => 'Jane'];
            $value = new Msg($testMsgId, $parameters, $domain);

The way to produce the formatted output is by calling the 'format' method on the formatter with the Msg object as its
parameter.  Like so::

            $frmtr->format($value);

This produces 'Jane has invited you to her party!'.

The pvc mechanics here are straightforward, and the more complicated part is understanding how to create
messages with parameters of different types like dates, numbers, money, etc.  Examples of those things can be found
in a companion pvc library called php_lang_tests.