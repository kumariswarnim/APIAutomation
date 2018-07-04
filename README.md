# apiAutomation

### Dependencies

TODO

### Running the tests

Assuming you've installed codeception globally, you can run the tests as so:

```sh
$ codecept run --env integration-01 -x ProdOnly --html
```

The above will run the tests against integration-01 endpoints and will generate the results in an html report.

Another example:

```sh
$ codecept run --env production -x IntOnly --html
```

The above will run the tests against production endpoints, will exclude any test with the group annotation 'IntOnly', and will generate the results in an html report.

### Reporting

After the tests run, an html report can be found in the following directory:

```sh
tests/_output/
```

### TODO:

Add info re: We're using this to generate schema for responses:

http://json-schema.org/draft-04/schema#