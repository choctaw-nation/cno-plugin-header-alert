# CNO Header Alert Plugin

A simple WordPress Plugin that allows content managers to add an alert to the top of a site.

## Dependencies

-   Advanced Custom Fields

## Quickstart

[Download this packag](https://github.com/choctaw-nation/cno-plugin-header-alert) and upload it to your site. From there, you can `cd` into the plugin itself and make any changes you need.

If you want to change/edit the ACF fields, simply remove the `$acf_files` array and associated `foreach` loop, and upload the JSON files yourself. _You will need to update the `index.ts` file and `class-header-alert.php` to handle any field changes._

-   Run `npm i` to install the dependencies
-   Run `npm run start` to start the development server, and/or
-   Run `npm run build` to bundle your code and use the minified code on your WordPress site.

---

# Changelog

## v1.0.0

-   Release!
