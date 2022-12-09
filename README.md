# pvcMsg

## Overview

The pvcMsg library is a lean implementation of ICU messaging.  The primary purpose of the library is to 
support messaging in the pvc libraries themselves, where objects may produce informational messages instead of
throwing an exception.  For example, the validator classes do not throw exceptions.  If validation fails,
you can get a message from the validator about why the data was invalid.  If this implementation fits
your use case and for some reason you do not want to use the messaging that comes bundled with whatever framework 
you happen to be using, then of course you can also use it to handle messaging for your application as well.

Like the message implementations in major frameworks, this implementation supports translation into various
languages.  And it uses the ICU library exposed by PHP to format numbers, currency and dates when those
things appear inside messages (e.g. the MessageFormatter class).

The implementation in this library uses a convention of having a message id, which is used as a key to getting
the actual translated message.  The message id is typed as a string, and the library does not know or care whether
you use a convention like "ARG_TOO_BIG" as a key for finding the translated message or you use the full text, a la
"The argument supplied is larger than the maximum permitted value of {number, integer}."  The former perhaps
improves the overall readability in your translation file, the latter provides a nice fallback in case your message
cannot be found in the domain catalog and the system simply returns the "id" untranslated.

## Terminology, Definitions

The language in the documentation for this library mirrors the terminology used in frameworks and in the ICU 
documentation itself.  Below are the definitions of the terms used, and some of these terms parallel the 
names of the classes in the implementation. 

**locale**: although it can be more complicated, a locale is usually a string consisting of a two character script 
code, an underscore or a hyphen, and a two character country code.  The script is the "alphabet" being used.  The 
country code is used to further localize phrases.  For example, there is French in France (FR_fr) and French in 
Canada (FR_ca).

**domain**: a collection of messages.  The underlying implication is that the messages are related in some way.  In a 
small application, it could be as simple as all the text that you want displayed to the user is in a single domain 
(would typically be a domain named "messages").  If you have lots of messages, you might divide them into separate 
domains to make the management of translation easier.

**domain catalog**: a collection of messages for a particular locale.  So if your domain is named "user_messages", you 
might have user_messages translated for english, spanish, italian, etc.  In this implementation, a DomainCatalog object 
can tell you the name of the locale for which it holds translations.  And it can get a message translated into that 
locale based on the "id" of the message.

**msg**: a message is a data structure (class) which holds a msgId, which is necessary to retrieve the message text 
from the domain catalog.  The Msg also holds the names and values of any "parameters" which are to be substituted into 
the message text via placeholders according to the custom for the locale.  In this implementation, a msg is 
completely locale-agnostic.  It has no notion of what locale it is destined for when it gets translated / formatted.

**msg formatter** (FrmtrMsg class): is essentially a wrapper for the native MessageFormatter class.  It takes a domain 
catalog and a message and returns the message text which has been translated / formatted for the proper locale 
so that the message is then ready for display to the user.

## Extensibility

The pvc libraries implement their domain catalogs in php files.  There is a DomainCatalogLoaderInterface, which 
abstracts away the dependency on a file system, so you could implement domain catalogs in a database if you wanted 
to. Further, there is a DomainCatalogFileLoaderInterface, which abstracts away the dependency on the files being php 
files.  So if you wanted to keep your translations in YAML or XLIFF formats, that also is not difficult.



