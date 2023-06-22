# Unleash PHP Basic Benchmark

This is a basic benchmark for the Unleash PHP client

This requires that an Unleash server is running at http://localhost:4242/api

You'll need to set a few environment variables to run this:

```
export API_KEY="*:development.25515e987b25b2eb43b99b08d6da9f31b2a8fb194de5644678e99987" # Unleash client token
export TOGGLE_NAME="another" # The name of the toggle you want to check
export ITERATIONS=10000 # The number of iterations to run the benchmark for

```

Install the dependencies:

```
composer install
```

Then run the benchmark:

```
php benchmark.php
```

