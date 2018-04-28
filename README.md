# now-playing

> Nuxt.js project


## Docker

```
docker run -it --rm --name now-playing \
    --publish '3000:3000' \
    -e HOST="0.0.0.0" \
    -e CLIENT_ID="<your spotify app client id>" \
    -e CLIENT_SECRET="<your spotify app client secret>" \
    -e REDIRECT_URI="<app domain name>/callback" \
    lunamoonfang/now-playing
```

Example:

```
docker run -it --rm --name now-playing \
    --publish '3000:3000' \
    -e HOST="0.0.0.0" \
    -e CLIENT_ID="wefwefwefwefwefew" \
    -e CLIENT_SECRET="ergergergergergergerg" \
    -e REDIRECT_URI="http://localhost:3000/callback" \
    lunamoonfang/now-playing
```

## Build Setup

``` bash
# install dependencies
$ npm install # Or yarn install

# serve with hot reload at localhost:3000
$ npm run dev

# build for production and launch server
$ npm start
```

For detailed explanation on how things work, checkout the [Nuxt.js docs](https://github.com/nuxt/nuxt.js).

## Backpack

We use [backpack](https://github.com/palmerhq/backpack) to watch and build the application, so you can use the latest ES6 features (module syntax, async/await, etc.).
