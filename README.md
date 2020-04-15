# OTIS Category Mapping

## Description

The Goal of this plugin is to allow web admins who use both the ThinkShout OTIS importer plugin,
and a custom taxonomy, to bulk assign new categories to Points of Interest (POIs) within a
Wordpress website. Essentially, this allows you to “remap” categories from the OTIS database to
new custom categories that you define. A developer will likely be needed to perform initial setup.

## Definitions

*   OTIS = The Travel Oregon database containing points of interest across the state.
*   POI = Points of interest content added into WordPress by the OTIS Importer plugin.
*   TIS Taxonomy = Category families assigned to a POI by the OTIS Importer plugin. These
categories also exist in OTIS.
*   New Taxonomy = Category families custom assigned to a POI. These categories don't exist in
OTIS.

## Installation

1. Install ACF plugin
https://www.advancedcustomfields.com/
2. Install and run ThinkShout OTIS importer plugin to populate Wordpress with data.
https://github.com/thinkshout/wp-otis
3. (Optional) Create a custom taxonomy and assign it to POI, ex. Local Region Taxonomy
(alternatively, you could use Wordpress’s default Categories or Tags). You may want to use a
Wordpress plugin that allows you to create custom taxonomies.
4. Add desired terms to your custom taxonomy.
5. Import "acf-json/acf-export-2019-06-26.json" into ACF to set up fields
5. Activate OTIS Category Mapping plugin

## Instructions

1. Click "Add Row"
2. Select an "OTIS Taxonomy"
3. Select a "New Taxonomy"
4. Select "OTIS Term/s"
5. Select "New Term/s"
6. Confirm "Bulk Run" option is checked
7. (Optional, but recommended) Confirm "Hourly run" option is checked
8. Click "Update" to bulk assign new categories to POIs

###### Regarding data loss
For every "New Taxonomy" selected, running "Update" will first remove all assigned terms for the POIs.
Then new terms will be added per the assignments below. This means any "New Taxonomy" terms you
manually added will be removed.

###### About OTIS data source
The OTIS database contains a variety of fields including Types, Categories, and Collections.
Perhaps the most important for broad categorization is Types. The field labels for Types is set by
the database admin. For more information on OTIS data, see the following resources.

*   API documentation https://otis.traveloregon.com/docs/specification.html
*   OTIS cheat sheet
https://docs.google.com/spreadsheets/d/1Sj1V9DIJx1PpT1UloA0nppH31bVejso7cGaYmjrUuFw/edit?usp=sharing

###### License
GPLv2 or later
http://www.gnu.org/licenses/gpl-2.0.html

## Changelog

### 1.0.0
* First Release
* Coding: Anne Schmidt Co., https://anneschmidt.co
* Project Management and Testing: Cardwell Creative, https://www.cardwellcreative.com
* Funded by: Travel Oregon
* First plugin adopter: Tillamook Chamber of Commerce
