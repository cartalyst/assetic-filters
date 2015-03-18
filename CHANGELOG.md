# Assetic Filters Change Log

This project follows [Semantic Versioning](CONTRIBUTING.md).

## Proposals

We do not give estimated times for completion on `Accepted` Proposals.

- [Accepted](https://github.com/cartalyst/assetic-filters/labels/Accepted)
- [Rejected](https://github.com/cartalyst/assetic-filters/labels/Rejected)

---

#### v1.2.6 - 2015-03-18

`UPDATED`

- Coding Standards to PSR-2.
- Updated autoloading to PSR-4.

#### v1.2.5 - 2015-02-22

`FIXED`

- Check for REQUEST_URI before assigning it, prevents exceptions from being thrown if executed through cli.

#### v1.2.4 - 2015-02-21

`UPDATED`

- Use latest PHPSass version.

#### v1.2.3 - 2015-01-21

`FIXED`

- Use absolute URL's for assets.

#### v1.2.2 - 2014-09-27

`REVISED`

- Use the Symfony Request class instead of depending on an external method on the less compiler.

#### v1.2.1 - 2014-09-42

`FIXED`

- Fixed a bug compiling relative urls when using subdirectories and symlinks.

#### v1.2.0 - 2014-02-04

`ADDED`

- Added a LessphpFilter.

#### v1.1.0 - 2013-11-27

`ADDED`

- Jason Lewis' URI Rewrite filter from his no-longer-maintained Basset library.

`REVISED`

- Loosened requirements.

#### v1.0.2 - 2015-03-18

`UPDATED`

- Coding Standards to PSR-2.
- Updated autoloading to PSR-4.

#### v1.0.1 - 2013-10-12

`UPDATED`

- Misc updates.

#### v1.0.0 - 2013-04-26

`INIT`

- Initial package release.
