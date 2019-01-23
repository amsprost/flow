Flow
====

Flow is a light-weight eventsourcing, state and projection framework.

## Features:

* Events are just multi-dimensional arrays. No custom object-model to learn or conform to
* Projectors are simple to write, and operate on array data
* Simple state management included, with a base class for state-based projectors
* Extensive use of Interfaces, so EventStores, Projectors and State Stores can all be easily swapped out and optimized
* In-memory and database-backed event and state stores
* Designed to be used as a library in event-based applications

## Example

The `example/` directory contains a simple example with events, projectors, etc.

You can run it by executing:

    php example/example.php

It will output the states of relevant entities as JSON on stdout.

### Database initialization

The example can also be executed with database backed event and state stores. Initialize your database using:

    ./vendor/bin/dbtk-schema-loader schema:load example/schema.xml mysql://user:password@localhost/flow --apply

### Database configuration

The example script loads it's database configuration from the environment variable `FLOW_EXAMPLE_DSN`. The easiest way to set it is to copy `.env.dist` to `.env`, and update the configuration based on your database settings.

If a `.env` exists, it's configuration is automatically loaded into the environment

If `FLOW_EXAMPLE_DSN` is not defined, in-memory (array) based event- and state stores will be used. These are much faster, but don't support persistence, and will not scale as well as database backed stores.

## License

MIT (see [LICENSE.md](LICENSE.md))

## Brought to you by the LinkORB Engineering team

<img src="http://www.linkorb.com/d/meta/tier1/images/linkorbengineering-logo.png" width="200px" /><br />
Check out our other projects at [linkorb.com/engineering](http://www.linkorb.com/engineering).

Btw, we're hiring!

