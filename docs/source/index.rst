.. toctree::
   :hidden:

   install
   example

===============
pvcMsg Overview
===============

The pvcMsg library is a lean implementation of ICU messaging. The primary purpose of the library is to support
messaging in the pvc libraries themselves.  Pvc tries to minmize dependencies on 3rd party code as much as possible.

Like the message implementations in major frameworks, this implementation supports translation into various languages
. And it uses the ICU library exposed by PHP to format numbers, currency and dates when those things appear inside
messages (e.g. the MessageFormatter class).

The implementation in this library uses a convention of having a message id, which is used as a key to getting the
actual translated message. The message id is typed as a string, and the library does not know or care whether you use
a convention like "ARG_TOO_BIG" as a key for finding the translated message or you use the full text, a la "The
argument supplied is larger than the maximum permitted value of {number, integer}." The former perhaps improves the
overall readability in your translation file, the latter provides a nice fallback in case your message cannot be
found in the domain catalog and the system simply returns the "id" untranslated.


Design Points
#############

* extremely lightweight with no real dependencies outside of pvcInterfaces, pvcErr and the php intl extension.




