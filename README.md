# RJWT
![GitHub](https://img.shields.io/github/license/Unknown-Technology-Solutions/RJWT) ![GitHub top language](https://img.shields.io/github/languages/top/Unknown-Technology-Solutions/RJWT) [![FOSSA Status](https://app.fossa.com/api/projects/git%2Bgithub.com%2FUnknown-Technology-Solutions%2FRJWT.svg?type=shield)](https://app.fossa.com/projects/git%2Bgithub.com%2FUnknown-Technology-Solutions%2FRJWT?ref=badge_shield)

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
