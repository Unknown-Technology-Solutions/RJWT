# RJWT
This is the RJWT library that we built for authentication.

### Files/Folders and their purposes

- auth.php
  * This file is an API of sorts that returns JSON values about the authentication status

- index.php & home.php
  * These files are how it could/would be implemented in production

- rjwt_mod.php
  * This file is the actual "module" that contains all the RJWT functions

- *.ini.php.sample
  * These are example configuration files. In production you would copy and rename these and remove the .sample from them.

- configTest.php
  * This file is to test your configuration files

- jwt and radius
  * These folders are the libraries that rjwt_mod.php depend on. They are kept seperate for maintence reasons.
