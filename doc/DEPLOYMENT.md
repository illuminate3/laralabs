# Deployment

Done using Shipit JS.

## Dependencies pulled via NPM (`package.json`)

```
"gulp-shell": "^0.5.2",
"shipit-bower": "^0.2.0",
"shipit-captain": "^0.4.3",
"shipit-cli": "^1.4.0",
"shipit-composer": "^0.0.5",
"shipit-deploy": "^2.1.2",
"shipit-npm": "^0.2.0",
"shipit-shared": "^4.4.0"
```

## Requirements on development machine

<TO BE DETAILLED>

## Setting up deployment machine

```
$ npm install
$ cp deploy.json.example deploy.json
```

Then configure the deployment:
 
 - `deploy.json` contains general configuration
 - `shipit.js` contains deployment tasks you can use or customize

## How to deploy

In PowerShell

```
$ shipit my-environment deploy 
```

`my-environment` being the environment to deploy to (`staging`, `production`, etc.) 