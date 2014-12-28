## v2.0 - December 28, 2014

- Refactor system structure
- Use Symfony's console component.
- Add unit tests
- Use a shell wrapper for mocking
- Remove Linux support for now

## v1.1 - July 21, 2012

- Created a Benchmarking class

## v1.0 - July 20, 2012

- Show PID on script start-up
- Tested script performance
- Converted the whole script into Object Oriented structure for better performance and readability
- Fixed Linux header issues
- Fixed Linux notification errors

## v0.2.0 - July 19, 2012

- Added the notification system for Linux and OS X Systems

## v0.1.0 - July 19, 2012

- Trace user changes [ Connection and Disconnection ]
- Detect all the headers from the `w` command
	Headers differ for each Operating System and needed to be sorted out as KEYS automatically
- Filter out Connected users and storing them in an associated array
- Filter out SSH connections
- Operating System detection